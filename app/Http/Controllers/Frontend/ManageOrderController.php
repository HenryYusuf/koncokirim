<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    public function userAllOrders()
    {
        $userId = Auth::user()->id;

        $allUserOrder = Order::where('user_id', $userId)->orderBy('id', 'asc')->get();

        return view('frontend.dashboard.order.all_order', compact('allUserOrder'));
    }

    public function userOrderDetails(Order $order)
    {
        $order = Order::with('user')->where('id', $order->id)->where('user_id', Auth::id())->first();

        $orderItem = OrderItem::with('product')->where('order_id', $order->id)->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $key => $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('frontend.dashboard.order.order_details', compact('order', 'orderItem', 'totalPrice'));
    }

    public function userOrderInvoiceDownload(Order $order)
    {
        $order = Order::with('user')->where('id', $order->id)->where('user_id', Auth::id())->first();

        $orderItem = OrderItem::with('product')->where('order_id', $order->id)->orderBy('id', 'desc')->get();

        $totalPrice = 0;
        foreach ($orderItem as $key => $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        $serviceFee = 2000;
        $totalPayment = $order->total_amount;

        $pdf = Pdf::loadView('frontend.dashboard.order.invoice_download', compact('order', 'orderItem', 'totalPrice', 'serviceFee', 'totalPayment'))
            ->setPaper('a4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path()
            ]);

        return $pdf->download('invoce.pdf');
    }
}
