<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DietPlan;
use App\Models\Guideline;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->flash();
        $users = User::with('running_plan');
        if($request->email){
            $users = $users->where('email', $request->email);
        }
        $users = $users->latest()->paginate(pagination_limit());
        return view('backend.user.index', compact('users'));
    }

    public function complete_profile($user_id, Request $request)
    {
        $user = User::find($user_id);
        $user_info = UserInfo::where('user_id', $user_id)->orderBy('id', 'asc')->first();

        if ($request->isMethod('post')){

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
                'daily_sleep_duration' => 'required',
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


            if($user->profile_complete == 0){
                $user->profile_complete = 1;
                $user->save();
            }

            $user_info->user_id = $user->id;
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

            return response()->json(['result' => 'success']);

        }

        return view('backend.user.complete_profile', compact('user', 'user_info'));
    }

    public function add_new_survey(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user->running_plan == null){
            return redirect()->back()->with('error', 'You need assign a plan first');
        }

        if ($request->isMethod('post')){

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


            if($user->profile_complete == 0){
                $user->profile_complete = 1;
                $user->save();
            }

            $user_info = new UserInfo();
            $user_info->user_id = $user->id;
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

            return response()->json(['result' => 'success']);

        }

        return view('backend.user.add_new_survey', compact('user'));
    }

    public function assign_plan($user_id, Request $request)
    {
        $user = User::find($user_id);
        if ($user->profile_complete == 0){
            return redirect()->back()->with('error', 'Profile not completed');
        }
        $plans = Plan::get();
        $data_range =[];
        $plan = null;
        if ($request->plan_id != null && $request->start_date != null){

            $check_data = Order::where('user_id', $user_id)
                ->where('status', 'Running')->count();
            if($check_data > 0){
                return redirect()->back()->with('error', 'This user already have a running plan.');
            }
            $request->flash();
            $plan = Plan::find($request->plan_id);
            $data_range = getMonthlyRanges($request->start_date, $plan->duration);

        }
        return view('backend.user.assign_plan', compact('user', 'plans', 'data_range', 'plans'));
    }

    public function assign_plan_store(Request $request, $user_id)
    {
        $request->validate([
            'plan_id' => 'required',
            'start_date.*' => 'required|date',
            'end_date.*' => 'required|date|after:start_date.*',
        ]);

        $first_start_date = $request['start_date'][0];
        $last_end_date = $request['end_data'][array_key_last($request->end_data)];

        $plan = Plan::find($request->plan_id);

        $check_data = Order::where('user_id', $user_id)
            ->where('status', 'Running')->count();
        if($check_data > 0){
            return redirect()->back()->with('error', 'Already have a running plan.');
        }

        try {
            DB::transaction(function () use ($request, $first_start_date, $last_end_date, $plan, $user_id){
                $order = new Order();
                $order->user_id = $user_id;
                $order->plan_id = $plan->id;
                $order->plan_info = $plan;
                $order->discount = $plan->discount;
                $order->monthly_price = $plan->price - ($plan->discount/100)*$plan->price;
                $order->duration = $plan->duration;
                $order->start_date = date('Y-m-d', strtotime($first_start_date));
                $order->end_date = date('Y-m-d', strtotime($last_end_date));
                $order->status = 'Running';
                $order->save();

                foreach ($request->start_date ?? [] as $key => $start_date){
                    $order_payment = new OrderPayment();
                    $order_payment->order_id = $order->id;
                    $order_payment->start_date = date('Y-m-d', strtotime($start_date));
                    $order_payment->end_date = date('Y-m-d', strtotime($request['end_data'][$key]));
                    $order_payment->payment_status = $request['payment_status'][$key];
                    $order_payment->save();
                }
            });

            return redirect()->route('admin.users.index')->with('success', 'Plan assigned successfully');

        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function order_index()
    {
        $orders = Order::with('user')->latest()->paginate(pagination_limit());
        return view('backend.order.order_index', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Order::with('user.last_user_info', 'order_payments', 'diet_plans', 'workout_plans')->find($id);
        return view('backend.order.order_details', compact('order'));
    }

    public function update_payment_status(Request $request)
    {
       $order_payment = OrderPayment::where('id', $request->payment_id)->first();
       $order_payment->payment_status = $request->status;
       $order_payment->save();
       return response()->json('success');
    }

    public function add_diet_plan($order_id)
    {
        return view('backend.order.diet_plan.create', compact('order_id'));
    }

    public function store_diet_plan(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'food' => 'required',
            'serving_size' => 'required',
            'tips' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $diet_plan = new DietPlan();
        $diet_plan->order_id = $order_id;
        $diet_plan->time = $request->time;
        $diet_plan->food = $request->food;
        $diet_plan->serving_size = $request->serving_size;
        $diet_plan->tips = $request->tips;
        $diet_plan->save();
        return response()->json(['result' => 'success', 'message' => 'Diet plan added successfully.']);
    }

    public function update_diet_plan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'food' => 'required',
            'serving_size' => 'required',
            'tips' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Validation failed. please fill all inputs');
        }
        $diet_plan = DietPlan::find($id);
        $diet_plan->time = $request->time;
        $diet_plan->food = $request->food;
        $diet_plan->serving_size = $request->serving_size;
        $diet_plan->tips = $request->tips;
        $diet_plan->save();
        return response()->json(['result' => 'success', 'message' => 'Diet plan updated successfully.']);
    }

    public function destroy_diet_plan($id)
    {
        $diet_plan = DietPlan::find($id);
        $diet_plan->delete();
        return redirect()->back()->with('success', 'Diet plan deleted successfully.');
    }

    public function add_workout_plan(Request $request, $order_id)
    {
        if ($request->isMethod('post')){

            $validator = Validator::make($request->all(), [
                'day' => 'required',
                'workout' => 'required',
                'sets' => 'required',
                'reps' => 'required',
                'rest' => 'required',
                'suggestion' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }

            $workout_plan = new WorkoutPlan();
            $workout_plan->order_id = $order_id;
            $workout_plan->day = $request->day;
            $workout_plan->workout = $request->workout;
            $workout_plan->sets = $request->sets;
            $workout_plan->reps = $request->reps;
            $workout_plan->rest = $request->rest;
            $workout_plan->suggestion = $request->suggestion;
            $workout_plan->save();
            return response()->json(['result' => 'success', 'message' => 'Workout plan added successfully.']);
        }
        return view('backend.order.workout_plan.create', compact('order_id'));
    }

    public function update_workout_plan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'day' => 'required',
            'workout' => 'required',
            'sets' => 'required',
            'reps' => 'required',
            'rest' => 'required',
            'suggestion' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $workout_plan = WorkoutPlan::find($id);
        $workout_plan->day = $request->day;
        $workout_plan->workout = $request->workout;
        $workout_plan->sets = $request->sets;
        $workout_plan->reps = $request->reps;
        $workout_plan->rest = $request->rest;
        $workout_plan->suggestion = $request->suggestion;
        $workout_plan->save();
        return response()->json(['result' => 'success', 'message' => 'Workout plan updated successfully.']);
    }

    public function destroy_workout_plan($id)
    {
        $workout_plan = WorkoutPlan::find($id);
        $workout_plan->delete();
        return redirect()->back()->with('success', 'Workout plan deleted successfully.');
    }

    public function update_guideline(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'guideline' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $order = Order::find($order_id);
        $order->guideline = $request->guideline;
        $order->update();
        return response()->json(['result' => 'success', 'message' => 'Guideline updated successfully.']);
    }

    public function update_motivational_boost(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'motivational_boost' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $order = Order::find($order_id);
        $order->motivational_boost = $request->motivational_boost;
        $order->update();
        return response()->json(['result' => 'success', 'message' => 'Motivational boost updated successfully.']);
    }

    public function update_today_win(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'today_win' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $order = Order::find($order_id);
        $order->today_win = $request->today_win;
        $order->update();
        return response()->json(['result' => 'success', 'message' => 'Today win updated successfully.']);
    }

    public function update_focus_area(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'focus_area' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }

        $order = Order::find($order_id);
        $order->focus_area = $request->focus_area;
        $order->update();
        return response()->json(['result' => 'success', 'message' => 'Focus area updated successfully.']);
    }

    public function update_order_status(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Running,Canceled,Completed',
        ]);
        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
        }
        $order = Order::find($order_id);

        $check_data = Order::where('user_id', $order->user_id)
            ->where('status', 'Running')->where('id', '!=', $order_id)->count();
        if($check_data > 0){
            return response()->json(['result' => 'error', 'message' => [0 => 'This user already have a running plan.']]);
        }

        $order->status = $request->status;
        $order->update();
        return response()->json(['result' => 'success', 'message' => 'Status updated successfully.']);
    }

}
