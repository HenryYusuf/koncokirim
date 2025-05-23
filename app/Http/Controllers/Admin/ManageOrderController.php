<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageOrderController extends Controller
{
    public function adminPendingOrders()
    {
        $orders = Order::where('status', 'Pending')->orderBy('created_at', 'asc')->get();

        return view('admin.backend.order.pending_order', compact('orders'));
    }
    public function adminConfirmOrders()
    {
        $orders = Order::where('status', 'Confirm')->orderBy('created_at', 'asc')->get();

        return view('admin.backend.order.confirm_order', compact('orders'));
    }
    public function adminProcessingOrders()
    {
        $orders = Order::where('status', 'Processing')->orderBy('created_at', 'asc')->get();

        return view('admin.backend.order.processing_order', compact('orders'));
    }
    public function adminDeliveredOrders()
    {
        $orders = Order::where('status', 'Delivered')->orderBy('created_at', 'asc')->get();

        return view('admin.backend.order.delivered_order', compact('orders'));
    }
    public function adminCanceledOrders()
    {
        $orders = Order::where('status', 'Canceled')->orderBy('created_at', 'asc')->get();

        return view('admin.backend.order.canceled_order', compact('orders'));
    }

    public function adminOrderDetails(Order $order)
    {
        $order = $order->load('user');
        $orderItem = OrderItem::with('product')->where('order_id', $order->id)->orderBy('id', 'asc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $key => $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('admin.backend.order.admin_order_details', compact('order', 'orderItem', 'totalPrice'));
    }

    public function adminPendingToConfirmOrder($id)
    {
        Order::find($id)->update([
            'confirmed_date' => Carbon::now(),
            'status' => 'Confirm'
        ]);

        $notification = array(
            'message' => 'Order Confirmed Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.confirm.orders')->with($notification);
    }

    public function adminConfirmToProcessingOrder($id)
    {
        Order::find($id)->update([
            'processing_date' => Carbon::now(),
            'status' => 'Processing'
        ]);

        $notification = array(
            'message' => 'Order Processing Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.processing.orders')->with($notification);
    }

    public function adminProcessingToDeliveredOrder($id)
    {
        Order::find($id)->update([
            'delivered_date' => Carbon::now(),
            'status' => 'Delivered'
        ]);

        $notification = array(
            'message' => 'Order Delivered Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.delivered.orders')->with($notification);
    }

    public function adminCancelOrder($id)
    {
        Order::find($id)->update([
            'canceled_date' => Carbon::now(),
            'status' => 'Canceled'
        ]);

        $notification = array(
            'message' => 'Order Canceled Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.canceled.orders')->with($notification);
    }
}
