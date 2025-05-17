<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function restaurantAllCoupon()
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $coupons = Coupon::where('restaurant_id', $restaurantId)->latest()->get();

        return view('restaurant.backend.coupon.all_coupon', compact('coupons'));
    }

    public function restaurantAddCoupon()
    {
        return view('restaurant.backend.coupon.add_coupon');
    }

    public function restaurantAddCouponStore(Request $request)
    {
        Coupon::create([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_description' => $request->coupon_description,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'restaurant_id' => Auth::guard('restaurant')->id(),
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Coupon Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.coupon')->with($notification);
    }

    public function restaurantEditCoupon(Coupon $coupon)
    {
        return view('restaurant.backend.coupon.edit_coupon', compact('coupon'));
    }

    public function restaurantEditCouponUpdate(Request $request)
    {
        $couponId = $request->id;
        
        Coupon::find($couponId)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_description' => $request->coupon_description,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Coupon Updated Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.coupon')->with($notification);
    }

    public function restaurantDeleteCoupon(Coupon $coupon)
    {
        $coupon->delete();

        $notification = array(
            'message' => 'Coupon Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.coupon')->with($notification);
    }
}
