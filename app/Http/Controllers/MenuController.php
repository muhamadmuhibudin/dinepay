<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('table');
        if (! empty($tableNumber)) {
            Session::put('tableNumber', $tableNumber);
        }
        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('tableNumber', 'items'));
    }

    public function cart()
    {
        $cart = Session::get('cart', []);

        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (! $menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found',
            ], 404);
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->img,
                'qty' => 1,
                'category' => $menu->category->cat_name,
            ];
        }
        Session::put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Item added to cart',
            'cart' => $cart,
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $newQty = (int) $request->input('qty');

        if ($newQty < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity must be at least 1',
            ]);
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $newQty;
            Session::put('cart', $cart);
            Session::flash('success', 'Cart updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart',
        ]);
    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            Session::flash('success', 'Item removed from cart');

            return response()->json([
                'success' => true,
                'message' => 'Item removed',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart',
        ]);
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }

        $tableNumber = Session::get('tableNumber');

        return view('customer.checkout', compact('cart', 'tableNumber'));
    }

    public function storeOrder(Request $request)
    {
        $cart = Session::get('cart', []);
        $tableNumber = (int) Session::get('tableNumber', 1);

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'payment_method' => ['required', Rule::in(Order::paymentMethods())],
            'note' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $validated = $validator->validated();
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $tax = (int) round($subtotal * 0.1);
        $grandTotal = $subtotal + $tax;

        $order = DB::transaction(function () use ($cart, $grandTotal, $subtotal, $tableNumber, $tax, $validated) {
            $user = User::firstOrCreate(
                [
                    'phone' => $validated['phone'],
                ],
                [
                    'username' => Str::slug($validated['fullname'] . rand(100, 999)),
                    'fullname' => $validated['fullname'],
                    'role_id' => 4,
                ]
            );

            $order = Order::create([
                'order_code' => 'ORD-' . $tableNumber . '-' . time() . '-' . $user->id,
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'status' => 'pending',
                'table_number' => $tableNumber,
                'payment_method' => $validated['payment_method'],
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($cart as $itemId => $item) {
                $lineSubtotal = $item['price'] * $item['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'tax' => 0.1 * $lineSubtotal,
                    'total_price' => $lineSubtotal + (0.1 * $lineSubtotal),
                ]);
            }

            $order->load('user');
            return $order;
        });

        $cartItems = $cart;
        Session::forget('cart');

        if ($validated['payment_method'] === 'tunai' || $validated['payment_method'] === 'cash') {
            return response()->json([
                'status' => 'success',
                'redirect_url' => route('checkout.success', ['orderId' => $order->order_code]),
            ]);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?? config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$clientKey = config('midtrans.client_key') ?? config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY');
        \Midtrans\Config::$isProduction = (bool) (config('midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $itemDetails = [];
        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id' => (string) $item['id'],
                'price' => (int) $item['price'],
                'quantity' => (int) $item['qty'],
                'name' => substr($item['name'], 0, 50),
            ];
        }

        if ($tax > 0) {
            $itemDetails[] = [
                'id' => 'TAX-10',
                'price' => (int) $tax,
                'quantity' => 1,
                'name' => 'Tax (10%)',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) $order->grand_total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->user->fullname ?? 'Customer',
                'phone' => $order->user->phone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'status' => 'success',
                'snapToken' => $snapToken,
                'order_code' => $order->order_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Midtrans Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::where('order_code', $orderId)->first();

        if (! $order) {
            return redirect()
                ->route('menu.index')
                ->with('error', 'Order not found');
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        if ($order->payment_method === 'qris' && $order->status === 'pending') {
            $order->update([
                'status' => 'settlement',
            ]);
        }

        return view('customer.success', compact(
            'order',
            'orderItems'
        ));
    }
}