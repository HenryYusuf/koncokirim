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
        return view('restaurant.index');
    }

    public function restaurantLogout()
    {
        Auth::guard('restaurant')->logout();
        return redirect()->route('restaurant.login')->with('success', 'Logout successful');
    }

    public function restaurantProfile()
    {
        $id = Auth::guard('restaurant')->id();
        $profileData = Restaurant::find($id);

        return view('restaurant.restaurant_profile', compact('profileData'));
    }

    public function restaurantProfileStore(Request $request)
    {
        $id = Auth::guard('restaurant')->id();
        $data = Restaurant::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/restaurant_images'), $fileName);
            $data->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successful',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/restaurant_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function restaurantChangePassword()
    {
        $id = Auth::guard('restaurant')->id();
        $profileData = Restaurant::find($id);

        return view('restaurant.restaurant_change_password', compact('profileData'));
    }

    public function restaurantChangePasswordUpdate(Request $request)
    {
        $restaurant = Auth::guard('restaurant')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $restaurant->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        // Update new password
        Restaurant::whereId($restaurant->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successful',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
}
