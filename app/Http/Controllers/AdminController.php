<?php

namespace App\Http\Controllers;

use App\Mail\Websitemail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('admin.login');
    }

    public function adminDashboard()
    {
        return view('admin.index');
    }

    public function adminLoginSubmit(Request $request)
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

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout successful');
    }

    public function adminForgetPassword()
    {
        return view('admin.forget_password');
    }

    public function adminForgetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $adminData = Admin::where('email', $request->email)->first();

        if (!$adminData) {
            return redirect()->back()->with('error', 'Email not found');
        }

        $token = hash('sha256', time());
        $adminData->token = $token;
        $adminData->update();

        $reset_link = url('/admin/reset-password/' . $token . '/' . $request->email);
        $subject = 'Reset Password';
        $message = 'Please click the link below to reset your password<br>';
        $message .= '<a href="' . $reset_link . '">Click Here</a>';

        Mail::to($request->email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success', 'Reset password link sent to your email');
    }

    public function adminResetPassword($token, $email)
    {
        $adminData = Admin::where('email', $email)->where('token', $token)->first();

        if (!$adminData) {
            return redirect()->route('admin.login')->with('error', 'Invalid token or email');
        }

        return view('admin.reset_password', compact('token', 'email'));
    }

    public function adminResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
            'token' => 'required',
            'email' => 'required|email',
        ]);

        $adminData = Admin::where('email', $request->email)->where('token', $request->token)->first();

        if (!$adminData) {
            return redirect()->route('admin.login')->with('error', 'Invalid token or email');
        }

        $adminData->password = bcrypt($request->password);
        $adminData->token = null;
        $adminData->update();

        return redirect()->route('admin.login')->with('success', 'Password reset successful');
    }

    public function adminProfile()
    {
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);

        return view('admin.admin_profile', compact('profileData'));
    }

    public function adminProfileStore(Request $request)
    {
        $id = Auth::guard('admin')->id();
        $data = Admin::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/admin_images'), $fileName);
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
        $fullPath = public_path('upload/admin_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function adminChangePassword()
    {
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);

        return view('admin.admin_change_password', compact('profileData'));
    }

    public function adminChangePasswordUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $admin->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        // Update new password
        Admin::whereId($admin->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successful',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
}
