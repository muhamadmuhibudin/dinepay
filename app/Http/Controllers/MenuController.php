<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('table');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
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
                'qty' => 1
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

}
