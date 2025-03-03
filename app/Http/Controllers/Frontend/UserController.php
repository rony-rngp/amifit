<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EventCalender;
use App\Models\Order;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function dashboard()
    {
        return view('user_dashboard.dashboard');
    }

    public function complete_info()
    {
        return view('user_dashboard.dashboard');
    }

    public function complete_survey(Request $request)
    {
        $request->validate([
            'weight_unit' => 'required|in:kg,pounds',
            'weight' => [
                'required',
                'numeric',
                Rule::when(request('weight_unit') === 'kg', ['min:25', 'max:300']),
                Rule::when(request('weight_unit') === 'pounds', ['min:55', 'max:660']),
            ],
            'height_unit' => 'required|in:cm,inches',
            'height_cm' => [
                'required_if:height_unit,cm','nullable','numeric','min:91','max:244',
            ],
            'height_feet' => [
                'required_if:height_unit,feet','nullable','numeric','min:3','max:8',
            ],
            'height_inches' => [
                'required_if:height_unit,inches', 'nullable', 'numeric','min:0','max:11',
            ],
            'food_preference' => 'required',
            'food_preference_other' => 'required_if:food_preference,Other',
            'activity_level' => 'required',
            'desired_fitness_goals' => 'required',
            'desired_fitness_goals_other' => 'required_if:desired_fitness_goals,Other',
            'pre_existing_medical_condition' => 'required',
            'current_medications' => 'required',
            'history_of_surgical_procedures' => 'required',
            'doctor_recommendations_for_exercise' => 'required',
            'resting_heart_rate' => 'required|integer|min:30|max:300',
            'systolic' => 'required|integer|min:70|max:240',
            'diastolic' => 'required|integer|min:40|max:140',
            'prior_exercise_experience' => 'required',
            'assess_to_gym_or_home_workout' => 'required',
            'weekly_commitment' => 'required|integer',
            'preferred_workout_times' => 'required',
            'neck_circumference' => [
                'required',
                'numeric',
                Rule::when(request('neck_circumference_unit') === 'centimeters', ['min:25', 'max:50']),
                Rule::when(request('neck_circumference_unit') === 'inches', ['min:10', 'max:20']),
            ],
            'waist_measurement' => [
                'required',
                'numeric',
                Rule::when(request('waist_measurement_unit') === 'centimeters', ['min:50', 'max:200']),
                Rule::when(request('waist_measurement_unit') === 'inches', ['min:20', 'max:80']),
            ],
            'hip_measurement' => [
                'required',
                'numeric',
                Rule::when(request('hip_measurement_unit') === 'centimeters', ['min:50', 'max:200']),
                Rule::when(request('hip_measurement_unit') === 'inches', ['min:20', 'max:80']),
            ],
            'chest_measurement' => [
                'required',
                'numeric',
                Rule::when(request('chest_measurement_unit') === 'centimeters', ['min:50', 'max:200']),
                Rule::when(request('chest_measurement_unit') === 'inches', ['min:20', 'max:80']),
            ],
            'body_fat_percentage' => 'nullable|numeric',
            'any_dietary' => 'required',
            'daily_sleep_duration' => 'required|integer',
            'sleep_quality_assessment' => 'required',
            'occupational_activity_level' => 'required',
            'number_of_steps_per_day' => 'required|integer|min:0|max:50000',
            'hydration_intake' => [
                'required',
                'numeric',
                Rule::when(request('hydration_intake_unit') === 'liters', ['min:0.5', 'max:10']),
                Rule::when(request('hydration_intake_unit') === 'ounces', ['min:16', 'max:340']),
            ],
            'can_you_perform_a_bodyweight_squat' => 'required',
            'can_you_perform_a_push_up' => 'required',
            'can_you_perform_a_pull_up' => 'required',
            'max_reps_at_bodyweight' => 'required',
            'flexibility_assessment' => 'required',
            'range_of_motion_for_key_joints' => 'nullable',

            'overhead' => 'required|min:1|max:5',
            'squat' => 'required|min:1|max:5',
            'toe_touch' => 'required|min:1|max:5',
            'shoulder_rotation' => 'required|min:1|max:5',
            'hip_flexion' => 'required|min:1|max:5',
            'ankle_mobility' => 'required|min:1|max:5',
        ]);

        $user = Auth::user();
        if($user->profile_complete == 0){
            $user_info = UserInfo::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
            $user->profile_complete = 1;
            $user->save();
        }else{
            //$user_info = new UserInfo();
            return response()->json(['message' => ['0' =>  'Something wrong']]);
        }

        $user_info->user_id = Auth::user()->id;
        $user_info->weight_unit = $request['weight_unit'];
        $user_info->weight = $request['weight'];
        $user_info->height_unit = $request['height_unit'];
        if ($request['height_unit'] == 'cm'){
            $user_info->height_cm = $request['height_cm'];
            $user_info->height_feet = null;
            $user_info->height_inches = null;
        }else{
            $user_info->height_feet = $request['height_feet'];
            $user_info->height_inches = $request['height_inches'];
            $user_info->height_cm = null;
        }
        $user_info->food_preference = $request['food_preference'];
        $user_info->food_preference_other = $request['food_preference_other'] ?? '';
        $user_info->activity_level = $request['activity_level'];
        $user_info->desired_fitness_goals = $request->desired_fitness_goals;
        $user_info->desired_fitness_goals_other = $request->desired_fitness_goals_other;
        $user_info->pre_existing_medical_condition = $request->pre_existing_medical_condition;
        $user_info->current_medications = $request->current_medications;
        $user_info->history_of_surgical_procedures = $request->history_of_surgical_procedures;
        $user_info->doctor_recommendations_for_exercise = $request->doctor_recommendations_for_exercise;
        $user_info->resting_heart_rate = $request->resting_heart_rate;
        $user_info->systolic = $request->systolic;
        $user_info->diastolic = $request->diastolic;
        $user_info->prior_exercise_experience = $request->prior_exercise_experience;
        $user_info->assess_to_gym_or_home_workout = $request->assess_to_gym_or_home_workout;
        $user_info->weekly_commitment = $request->weekly_commitment;
        $user_info->preferred_workout_times = $request->preferred_workout_times;
        $user_info->waist_measurement_unit = $request->waist_measurement_unit;
        $user_info->waist_measurement = $request->waist_measurement;
        $user_info->hip_measurement_unit = $request->hip_measurement_unit;
        $user_info->hip_measurement = $request->hip_measurement;
        $user_info->chest_measurement_unit = $request->chest_measurement_unit;
        $user_info->chest_measurement = $request->chest_measurement;
        $user_info->neck_circumference_unit = $request->neck_circumference_unit;
        $user_info->neck_circumference = $request->neck_circumference;
        $user_info->body_fat_percentage = $request->body_fat_percentage;
        $user_info->any_dietary = $request->any_dietary;
        $user_info->daily_sleep_duration = $request->daily_sleep_duration;
        $user_info->sleep_quality_assessment = $request->sleep_quality_assessment;
        $user_info->occupational_activity_level = $request->occupational_activity_level;
        $user_info->number_of_steps_per_day = $request->number_of_steps_per_day;
        $user_info->hydration_intake_unit = $request->hydration_intake_unit;
        $user_info->hydration_intake = $request->hydration_intake;
        $user_info->can_you_perform_a_bodyweight_squat = $request->can_you_perform_a_bodyweight_squat;
        $user_info->can_you_perform_a_push_up = $request->can_you_perform_a_push_up;
        $user_info->can_you_perform_a_pull_up = $request->can_you_perform_a_pull_up;
        $user_info->max_reps_at_bodyweight = $request->max_reps_at_bodyweight;
        $user_info->flexibility_assessment = $request->flexibility_assessment;
        $user_info->range_of_motion_for_key_joints = $request->range_of_motion_for_key_joints;

        $user_info->overhead = $request->overhead;
        $user_info->squat = $request->squat;
        $user_info->toe_touch = $request->toe_touch;
        $user_info->shoulder_rotation = $request->shoulder_rotation;
        $user_info->hip_flexion = $request->hip_flexion;
        $user_info->ankle_mobility = $request->ankle_mobility;

        $user_info->save();

        return response()->json(['result' => 'success', 'data' => $request->all()]);

    }

    public function set_new_password(Request $request, $user_id, $password)
    {
        $user_id = Crypt::decrypt($user_id);
        $password = base64_decode($password);

        if ($user_id != null && $password != null){
            $user = User::find($user_id);

            if ($request->isMethod('post')){
                $request->validate([
                    'password' => 'required|string|min:8|confirmed', // 'confirmed' will look for 'new_password_confirmation'
                ]);

                $user->password = Hash::make($request->password);
                $user->save();

                notify()->success('Password setup successfully completed');
                return redirect()->route('login');

            }
            if($user){
                if (Hash::check($password, $user->password)){
                    return view('frontend.user.set_new_password', compact('user', 'password'));
                }else{
                    abort(404);
                }
            }else{
                abort(404);
            }
        }else{
            return redirect('/');
        }

    }

    public function my_orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->latest()->paginate(pagination_limit());
        return view('frontend.user.order.order_list', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order_id = Crypt::decrypt($order_id);
        $order = Order::with('order_payments', 'diet_plans', 'workout_plans')->where(['user_id' => Auth::user()->id, 'id' => $order_id])->first();
        $event_calenders = EventCalender::where('order_id', $order->id)->get();
        $user_infos = UserInfo::where('user_id', Auth::user()->id)->get();
        return view('frontend.user.order.order_details', compact('order', 'event_calenders', 'user_infos'));
    }

    public function add_calender_event(Request $request, $order_id)
    {
        $pass_date = $request->date;
        $order_id = Crypt::decrypt($order_id);
        $event_calender = EventCalender::where('date', $pass_date)->where('order_id', $order_id)->first();

        if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'missed_diet' => ['nullable', 'in:0,1', 'required_without_all:missed_workout'],
                'missed_workout' => ['nullable', 'in:0,1', 'required_without_all:missed_diet'],
            ]);
            if ($validator->fails()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }

            $msg = 'updated';
            if ($event_calender == null){
                $event_calender = new EventCalender();
                $msg = 'added';
            }

            $event_calender->order_id = $order_id;
            $event_calender->date = $pass_date;
            $event_calender->missed_diet = $request->missed_diet ?? 0;
            $event_calender->missed_workout = $request->missed_workout ?? 0;
            $event_calender->comment = $request->comment;
            $event_calender->save();
            return response()->json(['result' => 'success', 'message' => 'Event '.$msg.' successfully.']);

        }
        return view('frontend.user.order.calender_event.add_calender_event', compact('order_id', 'pass_date', 'event_calender'));
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:admins,email,'.Auth::user()->id,
                'birthday' => 'required',
                'sex' => 'required',
            ]);

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthday = $request->birthday;
            $user->sex = $request->sex;
            $user->save();
            return redirect()->back()->with('success', 'Profile updated successfully');
        }
        $user = Auth::user();
        return view('frontend.user.profile', compact('user'));
    }

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (Hash::check($request->current_password, Auth::user()->password)){
                $user = Auth::user();
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('success', 'Password updated successfully');
            }else{
                throw ValidationException::withMessages(['current_password' => 'Your current password is wrong']);
            }
        }
        return view('frontend.user.change_password');
    }

}
