<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\newUserMail;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\WhyChoose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        Session::forget('form_data');
        $why_chooses = WhyChoose::get();
        $plans = Plan::where('status', 1)->get();
        return view('frontend.home', compact('why_chooses', 'plans'));
    }

    public function free_fitness_assessment(Request $request)
    {
        Session::forget('form_data');
        $request->validate([
            'name' => 'required',
            'birthday' => [
                'required',
                'date',
                'before:' . now()->subYears(12)->format('Y-m-d'),
                'after:' . now()->subYears(120)->format('Y-m-d'),
            ],
            'sex' => 'required|in:male,female,other',
            'weight_unit' => 'required|in:kg,pounds',
            'weight' => [
                'required',
                'numeric',
                Rule::when(request('weight_unit') === 'kg', ['min:25', 'max:300']),
                Rule::when(request('weight_unit') === 'pounds', ['min:55', 'max:660']),
            ],
            'height_unit' => 'required|in:cm,inches',
            'height_cm' => [
                'required_if:height_unit,cm',
                'nullable',
                'numeric',
                'min:91',
                'max:244',
            ],
            'height_feet' => [
                'required_if:height_unit,feet',
                'nullable',
                'numeric',
                'min:3',
                'max:8',
            ],
            'height_inches' => [
                'required_if:height_unit,inches',
                'nullable',
                'numeric',
                'min:0',
                'max:11',
            ],
            'activity_level' => 'required'
        ]);

        Session::put('form_data', $request->all());
        return response()->json(['result' => 'success', 'data' => $request->all()]);

    }

    public function register(Request $request)
    {
        $request->validate([
           'email' => 'required|email|unique:users,email',
        ]);

        try {

            $form_data = Session::get('form_data');

            $password = rand(11111111, 99999999);

            DB::transaction(function () use ($request, $form_data, $password, &$user){

                $user = new User();
                $user->name = $form_data['name'];
                $user->email = $request->email;
                $user->birthday = $form_data['birthday'];
                $user->sex = $form_data['sex'];
                $user->password = bcrypt($password);
                $user->save();

                $user_info = new  UserInfo();
                $user_info->user_id = $user->id;
                $user_info->weight_unit = $form_data['weight_unit'];
                $user_info->weight = $form_data['weight'];
                $user_info->height_unit = $form_data['height_unit'];
                if ($form_data['height_unit'] == 'cm'){
                    $user_info->height_cm = $form_data['height_cm'];
                }else{
                    $user_info->height_feet = $form_data['height_feet'];
                    $user_info->height_inches = $form_data['height_inches'];
                }
                $user_info->activity_level = $form_data['activity_level'];
                $user_info->save();
            });

            try {

                Mail::to($user->email)->send(new newUserMail($user, $password));

            }catch (\Exception $ex){}

            Auth::login($user, true);

            Session::forget('form_data');

            return response()->json(['result' => 'success', 'message' => 'Registration successfully']);

        }catch (\Exception $e){
            return response()->json(['message' => ['0' =>  $e->getMessage()]]);
        }

    }

    public function login(Request $request)
    {
        if (Auth::check()){
            return redirect('/');
        }

        if ($request->isMethod('post')){

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' =>$request->password], $request->remember)){
                return redirect()->intended(route('user.dashboard'));
            }else{
                throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
            }

        }
        return view('frontend.user.login');
    }

    public function forgot_password(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            $user = User::where('email', $email)->first();
            if ($user == null){
                throw ValidationException::withMessages(['email' => 'Sorry, we couldn\'t find an account with that email address. Please check the email and try again.']);
            }

            $user->otp = generateUniqueCode();
            $user->update();

            Mail::to($user->email)->send(new ForgotPassword($user));

            $msg = 'Password reset email has been sent! Please check your inbox and follow the instructions to reset your password.';
            return redirect()->back()->with('success', $msg);

        }
        return view('frontend.user.forgot_password.forgot_password');
    }

    public function reset_password($otp, Request $request)
    {
        $otp = Crypt::decrypt($otp);
        if ($otp == ''){
            return redirect('/');
        }

        $user = User::where('otp', $otp)->first();
        if ($user == null){
            abort(404);
        }

        if ($request->isMethod('post')){

            $request->validate([
                'password' => 'required|string|min:8|confirmed', // 'confirmed' will look for 'new_password_confirmation'
            ]);

            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->update();

            notify()->success('Password reset successfully');
            return redirect()->route('login');

        }

        return view('frontend.user.forgot_password.reset_password', compact('otp', 'user'));

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
