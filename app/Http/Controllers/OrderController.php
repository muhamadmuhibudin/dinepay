<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('admin.order.show', compact('order', 'orderItems'));
    }
    
    public function settlement($id)
{
    $order = Order::findOrFail($id);
    
    if ($order->status !== 'pending') {
        return back()->with('error', 'Order is already settled.');
    }

    $order->status = 'settlement';
    $order->save();
    
    return redirect()->route('admin.orders.index')->with('success', 'Order settled successfully');
}
}
