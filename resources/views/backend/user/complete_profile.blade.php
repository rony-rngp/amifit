@extends('layouts.backend.app')

@section('title', $user->profile_complete == 1 ? 'Update First Profile' : 'Complete Profile')

@push('css')

@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">

                <p class="text-center mb-4 alert bg-{{ $user->profile_complete == 1 ? 'success' : 'warning' }} p-5" style="font-size: 17px">{{ $user->profile_complete == 1 ? 'Update First Profile' : 'Complete '.$user->name.' Profile' }}</p>


                <p>{{ $user->profile_complete == 1 ? 'Step Progress' : 'Profile Complete' }}: <span class="profile_complete">10%</span></p>
                <div class="progress mb-4" style="height: 15px;">
                    <div class="progress-bar user_progress" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                </div>

                <form class="free_assessment_form" action="{{ route('admin.users.complete_profile', $user->id) }}" method="post">
                    @csrf

                    <div class="card mb-6 step_1">
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-header">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="weight_unit">Weight Unit <i class="text-danger">*</i></label>
                                    <select id="weight_unit" name="weight_unit" required class="form-control">
                                        <option value="">-- Select KG/Pounds --</option>
                                        <option {{ $user_info->weight_unit == 'kg' ? 'selected' : '' }} value="kg">KG</option>
                                        <option {{ $user_info->weight_unit == 'pounds' ? 'selected' : '' }} value="pounds">Pounds</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('weight_unit') ? $errors->first('weight_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="weight">Weight <i class="text-danger">*</i> (kg: 25–300 & lbs: 55–660)</label>
                                    <input type="number" class="form-control" name="weight" placeholder="kg: 25–300 & lbs: 55–660" id="weight" value="{{ $user_info->weight }}" required >
                                    <span class="text-danger">{{ $errors->has('weight') ? $errors->first('weight') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="height_unit" class="form-label">Height Unit <i class="text-danger">*</i></label>
                                    <select id="height_unit" name="height_unit" required class="form-control">
                                        <option value="">-- Select CM/Feet & Inches --</option>
                                        <option {{ $user_info->height_unit == 'cm' ? 'selected' : '' }} value="cm">CM</option>
                                        <option {{ $user_info->height_unit == 'inches' ? 'selected' : '' }} value="inches">Inches</option>
                                    </select>
                                </div>
                                <div id="cmHeight" class="cm_div {{ $user_info->height_unit == 'cm' ? '' : 'd-none' }}  mb-4 col-md-6">
                                    <label for="height_cm" class="form-label">Height (cm) <i class="text-danger">*</i> (91–244 cm)</label>
                                    <input type="number" id="height_cm" placeholder="91–244 cm" {{ $user_info->height_unit == 'cm' ? 'required' : '' }} name="height_cm" value="{{ $user_info->height_cm }}" class="form-control" />
                                </div>

                                <div id="inchesHeight" class="inches_div {{ $user_info->height_unit == 'cm' ? 'd-none' : '' }} mb-4 col-md-12">
                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label for="height_feet" class="form-label">Height (feet) <i class="text-danger">*</i> (feet: 3–8 ft)</label>
                                            <input type="number" id="height_feet" placeholder="feet: 3–8 ft" {{ $user_info->height_unit == 'inches' ? 'required' : '' }} name="height_feet" value="{{ $user_info->height_feet }}" class="form-control" />
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="height_inches" class="form-label">Height (inches) <i class="text-danger">*</i> (inches: 0–11 in)</label>
                                            <input type="number" id="height_inches" placeholder="inches: 0–11 in" {{ $user_info->height_unit == 'inches' ? 'required' : '' }} value="{{ $user_info->height_inches }}" name="height_inches" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="food_preference">Food Preference (e.g, vegetarian, vegan, omnivore) <i class="text-danger">*</i></label>
                                    <select name="food_preference" id="food_preference" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option {{ $user_info->food_preference == 'Omnivore' ? 'selected' : '' }} value="Omnivore">Omnivore</option>
                                        <option {{ $user_info->food_preference == 'Vegetarian' ? 'selected' : '' }} value="Vegetarian">Vegetarian</option>
                                        <option {{ $user_info->food_preference == 'Vegan' ? 'selected' : '' }} value="Vegan">Vegan</option>
                                        <option {{ $user_info->food_preference == 'Pescatarian' ? 'selected' : '' }} value="Pescatarian">Pescatarian</option>
                                        <option {{ $user_info->food_preference == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('food_preference') ? $errors->first('food_preference') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6 {{ $user_info->food_preference == 'Other' ? '' : 'd-none' }} " id="food_preference_other_div">
                                    <label class="form-label" for="food_preference_other">Food Preference Other <i class="text-danger">*</i> </label>
                                    <input type="text" class="form-control" {{ $user_info->food_preference == 'Other' ? 'required' : '' }} name="food_preference_other" id="food_preference_other" value="{{ $user_info->food_preference_other }}" >
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="activity_level">Daily Activity Level (e.g, sedentary, light, moderate, heavy)<i class="text-danger">*</i></label>
                                    <select id="activity_level" name="activity_level" required class="form-control">
                                        <option value="">Select</option>
                                        <option {{ $user_info->activity_level == 'sedentary' ? 'selected' : '' }} value="sedentary">Sedentary (little to no exercise)</option>
                                        <option {{ $user_info->activity_level == 'lightly' ? 'selected' : '' }} value="lightly">Light (1-2 days of light activity per week)</option>
                                        <option {{ $user_info->activity_level == 'moderately' ? 'selected' : '' }} value="moderately">Moderate (3-4 days of moderate exercise per week)</option>
                                        <option {{ $user_info->activity_level == 'very' ? 'selected' : '' }} value="very">heavy (5+ days of intense exercise per week)</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('activity_level') ? $errors->first('activity_level') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="desired_fitness_goals">Desired Fitness Goals (e.g, weight loss, muscle gain, overall health improvement) <i class="text-danger">*</i></label>
                                    <select name="desired_fitness_goals" id="desired_fitness_goals" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option {{ $user_info->desired_fitness_goals == 'Weight Loss' ? 'selected' : '' }} value="Weight Loss">Weight Loss</option>
                                        <option {{ $user_info->desired_fitness_goals == 'Muscle Gain' ? 'selected' : '' }} value="Muscle Gain">Muscle Gain</option>
                                        <option {{ $user_info->desired_fitness_goals == 'Improve Stamina' ? 'selected' : '' }} value="Improve Stamina">Improve Stamina</option>
                                        <option {{ $user_info->desired_fitness_goals == 'Increase Flexibility' ? 'selected' : '' }} value="Increase Flexibility">Increase Flexibility</option>
                                        <option {{ $user_info->desired_fitness_goals == 'General Health Improvement' ? 'selected' : '' }} value="General Health Improvement">General Health Improvement</option>
                                        <option {{ $user_info->desired_fitness_goals == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('desired_fitness_goals') ? $errors->first('desired_fitness_goals') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6 {{ $user_info->desired_fitness_goals == 'Other' ? '' : 'd-none' }}" id="desired_fitness_goals_other_div">
                                    <label class="form-label" for="desired_fitness_goals_other">Desired Fitness Goals Other <i class="text-danger">*</i> </label>
                                    <input type="text" class="form-control" {{ $user_info->desired_fitness_goals == 'Other' ? 'required' : '' }} name="desired_fitness_goals_other" id="desired_fitness_goals_other" value="{{ $user_info->desired_fitness_goals_other }}" >
                                    <span class="text-danger">{{ $errors->has('desired_fitness_goals_other') ? $errors->first('desired_fitness_goals_other') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="any_dietary">Any Dietary Restrictions, Allergies, or Intolerance <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="any_dietary" id="any_dietary" value="{{ $user_info->any_dietary }}" required >
                                    <span class="text-danger">{{ $errors->has('any_dietary') ? $errors->first('any_dietary') : '' }}</span>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" disabled="" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                        <a href="javascript:void(0)" onclick="next_step('step_1', '2')" class="btn btn-info">Next Step <i class="bx bxs-arrow-to-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mb-6 step_2 d-none">
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-header">Medical Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="pre_existing_medical_condition">Pre-existing Medical Condition or Injuries  <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="pre_existing_medical_condition" id="pre_existing_medical_condition" value="{{ $user_info->pre_existing_medical_condition }}" required >
                                    <span class="text-danger">{{ $errors->has('pre_existing_medical_condition') ? $errors->first('pre_existing_medical_condition') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="current_medications">Current Medications <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="current_medications" id="current_medications" value="{{ $user_info->current_medications }}" required >
                                    <span class="text-danger">{{ $errors->has('current_medications') ? $errors->first('current_medications') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="history_of_surgical_procedures">History of Surgical Procedures <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="history_of_surgical_procedures" id="history_of_surgical_procedures" value="{{ $user_info->history_of_surgical_procedures }}" required >
                                    <span class="text-danger">{{ $errors->has('history_of_surgical_procedures') ? $errors->first('history_of_surgical_procedures') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="doctor_recommendations_for_exercise">Doctor's Recommendations for Exercise <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="doctor_recommendations_for_exercise" id="doctor_recommendations_for_exercise" value="{{ $user_info->doctor_recommendations_for_exercise }}" required >
                                    <span class="text-danger">{{ $errors->has('doctor_recommendations_for_exercise') ? $errors->first('doctor_recommendations_for_exercise') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="resting_heart_rate">Resting Heart Rate (beats per minute) <i class="text-danger">*</i> (30-300 bpm)</label>
                                    <input type="number" class="form-control" name="resting_heart_rate" placeholder="30-300 bpm" id="resting_heart_rate" value="{{ $user_info->resting_heart_rate }}" required >
                                    <span class="text-danger">{{ $errors->has('resting_heart_rate') ? $errors->first('resting_heart_rate') : '' }}</span>
                                </div>

                                <div class="col-md-12">
                                    <h5 class="mb-2">Blood Pressure</h5>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="systolic">Systolic <i class="text-danger">*</i> (70-240 mmHg)</label>
                                    <input type="number" class="form-control" name="systolic" placeholder="70-240 mmHg" id="systolic" value="{{ $user_info->systolic }}" required >
                                    <span class="text-danger">{{ $errors->has('systolic') ? $errors->first('systolic') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="diastolic">Diastolic <i class="text-danger">*</i> (40/140 mmHg)</label>
                                    <input type="number" class="form-control" name="diastolic" placeholder="40/140 mmHg" id="diastolic" value="{{ $user_info->diastolic }}" required >
                                    <span class="text-danger">{{ $errors->has('diastolic') ? $errors->first('diastolic') : '' }}</span>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" onclick="prev_step('step_2', '1')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                        <a href="javascript:void(0)" onclick="next_step('step_2', '3')" class="btn btn-info">Next Step <i class="bx bxs-arrow-to-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card mb-6 step_3 d-none">
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-header">Exercise and Equipment</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="prior_exercise_experience">Prior Exercise Experience  <i class="text-danger">*</i></label>
                                    <select name="prior_exercise_experience" id="prior_exercise_experience" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->prior_exercise_experience == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                        <option {{ $user_info->prior_exercise_experience == 'no' ? 'selected' : '' }} value="no">No</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('prior_exercise_experience') ? $errors->first('prior_exercise_experience') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="assess_to_gym_or_home_workout">Assess to Gym or Home Workout <i class="text-danger">*</i></label>
                                    <select name="assess_to_gym_or_home_workout" id="assess_to_gym_or_home_workout" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->assess_to_gym_or_home_workout == 'gym' ? 'selected' : '' }} value="gym">Gym</option>
                                        <option {{ $user_info->assess_to_gym_or_home_workout == 'home' ? 'selected' : '' }} value="home">Home</option>
                                        <option {{ $user_info->assess_to_gym_or_home_workout == 'both' ? 'selected' : '' }} value="both">Both</option>
                                        <option {{ $user_info->assess_to_gym_or_home_workout == 'dont_know' ? 'selected' : '' }} value="dont_know">I Don’t Know</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('assess_to_gym_or_home_workout') ? $errors->first('assess_to_gym_or_home_workout') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="weekly_commitment">Weekly Commitment (number of days per week for exercise) <i class="text-danger">*</i> (0–7 days)</label>
                                    <input type="number" class="form-control" name="weekly_commitment" id="weekly_commitment" placeholder="0–7 days" value="{{ $user_info->weekly_commitment }}" required >
                                    <span class="text-danger">{{ $errors->has('weekly_commitment') ? $errors->first('weekly_commitment') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="preferred_workout_times">Preferred Workout Times <i class="text-danger">*</i></label>
                                    <select name="preferred_workout_times" id="preferred_workout_times" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->preferred_workout_times == 'Morning' ? 'selected' : '' }} value="Morning">Morning</option>
                                        <option {{ $user_info->preferred_workout_times == 'Afternoon' ? 'selected' : '' }} value="Afternoon">Afternoon</option>
                                        <option {{ $user_info->preferred_workout_times == 'Evening' ? 'selected' : '' }} value="Evening">Evening</option>
                                        <option {{ $user_info->preferred_workout_times == 'Night' ? 'selected' : '' }} value="Night">Night</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('preferred_workout_times') ? $errors->first('preferred_workout_times') : '' }}</span>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" onclick="prev_step('step_3', '2')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                        <a href="javascript:void(0)" onclick="next_step('step_3', '4')" class="btn btn-info">Next Step <i class="bx bxs-arrow-to-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mb-6 step_4 d-none">
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-header">Body Measurement</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="neck_circumference_unit">Neck Circumference Unit<i class="text-danger">*</i></label>
                                    <select name="neck_circumference_unit" id="neck_circumference_unit" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->neck_circumference_unit == 'centimeters' ? 'selected' : '' }} value="centimeters">Centimeters</option>
                                        <option {{ $user_info->neck_circumference_unit == 'inches' ? 'selected' : '' }} value="inches">Inches</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('neck_circumference_unit') ? $errors->first('neck_circumference_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="neck_circumference">Neck Circumference <i class="text-danger">*</i> (25–50 CM or 10–20 inches)</label>
                                    <input type="number" class="form-control" name="neck_circumference" placeholder="25–50 CM or 10–20 inches" id="neck_circumference" value="{{ $user_info->neck_circumference }}" required >
                                    <span class="text-danger">{{ $errors->has('neck_circumference') ? $errors->first('neck_circumference') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="waist_measurement_unit">Waist Measurement Unit  <i class="text-danger">*</i></label>
                                    <select name="waist_measurement_unit" id="waist_measurement_unit" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->waist_measurement_unit == 'centimeters' ? 'selected' : '' }} {{--@if($user_info->waist_measurement_unit != null) {{ $user_info->waist_measurement_unit == 'centimeters' ? 'selected' : '' }} @else selected @endif--}} value="centimeters">Centimeters</option>
                                        <option {{ $user_info->waist_measurement_unit == 'inches' ? 'selected' : '' }} value="inches">Inches</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('waist_measurement_unit') ? $errors->first('waist_measurement_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="waist_measurement">Waist Measurement <i class="text-danger">*</i> (50–200 CM or 20–80 inches)</label>
                                    <input type="number" step="any" class="form-control" placeholder="50–200 CM or 20–80 inches" name="waist_measurement" id="waist_measurement" value="{{ $user_info->waist_measurement }}" required >
                                    <span class="text-danger">{{ $errors->has('waist_measurement') ? $errors->first('waist_measurement') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="hip_measurement_unit">Hip Measurement Unit <i class="text-danger">*</i></label>
                                    <select name="hip_measurement_unit" id="hip_measurement_unit" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->hip_measurement_unit == 'centimeters' ? 'selected' : '' }} value="centimeters">Centimeters</option>
                                        <option {{ $user_info->hip_measurement_unit == 'inches' ? 'selected' : '' }} value="inches">Inches</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('hip_measurement_unit') ? $errors->first('hip_measurement_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="hip_measurement">Hip Measurement <i class="text-danger">*</i> (50–200 CM or 20–80 inches)</label>
                                    <input type="number" class="form-control" placeholder="50–200 CM or 20–80 inches" name="hip_measurement" id="hip_measurement" value="{{ $user_info->hip_measurement }}" required >
                                    <span class="text-danger">{{ $errors->has('hip_measurement') ? $errors->first('hip_measurement') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="chest_measurement_unit">Chest Measurement Unit <i class="text-danger">*</i></label>
                                    <select name="chest_measurement_unit" id="chest_measurement_unit" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->chest_measurement_unit == 'centimeters' ? 'selected' : '' }} value="centimeters">Centimeters</option>
                                        <option {{ $user_info->chest_measurement_unit == 'inches' ? 'selected' : '' }} value="inches">Inches</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('chest_measurement_unit') ? $errors->first('chest_measurement_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="chest_measurement">Chest Measurement <i class="text-danger">*</i> (50–200 CM or 20–80 inches)</label>
                                    <input type="number" class="form-control" placeholder="50–200 CM or 20–80 inches" name="chest_measurement" id="chest_measurement" value="{{ $user_info->chest_measurement }}" required >
                                    <span class="text-danger">{{ $errors->has('chest_measurement') ? $errors->first('chest_measurement') : '' }}</span>
                                </div>


                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="body_fat_dont_know">Body Fat Percentage (Optional) (5–60)% &nbsp; <input id="body_fat_dont_know" {{ $user_info->body_fat_percentage == '' ? 'checked' : '' }} type="checkbox"> I don't know</label>
                                    <input type="number" step="0.01" class="form-control" placeholder="5–60" name="body_fat_percentage" id="body_fat_percentage" value="{{ $user_info->body_fat_percentage }}" >
                                    <span class="text-danger">{{ $errors->has('body_fat_percentage') ? $errors->first('body_fat_percentage') : '' }}</span>
                                </div>


                                <div class="col-md-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" onclick="prev_step('step_4', '3')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                        <a href="javascript:void(0)" onclick="next_step('step_4', '5')" class="btn btn-info">Next Step <i class="bx bxs-arrow-to-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mb-6 step_5 d-none">
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-header">Lifestyle and Nutrition</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="daily_sleep_duration">Daily Sleep Duration <i class="text-danger">*</i> </label>
                                    <select id="daily_sleep_duration" name="daily_sleep_duration" class="form-control" required>
                                        <option value="">Select One</option>
                                        @for($x = 3; $x <= 12; $x++)
                                            <option {{ $user_info->daily_sleep_duration == $x ? 'selected' : '' }} value="{{ $x }}">{{ $x }}{{ $x == 12 ? '+' : '' }} Hours </option>
                                        @endfor
                                        <option {{ $user_info->daily_sleep_duration == 0 ? 'selected' : '' }} value="0">Inconsistent</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('daily_sleep_duration') ? $errors->first('daily_sleep_duration') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="sleep_quality_assessment">Sleep Quality Assessment <i class="text-danger">*</i></label>
                                    <select name="sleep_quality_assessment" id="sleep_quality_assessment" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option {{ $user_info->sleep_quality_assessment == 'Excellent' ? 'selected' : '' }} value="Excellent">Excellent</option>
                                        <option {{ $user_info->sleep_quality_assessment == 'Good' ? 'selected' : '' }} value="Good">Good</option>
                                        <option {{ $user_info->sleep_quality_assessment == 'Average' ? 'selected' : '' }} value="Average">Average</option>
                                        <option {{ $user_info->sleep_quality_assessment == 'Poor' ? 'selected' : '' }} value="Poor">Poor</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('sleep_quality_assessment') ? $errors->first('sleep_quality_assessment') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="occupational_activity_level">Occupational Activity Level <i class="text-danger">*</i></label>
                                    <select name="occupational_activity_level" id="occupational_activity_level" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option {{ $user_info->occupational_activity_level == 'Sedentary' ? 'selected' : '' }} value="Sedentary">Sedentary (Desk job, little movement)</option>
                                        <option {{ $user_info->occupational_activity_level == 'Light' ? 'selected' : '' }} value="Light">Light (Occasional walking, some physical activity)</option>
                                        <option {{ $user_info->occupational_activity_level == 'Moderate' ? 'selected' : '' }} value="Moderate">Moderate (On feet often, moderate physical work)</option>
                                        <option {{ $user_info->occupational_activity_level == 'Heavy' ? 'selected' : '' }} value="Heavy">Heavy (Physically demanding job, frequent movement)</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('occupational_activity_level') ? $errors->first('occupational_activity_level') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="number_of_steps_per_day">Number of Steps Per Day <i class="text-danger">*</i> (0-50,000 steps)</label>
                                    <input type="number" class="form-control" name="number_of_steps_per_day" placeholder="0-50,000 steps" id="number_of_steps_per_day" value="{{ $user_info->number_of_steps_per_day }}" required >
                                    <span class="text-danger">{{ $errors->has('number_of_steps_per_day') ? $errors->first('number_of_steps_per_day') : '' }}</span>
                                </div>


                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="hydration_intake_unit">Hydration Intake Unit<i class="text-danger">*</i></label>
                                    <select name="hydration_intake_unit" id="hydration_intake_unit" required class="form-control">
                                        <option value="">Select One</option>
                                        <option {{ $user_info->hydration_intake_unit == 'liters' ? 'selected' : '' }} value="liters">Liters</option>
                                        <option {{ $user_info->hydration_intake_unit == 'ounces' ? 'selected' : '' }} value="ounces">Ounces</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('hydration_intake_unit') ? $errors->first('hydration_intake_unit') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="hydration_intake">Hydration Intake <i class="text-danger">*</i> (0.5–10 L) OR Ounces (16–340 oz)</label>
                                    <input type="number" step="any" class="form-control" name="hydration_intake" placeholder="(0.5–10 L) OR Ounces (16–340 oz)" id="hydration_intake" value="{{ $user_info->hydration_intake }}" required >
                                    <span class="text-danger">{{ $errors->has('hydration_intake') ? $errors->first('hydration_intake') : '' }}</span>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" onclick="prev_step('step_5', '4')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                        <a href="javascript:void(0)" onclick="next_step('step_5', '6')" class="btn btn-info">Next Step <i class="bx bxs-arrow-to-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="step_6 d-none">
                        <div class="card mb-6">
                            <div class="d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="card-header">Fitness Assessment</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="mb-4 col-md-6">
                                        <label class="form-label" for="can_you_perform_a_bodyweight_squat">Can you perform a bodyweight squat? <i class="text-danger">*</i></label>
                                        <select name="can_you_perform_a_bodyweight_squat" id="can_you_perform_a_bodyweight_squat" class="form-control" required>
                                            <option value="">Select One</option>
                                            <option {{ $user_info->can_you_perform_a_bodyweight_squat == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                            <option {{ $user_info->can_you_perform_a_bodyweight_squat == 'no' ? 'selected' : '' }} value="no">No</option>
                                            <option {{ $user_info->can_you_perform_a_bodyweight_squat == 'dont_know' ? 'selected' : '' }} value="dont_know">I Don’t Know</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->has('can_you_perform_a_bodyweight_squat') ? $errors->first('can_you_perform_a_bodyweight_squat') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label class="form-label" for="can_you_perform_a_push_up">Can you perform a Push-Up? <i class="text-danger">*</i></label>
                                        <select name="can_you_perform_a_push_up" id="can_you_perform_a_push_up" class="form-control" required>
                                            <option value="">Select One</option>
                                            <option {{ $user_info->can_you_perform_a_push_up == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                            <option {{ $user_info->can_you_perform_a_push_up == 'no' ? 'selected' : '' }} value="no">No</option>
                                            <option {{ $user_info->can_you_perform_a_push_up == 'dont_know' ? 'selected' : '' }} value="dont_know">I Don’t Know</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->has('can_you_perform_a_push_up') ? $errors->first('can_you_perform_a_push_up') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label class="form-label" for="can_you_perform_a_pull_up">Can you perform a Pull-Up? <i class="text-danger">*</i></label>
                                        <select name="can_you_perform_a_pull_up" id="can_you_perform_a_pull_up" class="form-control" required>
                                            <option value="">Select One</option>
                                            <option {{ $user_info->can_you_perform_a_pull_up == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                            <option {{ $user_info->can_you_perform_a_pull_up == 'no' ? 'selected' : '' }} value="no">No</option>
                                            <option {{ $user_info->can_you_perform_a_pull_up == 'dont_know' ? 'selected' : '' }} value="dont_know">I Don’t Know</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->has('can_you_perform_a_pull_up') ? $errors->first('can_you_perform_a_pull_up') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label class="form-label" for="max_reps_at_bodyweight">Max Reps at Bodyweight (e.g, push-ups, pull-ups) <i class="text-danger">*</i></label>
                                        <input type="number" step="any" class="form-control" name="max_reps_at_bodyweight" id="max_reps_at_bodyweight" value="{{ $user_info->max_reps_at_bodyweight }}" required >
                                        <span class="text-danger">{{ $errors->has('max_reps_at_bodyweight') ? $errors->first('max_reps_at_bodyweight') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label class="form-label" for="flexibility_assessment">Flexibility Assessment (e.g, sit-and-reach test) <i class="text-danger">*</i></label>
                                        <select name="flexibility_assessment" id="flexibility_assessment" class="form-control" required>
                                            <option value="">Select One</option>
                                            <option {{ $user_info->flexibility_assessment == 'Excellent' ? 'selected' : '' }} value="Excellent">Excellent</option>
                                            <option {{ $user_info->flexibility_assessment == 'Good' ? 'selected' : '' }} value="Good">Good</option>
                                            <option {{ $user_info->flexibility_assessment == 'Average' ? 'selected' : '' }} value="Average">Average</option>
                                            <option {{ $user_info->flexibility_assessment == 'Poor' ? 'selected' : '' }} value="Poor">Poor</option>
                                            <option {{ $user_info->flexibility_assessment == 'I Don’t Know' ? 'selected' : '' }} value="I Don’t Know">I Don’t Know</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->has('flexibility_assessment') ? $errors->first('flexibility_assessment') : '' }}</span>
                                    </div>

                                    {{--<div class="mb-4 col-md-6">
                                        <label class="form-label" for="range_motion_dont_know">Range of Motion for Key Joints (e.g, shoulder, hip) &nbsp; <input id="range_motion_dont_know" type="checkbox"> I don't know</label>
                                        <input type="text" class="form-control" name="range_of_motion_for_key_joints" id="range_of_motion_for_key_joints" value="{{ $user_info->range_of_motion_for_key_joints }}" >
                                        <span class="text-danger">{{ $errors->has('range_of_motion_for_key_joints') ? $errors->first('range_of_motion_for_key_joints') : '' }}</span>
                                    </div>--}}

                                    {{-- <div class="col-md-12 mt-4">
                                         <div class="d-flex justify-content-between final_btn">
                                             <a href="javascript:void(0)" onclick="prev_step('step_6', '5')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                             <button type="submit" class="btn btn-primary validate">Complete Profile</button>
                                         </div>
                                     </div>--}}

                                </div>
                            </div>
                        </div>

                        <div class="card mb-6">
                            <div class="d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="card-header">Motion Assessment</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Overhead Reach (Shoulder, Spine, Elbow)</span>
                                        <label class="form-label">Can you raise your arms fully overhead without pain or stiffness? <i class="text-danger">*</i></label>
                                        <select name="overhead" id="overhead" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->overhead == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('overhead') ? $errors->first('overhead') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Deep Squat (Hip, Knee, Ankle)</span>
                                        <label class="form-label" for="squat">Can you perform a deep squat without losing balance or feeling tight? <i class="text-danger">*</i></label>
                                        <select name="squat" id="squat" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->squat == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('squat') ? $errors->first('squat') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Toe Touch (Spine, Hamstrings)</span>
                                        <label class="form-label" for="toe_touch">Can you touch your toes without bending your knees? <i class="text-danger">*</i></label>
                                        <select name="toe_touch" id="toe_touch" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->toe_touch == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('toe_touch') ? $errors->first('toe_touch') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Shoulder Rotation (Shoulder)</span>
                                        <label class="form-label" for="shoulder_rotation">Can you rotate your shoulders fully without pain? <i class="text-danger">*</i></label>
                                        <select name="shoulder_rotation" id="shoulder_rotation" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->shoulder_rotation == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('shoulder_rotation') ? $errors->first('shoulder_rotation') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Hip Flexion (Hip)</span>
                                        <label class="form-label" for="hip_flexion">Can you bring your knee to your chest without discomfort? <i class="text-danger">*</i></label>
                                        <select name="hip_flexion" id="hip_flexion" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->hip_flexion == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('hip_flexion') ? $errors->first('hip_flexion') : '' }}</span>
                                    </div>

                                    <div class="mb-4 col-md-12">
                                        <span class="d-block text-dark mb-2" style="font-size: 17px">Ankle Mobility (Ankle)</span>
                                        <label class="form-label" for="ankle_mobility">Can you bring your knee to your chest without discomfort? <i class="text-danger">*</i></label>
                                        <select name="ankle_mobility" id="ankle_mobility" class="form-control" required>
                                            <option value="">Select One</option>
                                            @for($i=1; $i <=5; $i++)
                                                <option {{ $user_info->ankle_mobility == $i ? 'selected' : '' }} value="{{ $i }}">{{ "$i - ". getScoreLabel($i) }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">{{ $errors->has('ankle_mobility') ? $errors->first('ankle_mobility') : '' }}</span>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-flex justify-content-between final_btn">
                                            <a href="javascript:void(0)" onclick="prev_step('step_6', '5')" class="btn btn-warning"><i class="bx bxs-arrow-to-left"></i> Previous Step</a>
                                            <button type="submit" class="btn btn-primary validate">{{ $user->profile_complete == 1 ? 'Update Profile' : 'Complete Profile' }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        function next_step(current_step, next_id){

            if(stepValidation(current_step)){
                if(validateStep(current_step)){
                    $('.'+current_step).addClass('d-none');
                    $('.step_'+next_id).removeClass('d-none');
                    updateProgress(next_id)
                }


            }
        }

        function validateStep(current_step) {
            let validate = true;
            if(current_step == 'step_1'){
                //for weight
                let weight_unit = $("#weight_unit").val();
                let weight = $("#weight").val();
                if(weight_unit == 'kg'){
                    if(weight < 25 || weight > 300){
                        $("#weight").focus();
                        showToast('danger', 'topLeft', 'Weight range 25–300 kg');
                        return  false;
                    }
                }else{
                    if(weight < 55 || weight > 660){
                        $("#weight").focus();
                        showToast('danger', 'topLeft', 'Weight range 55–660 lbs');
                        return  false;
                    }
                }

                //for height
                let height_unit = $("#height_unit").val();
                if(height_unit == 'cm'){
                    let height_cm = $("#height_cm").val();
                    if(height_cm < 91 || height_cm > 224){
                        $("#height_cm").focus();
                        showToast('danger', 'topLeft', 'Height cm range 91–244 cm');
                        return  false;
                    }
                }else{
                    let height_feet = $("#height_feet").val();
                    if(height_feet < 3 || height_feet > 8){
                        $("#height_feet").focus();
                        showToast('danger', 'topLeft', 'Height feet range 3–8 ft');
                        return  false;
                    }
                    let height_inches = $("#height_inches").val();
                    if(height_inches < 0 || height_inches > 11){
                        $("#height_inches").focus();
                        showToast('danger', 'topLeft', 'Height inches range 0–11 in');
                        return  false;
                    }
                }

            }
            if(current_step == 'step_2'){
                let resting_heart_rate = $("#resting_heart_rate").val();
                if(resting_heart_rate < 30 || resting_heart_rate > 300){
                    $("#resting_heart_rate").focus();
                    showToast('danger', 'topLeft', 'Resting Heart Rate: 30–300 bpm');
                    return  false;
                }

                let systolic = $("#systolic").val();
                if(systolic < 70 || systolic > 240){
                    $("#systolic").focus();
                    showToast('danger', 'topLeft', 'Systolic range: 70–240 mmHg');
                    return  false;
                }

                let diastolic = $("#diastolic").val();
                if(diastolic < 40 || diastolic > 140){
                    $("#diastolic").focus();
                    showToast('danger', 'topLeft', 'Diastolic range: 40–140 mmHg');
                    return  false;
                }

            }
            if(current_step == 'step_3'){
                let weekly_commitment = $("#weekly_commitment").val();
                if(weekly_commitment < 0 || weekly_commitment > 7){
                    $("#weekly_commitment").focus();
                    showToast('danger', 'topLeft', 'Weekly commitment is between 0 and 7 days.');
                    return  false;
                }
            }
            if(current_step == 'step_4'){
                //neck_circumference
                let neck_circumference_unit = $("#neck_circumference_unit").val();
                let neck_circumference = $("#neck_circumference").val();
                if(neck_circumference_unit == 'centimeters'){
                    if(neck_circumference < 25 || neck_circumference > 50){
                        $("#neck_circumference").focus();
                        showToast('danger', 'topLeft', 'Neck Circumference range: 25–50 cm');
                        return  false;
                    }
                }else{
                    if(neck_circumference < 10 || neck_circumference > 20){
                        $("#neck_circumference").focus();
                        showToast('danger', 'topLeft', 'Neck Circumference range: 10–20 inches');
                        return  false;
                    }
                }

                //waist_measurement
                let waist_measurement_unit = $("#waist_measurement_unit").val();
                let waist_measurement = $("#waist_measurement").val();
                if(waist_measurement_unit == 'centimeters'){
                    if(waist_measurement < 50 || waist_measurement > 200){
                        $("#waist_measurement").focus();
                        showToast('danger', 'topLeft', 'Waist Measurement range: 50–200 cm');
                        return  false;
                    }
                }else{
                    if(waist_measurement < 20 || waist_measurement > 80){
                        $("#waist_measurement").focus();
                        showToast('danger', 'topLeft', 'Waist Measurement range: 20–80 inches');
                        return  false;
                    }
                }

                //hip_measurement
                let hip_measurement_unit = $("#hip_measurement_unit").val();
                let hip_measurement = $("#hip_measurement").val();
                if(hip_measurement_unit == 'centimeters'){
                    if(hip_measurement < 50 || hip_measurement > 200){
                        $("#hip_measurement").focus();
                        showToast('danger', 'topLeft', 'Hip Measurement range: 50–200 cm');
                        return  false;
                    }
                }else{
                    if(hip_measurement < 20 || hip_measurement > 80){
                        $("#hip_measurement").focus();
                        showToast('danger', 'topLeft', 'Hip Measurement range: 20–80 inches');
                        return  false;
                    }
                }

                //hip_measurement
                let chest_measurement_unit = $("#chest_measurement_unit").val();
                let chest_measurement = $("#chest_measurement").val();
                if(chest_measurement_unit == 'centimeters'){
                    if(chest_measurement < 50 || chest_measurement > 200){
                        $("#chest_measurement").focus();
                        showToast('danger', 'topLeft', 'Chest Measurement range: 50–200 cm');
                        return  false;
                    }
                }else{
                    if(chest_measurement < 20 || chest_measurement > 80){
                        $("#chest_measurement").focus();
                        showToast('danger', 'topLeft', 'Chest Measurement range: 20–80 inches');
                        return  false;
                    }
                }

                //body_fat_percentage
                let body_fat_percentage = $("#body_fat_percentage").val();
                if(body_fat_percentage != ''){
                    if(body_fat_percentage < 5 || body_fat_percentage > 60){
                        $("#body_fat_percentage").focus();
                        showToast('danger', 'topLeft', 'Body fat percentage range: 5-60%');
                        return  false;
                    }
                }

            }

            if(current_step == 'step_5'){

                //daily_sleep_duration
                /*let daily_sleep_duration = $("#daily_sleep_duration").val();
                if(daily_sleep_duration < 3 || daily_sleep_duration > 12){
                    $("#daily_sleep_duration").focus();
                    showToast('danger', 'topLeft', 'Daily sleep duration range: 3-12 hours');
                    return  false;
                }*/

                //number_of_steps_per_day
                let number_of_steps_per_day = $("#number_of_steps_per_day").val();
                if(number_of_steps_per_day < 0 || number_of_steps_per_day > 50000){
                    $("#number_of_steps_per_day").focus();
                    showToast('danger', 'topLeft', 'Number of steps per day: 0-50,000 steps');
                    return  false;
                }

                //hydration_intake
                let hydration_intake_unit = $("#hydration_intake_unit").val();
                let hydration_intake = $("#hydration_intake").val();
                if(hydration_intake_unit == 'liters'){
                    if(hydration_intake < 0.5 || hydration_intake > 10){
                        $("#hydration_intake").focus();
                        showToast('danger', 'topLeft', 'Hydration intake range: 0.5–10 liters');
                        return  false;
                    }
                }else{
                    if(hydration_intake < 16 || hydration_intake > 340){
                        $("#hydration_intake").focus();
                        showToast('danger', 'topLeft', 'Hydration intake range: 16–340 oz');
                        return  false;
                    }
                }


            }

            return validate;
        }

        function updateProgress(next_id) {
            let width = '10%';
            if(next_id == '2'){
                width = '20%';
            }else if(next_id == '3'){
                width = '40%';
            }else if(next_id == '4'){
                width = '60%';
            }else if(next_id == '5'){
                width = '80%';
            }else if(next_id == '6'){
                width = '100%';
            }
            $(".user_progress").css('width', width);
            $(".user_progress").html(width);
            $(".profile_complete").html(width);
        }

        function prev_step(current, prev) {
            $("."+current).addClass('d-none');
            $(".step_"+prev).removeClass('d-none');
            updateProgress(prev);
        }

        function stepValidation(current_step){
            var isValid = true;
            var firstInvalidInput = null; // To store the first invalid input

            // Loop through all the inputs to check if they are valid
            $(`.${current_step} input, .${current_step} select, .${current_step} textarea`).each(function () {
                if ($(this).prop('required') && ($(this).val() === null || $(this).val().trim() === '')) {
                    // Add error styling or display error message as per your UI design
                    $(this).addClass('is-invalid');

                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).next('.select2-container').find('span.select2-selection.select2-selection--single').addClass('is-invalid');
                    }

                    if ($(this).hasClass('dropify')) {
                        $(this).closest('.drop_inp').find('.dropify-wrapper').addClass('is-invalid');
                    } else {
                        $(this).addClass('is-invalid');
                    }

                    // If this is the first invalid input, store it
                    if (!firstInvalidInput) {
                        firstInvalidInput = $(this);
                    }

                    isValid = false; // Set validation flag to false
                } else {
                    $(this).removeClass('is-invalid');

                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).next('.select2-container').find('span.select2-selection.select2-selection--single').removeClass('is-invalid');
                    }

                    if ($(this).hasClass('dropify')) {
                        $(this).closest('.drop_inp').find('.dropify-wrapper').removeClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                }
            });

            // If all inputs are valid, move to the next step
            if (!isValid) {
                // Focus the first invalid input
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                }

                // Optionally, you can display a message or perform any other action
                //console.log('Validation failed. Please check your inputs.');
                showToast('danger', 'topLeft', 'Please fill in all required fields highlighted in red.');
                return false;
            }else{
                return  true;
            }
        }


        $(document).ready(function () {
            $("#height_unit").on('change', function () {
                var height_unit = $(this).val();
                if(height_unit == 'cm'){
                    $(".cm_div").removeClass('d-none');
                    $(".inches_div").addClass('d-none');

                    $("#height_cm").attr('required', true);

                    $("#height_feet").removeAttr('required');
                    $("#height_inches").removeAttr('required');

                }else{
                    $(".cm_div").addClass('d-none');
                    $(".inches_div").removeClass('d-none');

                    $("#height_feet").attr('required', true);
                    $("#height_inches").attr('required', true);

                    $("#height_cm").removeAttr('required');
                }
            });

            $("#food_preference").on('change', function () {
                let food_preference = $(this).val();
                if(food_preference == 'Other'){
                    $("#food_preference_other_div").removeClass('d-none');
                    $("#food_preference_other").attr('required', true);
                }else{
                    $("#food_preference_other_div").addClass('d-none');
                    $("#food_preference_other").removeAttr('required');
                }
            });

            $("#desired_fitness_goals").on('change', function () {
                let desired_fitness_goals = $(this).val();
                if(desired_fitness_goals == 'Other'){
                    $("#desired_fitness_goals_other_div").removeClass('d-none');
                    $("#desired_fitness_goals_other").attr('required', true);
                }else{
                    $("#desired_fitness_goals_other_div").addClass('d-none');
                    $("#desired_fitness_goals_other").removeAttr('required');
                }
            });

            $("#body_fat_dont_know").on('click', function () {
                if ($(this).is(':checked')) {
                    $("#body_fat_percentage").attr('disabled', true);
                    $("#body_fat_percentage").val('');
                } else {
                    $("#body_fat_percentage").removeAttr('disabled');
                }
            });

            $("#range_motion_dont_know").on('click', function () {

                if ($(this).is(':checked')) {
                    $("#range_of_motion_for_key_joints").attr('disabled', true);
                    $("#range_of_motion_for_key_joints").val('');
                } else {
                    $("#range_of_motion_for_key_joints").removeAttr('disabled');
                }
            });

            $(document).on("submit",".free_assessment_form",function(){
                var elem = $(this);
                $(elem).find("button[type=submit]").prop("disabled",true);
                var link = $(this).attr("action");
                var formData = new FormData(this);
                $.ajax({
                    method: "POST",
                    url: link,
                    data:  formData,
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        button_val = $(elem).find("button[type=submit]").text();
                        $(elem).find("button[type=submit]").html('Please Wait...');

                    },success: function(res){
                        window.setTimeout(function(){
                            $(elem).find("button[type=submit]").html(button_val);
                            $(elem).find("button[type=submit]").attr("disabled",false);
                        }, 1000);
                        var json = JSON.parse(res);
                        if(json['result'] == "success"){

                            showToast('success', 'topLeft', 'Profile successfully completed');

                            $(".final_btn").remove();
                            window.setTimeout(function(){
                                location.reload();
                            }, 1000);


                        }else{
                            showToast('danger', 'topLeft', 'Validation failed. please fill all inputs.');
                        }
                    },
                    error: function (xhr) {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $(".v-error").addClass('d-none');

                        var data = xhr.responseText;
                        var jsonData = JSON.parse(data);
                        $.each(jsonData.errors, function (key, value) {
                            var name = key;
                            $("input[name='" + name + "']").addClass('is-invalid');
                            $("select[name='" + name + "'] + span").addClass('is-invalid');
                            $("textarea[name='" + name + "']").addClass('is-invalid');
                            $("input[name='" + name + "'], select[name='" + name + "'], textarea[name='" + name + "']").parent().append("<span class='v-error' style='color: red'>" + value + "</span>");
                        });

                        showToast('danger', 'topLeft', 'Validation failed. please fill all inputs.');

                        window.setTimeout(function(){
                            $(elem).find("button[type=submit]").html(button_val);
                            $(elem).find("button[type=submit]").attr("disabled",false);
                        }, 300);
                    }
                });

                return false;
            });

        });

    </script>
@endpush
