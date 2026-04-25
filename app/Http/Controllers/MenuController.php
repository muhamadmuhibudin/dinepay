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
}
