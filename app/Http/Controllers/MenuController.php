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
        if (!$tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('tableNumber', 'items'));
    }

    public function cart()
    {
        $cart = session::get('cart', []);
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

        $cart = session::get('cart', []);
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
        session::put('cart', $cart);
        return response()->json([
            'status' => 'success',
            'message' => 'Item added to cart',
            'cart' => $cart
        ]);
    }
}
