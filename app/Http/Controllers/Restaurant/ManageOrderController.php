<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    public function restaurantAllOrders()
    {
        $restaurantId = Auth::guard('restaurant')->id();

        $orderItemGroupData = OrderItem::with(['product', 'order'])
            ->where('restaurant_id', $restaurantId)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');

            return view('restaurant.backend.order.all_orders', compact('orderItemGroupData'));
    }

    public function restaurantOrderDetails(Order $order)
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $order = $order->load('user');
        $orderItem = OrderItem::with('product')->where('order_id', $order->id)->where('restaurant_id', $restaurantId)->orderBy('id', 'asc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $key => $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('restaurant.backend.order.restaurant_order_details', compact('order', 'orderItem', 'totalPrice'));
    }
}
