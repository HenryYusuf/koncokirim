<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart($id)
    {

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $product = Product::find($id);

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $priceToShow = isset($product->discount_price) ? $product->discount_price : $product->price;
            $cart[$id] = [
                'id' => $id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $priceToShow,
                'restaurant_id' => $product->restaurant_id,
                'quantity' => 1
            ];
        }

        Session::put('cart', $cart);

        // return response()->json($cart);

        $notifiaction = array(
            'message' => 'Add to Cart Successful',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notifiaction);
    }

    public function cartUpdateQuantity(Request $request)
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return response()->json([
            'message' => 'Quantity Updated Successful',
            'alert-type' => 'success'
        ]);
    }

    public function cartDelete(Request $request)
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product Deleted Successful',
            'alert-type' => 'success'
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)->where('validity', '>=', Carbon::now()->format('Y-m-d'))->first();

        $carts = Session::get('cart', []);

        $totalAmount = 0;
        $restaurantIds = [];

        foreach ($carts as $cart) {
            $totalAmount += ($cart['price'] * $cart['quantity']);
            $product = Product::find($cart['id']);
            $restaurantId = $product->restaurant_id;
            array_push($restaurantIds, $restaurantId);
        }

        if ($coupon) {
            if (count(array_unique($restaurantIds)) === 1) {
                $couponRestaurantId = $coupon->restaurant_id;

                if ($couponRestaurantId == $restaurantIds[0]) {
                    Session::put('coupon', [
                        'coupon_name' => $coupon->coupon_name,
                        'discount' => $coupon->discount,
                        'discount_amount' => $totalAmount - ($totalAmount * $coupon->discount / 100)
                    ]);

                    $couponData = Session::get('coupon');

                    return response()->json(array('validity' => true, 'success' => 'Coupon Applied Successful', 'coupon_data' => $couponData));
                } else {
                    return response()->json(['error' => 'This Coupon Not Valid for this Restaurant']);
                }
            } else {
                return response()->json(['error' => 'This Coupon for one of the selected Restaurant']);
            }
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Removed Successful']);
    }

    public function checkoutCart()
    {
        if (Auth::check()) {
            $carts = Session::get('cart', []);
            $totalAmount = 0;

            foreach ($carts as $key => $cart) {
                $totalAmount += $cart['price'];
            }

            if ($totalAmount > 0) {
                return view('frontend.checkout.view_checkout', compact('cart'));
            } else {
                $notifiaction = array(
                    'message' => 'Shopping at least one item',
                    'alert-type' => 'error'
                );

                return redirect()->to('/')->with($notifiaction);
            }
        } else {
            $notifiaction = array(
                'message' => 'Please Login First',
                'alert-type' => 'error'
            );

            return redirect()->route('login')->with($notifiaction);
        }
    }
}
