@extends('layouts.backend.app')

@section('title', 'Order Details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-6">

            <div class="col-md-12 ">
                @if($order->status == 'Running')
                <div class="alert alert-primary fw-bold" role="alert">
                    Current Order Status :  Running
                </div>
                @endif

                @if($order->status == 'Canceled')
                    <div class="alert alert-danger fw-bold" role="alert">
                        Current Order Status :  Canceled
                    </div>
                @endif
                    @if($order->status == 'Completed')
                        <div class="alert bg-success text-danger fw-bold" role="alert">
                            Current Order Status :  Completed
                        </div>
                    @endif

            </div>

            <div class="col-md-8 mb-6">
                <div class="card">

                    @php($payment_data = checkPayment($order->id, $order->start_date, $order->end_date))

                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Order Derails ( {{ @$order->plan_info['name'] }} )</h5>
                        <h5 class="card-header">Payment Status : {{ @$payment_data['payment_status'] }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @php($bmi_bmr = calculateBmiAndBmr(@$order->user))
                                <div class="mb-4">
                                    <p class="fw-bold">Client Details</p>
                                    <span class="d-block mb-1"><span class="fw-bold">Name</span> : {{ @$order->user->name }}</span>
                                    <span class="d-block mb-1"><span class="fw-bold">Age</span> : {{ checkAge(@$order->user->birthday) }}</span>
                                    <span class="d-block mb-1"><span class="fw-bold">BMI</span> : {{ @$bmi_bmr['bmi'] ?? 'N/A' }}</span>
                                    <span class="d-block mb-1"><span class="fw-bold">BMR</span> : {{ @$bmi_bmr['bmr'] ?? 'N/A' }}</span>
                                    <br>
                                    <h5 class="mb-2">Basic Info</h5>
                                    <span class="d-block mb-1"><span class="fw-bold">Weight</span> : {{ @$order->user->last_user_info->weight.' '.@$order->user->last_user_info->weight_unit }}</span>
                                    @if(@$order->user->last_user_info->height_unit == 'cm')
                                        <span class="d-block mb-1"><span class="fw-bold">Height</span> : {{ @$order->user->last_user_info->height_cm }} cm</span>
                                    @else
                                        <span class="d-block mb-1"><span class="fw-bold">Height</span> : {{ @$order->user->last_user_info->height_feet }}'{{ @$order->user->last_user_info->height_inches }}"</span>
                                    @endif
                                    <span class="d-block mb-1"><span class="fw-bold">Food Preference</span> : {{ @$order->user->last_user_info->food_preference == 'Other' ? @$order->user->last_user_info->food_preference_other : @$order->user->last_user_info->food_preference }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Daily Activity Level</span> : {{ ucfirst(@$order->user->last_user_info->activity_level) }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Desired Fitness Goals</span> : {{ @$order->user->last_user_info->desired_fitness_goals == 'Other' ? @$order->user->last_user_info->desired_fitness_goals_other : @$order->user->last_user_info->desired_fitness_goals }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Any Dietary</span> : {{ @$order->user->last_user_info->any_dietary }} </span>

                                    <br>
                                    <h5 class="mb-2">Medical Information</h5>
                                    <span class="d-block mb-1"><span class="fw-bold">Pre-existing Medical Condition</span> : {{ @$order->user->last_user_info->pre_existing_medical_condition }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Current Medications</span> : {{ @$order->user->last_user_info->current_medications }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">History of Surgical Procedures</span> : {{ @$order->user->last_user_info->history_of_surgical_procedures }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Doctor's Recommendations for Exercise</span> : {{ @$order->user->last_user_info->doctor_recommendations_for_exercise }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Resting Heart Rate</span> : {{ @$order->user->last_user_info->resting_heart_rate }} bpm </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Blood Pressure Systolic</span> : {{ @$order->user->last_user_info->systolic }} mmHg </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Blood Pressure Diastolic</span> : {{ @$order->user->last_user_info->diastolic }} mmHg </span>

                                    <br>
                                    <h5 class="mb-2">Exercise and Equipment</h5>
                                    <span class="d-block mb-1"><span class="fw-bold">Prior Exercise Experience</span> : {{ @$order->user->last_user_info->prior_exercise_experience }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Assess to Gym or Home Workout</span> : {{ @$order->user->last_user_info->assess_to_gym_or_home_workout == 'dont_know' ? 'I Don’t Know' : ucfirst(@$order->user->last_user_info->assess_to_gym_or_home_workout) }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Weekly Commitment (number of days per week for exercise)</span> : {{ @$order->user->last_user_info->weekly_commitment }} days </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Preferred Workout Times</span> : {{ @$order->user->last_user_info->preferred_workout_times }} </span>

                                    <br>
                                    <h5 class="mb-2">Body Measurement</h5>
                                    <span class="d-block mb-1"><span class="fw-bold">Neck Circumference</span> : {{ @$order->user->last_user_info->neck_circumference.' '.@$order->user->last_user_info->neck_circumference_unit }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Waist Measurement</span> : {{ @$order->user->last_user_info->waist_measurement.' '.@$order->user->last_user_info->waist_measurement_unit }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Hip Measurement</span> : {{ @$order->user->last_user_info->hip_measurement.' '.@$order->user->last_user_info->hip_measurement_unit }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Chest Measurement</span> : {{ @$order->user->last_user_info->chest_measurement.' '.@$order->user->last_user_info->chest_measurement_unit }} </span>
                                    <span class="d-block mb-1"><span class="fw-bold">Body Fat Percentage</span> : {{ @$order->user->last_user_info->body_fat_percentage != '' ? $order->user->last_user_info->body_fat_percentage.'%' : 'I Don’t Know' }} </span>



                                </div>
                            </div>
                            <div class="col-md-6 mb-4">

                                <h5 class="mb-2">Lifestyle and Nutrition</h5>
                                <span class="d-block mb-1"><span class="fw-bold">Daily Sleep Duration</span> : {{ @$order->user->last_user_info->daily_sleep_duration }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Sleep Quality Assessment</span> : {{ @$order->user->last_user_info->sleep_quality_assessment }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Occupational Activity Level</span> : {{ @$order->user->last_user_info->occupational_activity_level }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Number of Steps Per Day</span> : {{ @$order->user->last_user_info->number_of_steps_per_day }} steps</span>
                                <span class="d-block mb-1"><span class="fw-bold">Hydration Intake</span> : {{ @$order->user->last_user_info->hydration_intake }} {{ @$order->user->last_user_info->hydration_intake_unit }}</span>

                                <br>
                                <h5 class="mb-2">Fitness Assessment</h5>
                                <span class="d-block mb-1"><span class="fw-bold">Can you perform a bodyweight squat?</span> : {{ @$order->user->last_user_info->can_you_perform_a_bodyweight_squat == 'dont_know' ? 'I Don’t Know' : ucfirst(@$order->user->last_user_info->can_you_perform_a_bodyweight_squat) }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Can you perform a Push-Up?</span> : {{ @$order->user->last_user_info->can_you_perform_a_push_up == 'dont_know' ? 'I Don’t Know' : ucfirst(@$order->user->last_user_info->can_you_perform_a_push_up) }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Can you perform a Pull-Up?</span> : {{ @$order->user->last_user_info->can_you_perform_a_pull_up == 'dont_know' ? 'I Don’t Know' : ucfirst(@$order->user->last_user_info->can_you_perform_a_pull_up) }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Max Reps at Bodyweight</span> : {{ @$order->user->last_user_info->max_reps_at_bodyweight }} </span>
                                <span class="d-block mb-1"><span class="fw-bold">Flexibility Assessment</span> : {{ @$order->user->last_user_info->flexibility_assessment }} </span>

                                <br>
                                <h5 class="mb-2">Motion Assessment</h5>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Overhead Reach (Shoulder, Spine, Elbow)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you raise your arms fully overhead without pain or stiffness?</span> : {{ @$order->user->last_user_info->overhead }} - {{ getScoreLabel(@$order->user->last_user_info->overhead) }} </span>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Deep Squat (Hip, Knee, Ankle)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you perform a deep squat without losing balance or feeling tight?</span> : {{ @$order->user->last_user_info->squat }} - {{ getScoreLabel(@$order->user->last_user_info->squat) }} </span>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Toe Touch (Spine, Hamstrings)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you touch your toes without bending your knees?</span> : {{ @$order->user->last_user_info->toe_touch }} - {{ getScoreLabel(@$order->user->last_user_info->toe_touch) }} </span>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Shoulder Rotation (Shoulder)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you rotate your shoulders fully without pain?</span> : {{ @$order->user->last_user_info->shoulder_rotation }} - {{ getScoreLabel(@$order->user->last_user_info->shoulder_rotation) }} </span>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Hip Flexion (Hip)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you bring your knee to your chest without discomfort?</span> : {{ @$order->user->last_user_info->hip_flexion }} - {{ getScoreLabel(@$order->user->last_user_info->hip_flexion) }} </span>

                                <span class="d-block text-dark mb-1" style="font-size: 17px">Ankle Mobility (Ankle)</span>
                                <span class="d-block mb-2"><span class="fw-bold">Can you bring your knee to your chest without discomfort?</span> : {{ @$order->user->last_user_info->ankle_mobility }} - {{ getScoreLabel(@$order->user->last_user_info->ankle_mobility) }} </span>



                                {{--<p class="fw-bold">Plan Information</p>
                                <span class="d-block mb-1"><span class="fw-bold">Plan Name</span> : {{ @$order->plan_info['name'] }}</span>
                                <span class="d-block mb-1"><span class="fw-bold">Duration</span> : {{ @$order->plan_info['duration'] }} Month</span>
                                <span class="d-block mb-1"><span class="fw-bold">Payment Status</span> : {{ $payment_data != null ? $payment_data->start_date .' - '.$payment_data->end_date . ' ( '.$payment_data->payment_status.' ) ' : 'N/A' }}</span>
                                <span class="d-block">
                                    <span class="fw-bold">Order Status : </span>
                                    {{ $order->status }}
                                    @if(date('Y-m-d') < $order->start_date)
                                        <span class="d-block text-danger">Plan will start on {{ $order->start_date }}</span>
                                    @endif
                                </span>
                                <br>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-6">
                <div class="card mb-6">
                    <div>
                        <h5 class="card-header border-bottom">Plan Information</h5>
                    </div>
                    <div class="card-body">
                        <span class="d-block mb-2"><span class="fw-bold">Order ID</span> : {{ @$order->id }}</span>
                        <span class="d-block mb-2"><span class="fw-bold">Plan Name</span> : {{ @$order->plan_info['name'] }}</span>
                        <span class="d-block mb-2"><span class="fw-bold">Duration</span> : {{ @$order->plan_info['duration'] }} Month</span>
                        <span class="d-block mb-2"><span class="fw-bold">Monthly Price</span> : {{ @$order['monthly_price'] }} {{ base_currency_name() }}</span>
                        <span class="d-block mb-2"><span class="fw-bold">Payment Status</span> : {{ $payment_data != null ? $payment_data->start_date .' - '.$payment_data->end_date . ' ( '.$payment_data->payment_status.' ) ' : 'N/A' }}</span>
                        <span class="d-block mb-2">
                            <span class="fw-bold">Order Status : </span>
                            {{ $order->status }}
                            @if(date('Y-m-d') < $order->start_date)
                                <span class="d-block text-danger">Plan will start on {{ $order->start_date }}</span>
                            @endif
                        </span>
                        <span class="d-block mb-2"><span class="fw-bold">Journey Start Date</span> : {{ $order->start_date }}</span>
                        <span class="d-block mb-1"><span class="fw-bold">Journey End Date</span> : {{ $order->end_date }}</span>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h5 class="card-header border-bottom">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <form class="ajax-submit" action="{{ route('admin.orders.update_status', $order->id) }}" method="post">
                            @csrf
                            <div>
                                <label for="" class="form-label">Status <i class="text-danger">*</i></label>
                                <select class="form-control mb-4" name="status">
                                    <option {{ $order->status == 'Running' ? 'selected' : '' }} value="Running">Running</option>
                                    <option {{ $order->status == 'Canceled' ? 'selected' : '' }} value="Canceled">Canceled</option>
                                    <option {{ $order->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-6">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Diet Plan </h5>
                        <div class="me-5">
                            <a href="{{ route('admin.orders.add_diet_plan', $order->id) }}" class="btn btn-primary btn-sm ajax-modal" data-title="Add Diet Plan">Add Diet Plan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($order->diet_plans) > 0)
                            @foreach($order->diet_plans ?? [] as $diet_plan)
                                <form class="ajax-submit" action="{{ route('admin.orders.update_diet_plan', $diet_plan->id) }}" method="post">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label">Time <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $diet_plan->time }}" name="time" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label">Food <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $diet_plan->food }}" name="food" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="serving_size">Serving Size <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $diet_plan->serving_size }}" name="serving_size" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="tips">Tips <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $diet_plan->tips }}" name="tips" required >
                                        </div>
                                        <div class="mb-4 col-md-12">
                                            <button type="submit" class="btn btn-sm btn-primary validate">Update</button>
                                            &nbsp;
                                            <a onclick="return confirm('Are you sure?')" href="{{ route('admin.orders.destroy_diet_plan', $diet_plan->id) }}" class="btn btn-sm btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @else
                            <p class="text-center text-danger fw-bold m-0">No diet plan found. pleas add new diet plan</p>
                        @endif


                        {{--<div class="col-md-12" id="newRow1"></div>


                        <div class="col-md-12 mb-4">
                            <a href="javascript:void(0)" id="addRow1" class="new_btn bg_warning mr-2">Add New Options</a>
                        </div>--}}

                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-6">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Workout Plan </h5>
                        <div class="me-5">
                            <a href="{{ route('admin.orders.add_workout_plan', $order->id) }}" class="btn btn-primary btn-sm ajax-modal" data-title="Add Workout Plan">Add Workout Plan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($order->workout_plans) > 0)
                            @foreach($order->workout_plans ?? [] as $workout_plan)
                                <form class="ajax-submit" action="{{ route('admin.orders.update_workout_plan', $workout_plan->id) }}" method="post">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label">Day <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan->day }}" name="day" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label">Workout <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan->workout }}" name="workout" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="sets">Sets <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan->sets }}" name="sets" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="tips">Reps <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan->reps }}" name="reps" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="tips">Rest <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan->rest }}" name="rest" required >
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <label class="form-label" for="tips">Suggestion <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" value="{{ $workout_plan['suggestion'] }}" name="suggestion" required >
                                        </div>

                                        <div class="mb-4 col-md-3">
                                            <div style="margin-top: 26px">
                                                <button type="submit" class="btn btn-sm btn-primary validate">Update</button>
                                                &nbsp;
                                                <a onclick="return confirm('Are you sure?')" href="{{ route('admin.orders.destroy_workout_plan', $workout_plan->id) }}" class="btn btn-sm btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @else
                            <p class="text-center text-danger fw-bold m-0">No workout plan found. pleas add new diet plan</p>
                        @endif


                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 mb-6">
                <div class="card">
                    <div class="border-bottom">
                        <h5 class="card-header">Guideline</h5>
                    </div>

                    <div class="card-body">
                        <form class="ajax-submit" action="{{ route('admin.orders.update_guideline', $order->id) }}" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label">Guideline <i class="text-danger">*</i></label>
                                <textarea rows="5" class="form-control" name="guideline" required >{{ $order->guideline }}</textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn  btn-primary validate">Update Guideline</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card">
                    <div class="border-bottom">
                        <h5 class="card-header">Motivational Boost</h5>
                    </div>

                    <div class="card-body">
                        <form class="ajax-submit" action="{{ route('admin.orders.update_motivational_boost', $order->id) }}" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label">Motivational Boost <i class="text-danger">*</i></label>
                                <textarea rows="5" class="form-control" name="motivational_boost" required >{{ $order->motivational_boost }}</textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn  btn-primary validate">Update </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card">
                    <div class="border-bottom">
                        <h5 class="card-header">Today's Win</h5>
                    </div>

                    <div class="card-body">
                        <form class="ajax-submit" action="{{ route('admin.orders.update_today_win', $order->id) }}" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label">Today's Win <i class="text-danger">*</i></label>
                                <textarea rows="3" class="form-control" name="today_win" required >{{ $order->today_win }}</textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn  btn-primary validate">Update </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


            <div class="col-md-6 mb-6">
                <div class="card">
                    <div class="border-bottom">
                        <h5 class="card-header">Focus Area</h5>
                    </div>

                    <div class="card-body">
                        <form class="ajax-submit" action="{{ route('admin.orders.update_focus_area', $order->id) }}" method="post">
                            @csrf
                            <div class="mb-4 col-md-12">
                                <label class="form-label">Focus Area <i class="text-danger">*</i></label>
                                <textarea rows="3" class="form-control" name="focus_area" required >{{ $order->focus_area }}</textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn  btn-primary validate">Update </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-12 mb-6">
                <div class="card">
                    <div>
                        <h5 class="card-header">Payment Information</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Payment Status</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach($order->order_payments ?? [] as $key => $order_payment)
                                <tr>
                                    <td>{{ $order_payment->start_date }}</td>
                                    <td>{{ $order_payment->end_date }}</td>
                                    <td>
                                        @if($key == 0 && $order_payment->payment_status == 'Paid')
                                            {{ $order_payment->payment_status }}
                                        @else
                                            <select class="form-control" onchange="paymentStatus(this, '{{ $order_payment->id }}')">
                                                <option {{ $order_payment->payment_status == 'Paid' ? 'selected' : '' }} value="Paid">Paid</option>
                                                <option {{ $order_payment->payment_status == 'Unpaid' ? 'selected' : '' }} value="Unpaid">Unpaid</option>
                                            </select>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>


@endsection

@push('js')
    <script>
        function paymentStatus(selectElement, payment_id) {
            let status = selectElement.value;
            $.ajax({
                url : "{{ route('admin.orders.update_payment_status') }}",
                type : 'get',
                data : {status:status, payment_id: payment_id},
                success:function (res) {
                    showToast('success', 'topLeft', 'Payment status updated');
                }
            });
        }
    </script>
@endpush
