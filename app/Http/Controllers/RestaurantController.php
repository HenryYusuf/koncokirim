<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{
    public function restaurantLogin()
    {
        return view('restaurant.restaurant_login');
    }

    public function restaurantLoginSubmit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::guard('restaurant')->attempt($data)) {
            return redirect()->route('restaurant.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function restaurantRegister()
    {
        return view('restaurant.restaurant_register');
    }

    public function restaurantRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'unique:restaurants'],
        ]);

        Restaurant::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'restaurant',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Restaurant Register Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.login')->with($notification);
    }

    public function restaurantDashboard()
    {
        return view('restaurant.restaurant_dashboard');
    }
}
