<?php

function get_settings($key){
    $config = null;
    $data = \App\Models\Setting::where('key', $key)->first();
    if (isset($data)){
        $config = json_decode($data['value'], true);
        if (is_null($config)) {
            $config = $data['value'];
        }
    }
    return $config;
}

function pagination_limit(){
    return 25;
}

function base_currency(){
    return '৳';
}

function base_currency_name(){
    return 'BDT';
}

function upload_image($dir, $image = null){
    if ($image != null) {
        $ext = $image->getClientOriginalExtension();
        $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $ext;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dir)) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($dir);
        }
        \Illuminate\Support\Facades\Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
    } else {
        $imageName = '';
    }
    return $dir.$imageName;
}

function update_image( $dir, $old_image, $image = null){
    if ($old_image != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists( $old_image)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($old_image);
    }
    $imageName = upload_image($dir, $image);
    return $imageName;
}

function delete_image($full_path){
    if ($full_path != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($full_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($full_path);
    }
}

function calculate_data($data){
    // Convert height to meters
    $heightInMeters = 0;
    if ($data['height_unit'] === 'cm') {
        $heightInMeters = (float) $data['height_cm'] / 100;
    } else {
        $heightInInches = ((float)$data['height_feet'] * 12) + (float)$data['height_inches'];
        $heightInMeters = $heightInInches * 0.0254;
    }

    // Convert weight to kilograms
    $weightInKg = 0;
    if ($data['weight_unit'] === 'kg') {
        $weightInKg = (float)$data['weight'];
    } else {
        $weightInKg = (float)$data['weight'] * 0.453592;
    }

    // Calculate BMI
    $bmi = $weightInKg / ($heightInMeters * $heightInMeters);

    // Determine BMI category and associated messages
    $bmiCategory = '';
    $dangerText = '';
    $hopeText = '';

    if ($bmi < 18.5) {
        $bmiCategory = 'Underweight';
        $dangerText = "Being underweight can lead to a weakened immune system, osteoporosis, and fertility issues. Your current status may indicate a 20% higher risk of certain health complications.";
        $hopeText = "With proper nutrition and a balanced fitness plan, you can safely gain weight and improve your overall health and well-being.";
    } elseif ($bmi < 25) {
        $bmiCategory = 'Normal';
        $dangerText = "While your weight is in the normal range, it's important to maintain a balanced diet and regular exercise routine to prevent future health issues.";
        $hopeText = "By continuing to focus on your fitness and nutrition, you can further improve your health and reduce the risk of future complications.";
    } elseif ($bmi < 30) {
        $bmiCategory = 'Overweight';
        $dangerText = "Being overweight increases your risk of developing type 2 diabetes, high blood pressure, and heart disease. Your current status puts you at a 15% higher risk of cardiovascular issues compared to those in the normal weight range.";
        $hopeText = "The good news is that even a modest weight loss of 5-10% can have significant health benefits and reduce your risk factors.";
    } else {
        $bmiCategory = 'Obese';
        $dangerText = "Your current fitness status indicates potential risks such as cardiovascular issues, diabetes, and joint pain. There's a 29% chance of a heart attack or 20% chance of a stroke in the next 10 years if no changes are made.";
        $hopeText = "By making small changes and staying consistent, you can significantly reduce these risks and improve your overall health.";
    }

    // Calculate age based on birthday (assuming $birthday is in 'Y-m-d' format)
    $birthday = auth()->user()->birthday; // Get the authenticated user's birthday
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    // Calculate BMR based on sex and weight/height/age
    $sex = auth()->user()->sex; // Get the authenticated user's sex
    if ($sex === 'male') {
        $bmr = 88.362 + (13.397 * $weightInKg) + (4.799 * $heightInMeters * 100) - (5.677 * $age);
    } else {
        $bmr = 447.593 + (9.247 * $weightInKg) + (3.098 * $heightInMeters * 100) - (4.330 * $age);
    }

    // Calculate activity factor based on activity level
    $activityFactor = 1.0;
    switch ($data['activity_level']) {
        case 'sedentary':
            $activityFactor = 1.2;
            break;
        case 'lightly':
            $activityFactor = 1.375;
            break;
        case 'moderately':
            $activityFactor = 1.55;
            break;
        case 'very':
            $activityFactor = 1.725;
            break;
        case 'super':
            $activityFactor = 1.9;
            break;
    }

    $dailyCalories = round($bmr * $activityFactor);

    // Return all data including the new danger and hope texts
    return [
        'bmi' => round($bmi, 2),
        'bmi_category' => $bmiCategory,
        'danger_text' => $dangerText,
        'hope_text' => $hopeText,
        'daily_calories' => $dailyCalories,
        'bmr' => round($bmr, 2),
        'activity_factor' => $activityFactor,
        'age' => $age
    ];

}

function getMonthlyRanges($startDate, $months) {
    $ranges = [];
    $date = new DateTime($startDate); // Start from given date

    for ($i = 0; $i < $months; $i++) {
        $start_date = $date->format('Y-m-d'); // Given start date
        $end_date = (clone $date)->modify('+30 days')->format('Y-m-d'); // 30 days from start date

        $ranges[] = [
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        // Move to the same day next month, adjusting if the day doesn't exist
        $date->modify('+1 month');
    }

    return $ranges;
}

function checkPayment($order_id, $start_date, $end_date) {

    $current_data = date('Y-m-d'); // Get today's date
    //$current_data = date('Y-m-d', strtotime('2025-05-02'));
    $order_payment = null;
    if($current_data > $end_date){
        $order_payment = \App\Models\OrderPayment::where('order_id', $order_id)->orderBy('id', 'desc')->first();
    }elseif ($current_data < $start_date){
        $order_payment = \App\Models\OrderPayment::where('order_id', $order_id)->orderBy('id', 'asc')->first();
    }else{
        $order_payment = \App\Models\OrderPayment::where('order_id', $order_id)
            ->whereDate('start_date', '<=', $current_data)
            ->whereDate('end_date', '>=', $current_data)
            ->first();
    }
    return $order_payment;
}

function checkAge($birthday){
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

function calculateBmiAndBmr($user){
    $data = $user->last_user_info;
    $heightInMeters = 0;
    if ($data['height_unit'] === 'cm') {
        $heightInMeters = (float) $data['height_cm'] / 100;
    } else {
        $heightInInches = ((float)$data['height_feet'] * 12) + (float)$data['height_inches'];
        $heightInMeters = $heightInInches * 0.0254;
    }

    // Convert weight to kilograms
    $weightInKg = 0;
    if ($data['weight_unit'] === 'kg') {
        $weightInKg = (float)$data['weight'];
    } else {
        $weightInKg = (float)$data['weight'] * 0.453592;
    }

    // Calculate BMI
    $bmi = $weightInKg / ($heightInMeters * $heightInMeters);
    //return round($bmi, 2);


    $age = checkAge($user->birthday);
    $sex = $user->sex; // Get the authenticated user's sex
    if ($sex === 'male') {
        $bmr = 88.362 + (13.397 * $weightInKg) + (4.799 * $heightInMeters * 100) - (5.677 * $age);
    } else {
        $bmr = 447.593 + (9.247 * $weightInKg) + (3.098 * $heightInMeters * 100) - (4.330 * $age);
    }

    // Return all data including the new danger and hope texts
    return [
        'bmi' => round($bmi, 2),
        'bmr' => round($bmr, 2),
    ];

}

function convertWeightKG($weight_unit, $weight){
    $weightInKg = 0;
    if ($weight_unit === 'kg') {
        $weightInKg = (float)$weight;
    } else {
        $weightInKg = (float)$weight * 0.453592;
    }
    return number_format($weightInKg, 2);
}

function isNegative($difference){
    if ($difference < 0) {
        // The result is negative
        return true;
    } else {
        // The result is positive or zero
        return false;
    }
}

function convertHeightInMeter($data){
    $heightInMeters = 0;
    if ($data['height_unit'] === 'cm') {
        $heightInMeters = (float) $data['height_cm'] / 100;
    } else {
        $heightInInches = ((float)$data['height_feet'] * 12) + (float)$data['height_inches'];
        $heightInMeters = $heightInInches * 0.0254;
    }
    return round($heightInMeters, 2);
}

function convertInchToCM($unit, $value){
    if ($unit === 'inches') {
        return round($value * 2.54, 2);
    }else{
        return $value;
    }
}

function getScoreLabel($score) {
    switch ($score) {
        case 1: return "Restricted";
        case 2: return "Limited";
        case 3: return "Average";
        case 4: return "Good";
        case 5: return "Excellent";
        default: return "";
    }
}

function generateUniqueCode()
{
    do {
        $code = rand(000000, 999999);
    } while (\App\Models\User::where('otp', $code)->exists());

    return $code;
}
