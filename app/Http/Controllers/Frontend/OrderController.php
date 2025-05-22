<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function userCashOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $carts = Session::get('cart', []);
        $totalAmount = 0;

        foreach ($carts as $key => $cart) {
            $totalAmount += ($cart['price'] * $cart['quantity']);
        }

        if (Session::has('coupon')) {
            $total = (Session::get('coupon')['discount_amount']);
        } else {
            $total = $totalAmount;
        }

        try {
            DB::beginTransaction();

            $order_id = Order::insertGetId([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_type' => 'Cash On Delivery',
                'payment_method' => 'Cash On Delivery',

                'currency' => 'IDR',
                'amount' => $totalAmount,
                'total_amount' => $total,
                'invoice_no' => 'koncokirim' . mt_rand(10000000, 99999999),
                'order_date' => Carbon::now()->format('d F Y'),
                'order_month' => Carbon::now()->format('F'),
                'order_year' => Carbon::now()->format('Y'),

                'status' => 'Pending',
                'created_at' => Carbon::now(),
            ]);

            foreach ($carts as $key => $cart) {
                OrderItem::insert([
                    'order_id' => $order_id,
                    'product_id' => $cart['id'],
                    'restaurant_id' => $cart['restaurant_id'],
                    'quantity' => $cart['quantity'],
                    'price' => $cart['price'],
                    'created_at' => Carbon::now(),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        if (Session::has('cart')) {
            Session::forget('cart');
        }

        $notification = array(
            'message' => 'Order Placed Successful',
            'alert-type' => 'success'
        );

        return view('frontend.checkout.thanks')->with($notification);
    }
}
