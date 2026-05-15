<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('table');
        if (!empty($tableNumber)) {
            Session::put('tableNumber', $tableNumber);
        }
        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('tableNumber', 'items'));
    }

    // Cart

    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
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
            'cart' => $cart
        ]);
    }

    public function updateCart(Request $request, $id)
{
    $newQty = (int) $request->input('qty');

    if ($newQty < 1) {
        return response()->json([
            'success' => false,
            'message' => 'Quantity must be at least 1'
        ]);
    }

    $cart = Session::get('cart', []);
    if (isset($cart[$id])) {
        $cart[$id]['qty'] = $newQty;
        Session::put('cart', $cart);
        Session::flash('success', 'Cart updated successfully');

        return response()->json([
            'success' => true,
            'message' => 'Cart updated'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Item not found in cart'
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
            'message' => 'Item removed'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Item not found in cart'
    ]);
}

// checkout
public function checkout()
{
    $cart = Session::get('cart', []);
    if(empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty');
    }

    $tableNumber = Session::get('tableNumber');

    return view('customer.checkout', compact('cart', 'tableNumber'));
}

public function storeOrder(Request $request)
{
    $cart = Session::get('cart', []);
    $tableNumber = Session::get('tableNumber');
    
    if(empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty');
    }

    $validator = Validator::make($request->all(), [
        'fullname' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
    ]);
    
    if($validator->fails()) {
        return redirect()->back()->route('checkout')->with('error', $validator->errors()->first());
    }
    
    $total = 0;
    foreach($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $order = new Order();
    $order->table_number = $tableNumber;
    $order->total = $total;
    $order->status = 'pending';
    $order->save();

    foreach($cart as $item) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->menu_id = $item['id'];
        $orderItem->quantity = $item['qty'];
        $orderItem->price = $item['price'];
        $orderItem->save();
    }

    $totalAmount = 0;
    foreach($cart as $item) {
        $totalAmount += $item['price'] * $item['qty'];
    }
    $itemDetails[] = [
        'id' => $item['id'],
        'name' => substr($item['name'],0,50),
        'price' => $item['price'] + $item('price') * 0.1,
        'qty' => $item['qty']
    ];

    $user = User::firstOrCreate ([
        'name' => $request->fullname,
        'phone' => $request->phone,
        'role_id' => 4
    ]);

    $order = Order::create([
        'order_code' => 'ORD-' .$tableNumber. '-' . time(). '-' . $user->id,
        'user_id' => $user->id,
        'subtotal' => $totalAmount,
        'tax' => $totalAmount * 0.1,
        'grand_total' => $totalAmount * (0.1 * $totalAmount),
        'status' => 'pending',
        'table_number' => $tableNumber,
        'total_amount' => $totalAmount,
        'payment_method' => $request->payment_method,
        'notes' => $request->notes,
    ]);

    foreach ($cart as $itemId => $item) {
    OrderItem::create([
        'order_id' => $order->id,
        'item_id' => $itemId,
        'quantity' => $item['qty'],
        'price' => $item['price'] * $item['qty'],
        'tax' => 0.1 * $item['price'] * $item['qty'],
        'total_price' => $item['price'] * $item['qty'] + (0.1 * $item['price'] * $item['qty']),
    ]);

    }

    Session::forget('cart');
    
    return redirect()->route('menu')->with('success', 'Order placed successfully');
}

}
