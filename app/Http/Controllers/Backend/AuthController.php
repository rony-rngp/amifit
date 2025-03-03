<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function admin_login(Request $request)
    {
        if (Auth::guard('admin')->check()){
            return redirect()->route('admin.dashboard');
        }

        if ($request->isMethod('post')){

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' =>$request->password], $request->remember)){
                return redirect()->route('admin.dashboard');
            }else{
                throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
            }
        }
        return view('backend.auth.login');
    }

    public function dashboard()
    {
        return view('backend.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:admins,email,'.\auth('admin')->id(),
                'phone' => 'required',
                'image' => 'nullable|mimes:jpeg,jpg,png,PNG'
            ]);

            $admin = Auth::guard('admin')->user();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            if ($request->has('image')) {
                $admin->image = update_image('admin/', $admin->image, $request->file('image'));
            }
            $admin->save();
            return redirect()->back()->with('success', 'Profile updated successfully');
        }
        $admin = Auth::guard('admin')->user();
        return view('backend.auth.profile', compact('admin'));
    }

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (Hash::check($request->current_password, \auth('admin')->user()->password)){
                $admin = Auth::guard('admin')->user();
                $admin->password = Hash::make($request->password);
                $admin->save();
                return redirect()->back()->with('success', 'Password updated successfully');
            }else{
                throw ValidationException::withMessages(['current_password' => 'Your current password is wrong']);
            }
        }
        return view('backend.auth.change_password');
    }
}
