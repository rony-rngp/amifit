@extends('layouts.frontend.app')

@push('css')
<style>
    .badge {
        display: inline-block;
        padding: 11px 10px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        background-color: green;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 10px;
        width: 100%;
    }

    /* Optional: Add hover effect */
    .badge:hover {
        background-color: #0056b3;
    }
</style>
@endpush

@section('content')
    <main class="flex-grow">
        <section class="relative bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">{{ get_settings('banner_title') }}</h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8">{{ get_settings('banner_subtitle') }}</p>
                <a href="#assessment" class="inline-block bg-orange-500 text-white font-bold py-3 px-8 rounded-full hover:bg-orange-600 transition duration-300 transform hover:scale-105">Start Your Free Assessment</a>
            </div>
        </section>
        <section class="bg-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center text-white mb-12">Why Choose AmiFit?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($why_chooses as $why_choose)
                    <div class="bg-gray-700 rounded-lg p-6 shadow-lg">
                        <h3 class="text-xl font-semibold text-orange-500 mb-4">{{ $why_choose->title }}</h3>
                        <p class="text-gray-300">{{ $why_choose->sub_title }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="packages" class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center text-white mb-12">Choose Your Transformation Package</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($plans as $plan)
                    <div class="bg-gray-800 rounded-lg p-6 shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">{{ $plan->badge_title }}</div>
                        <h3 class="text-xl font-semibold text-orange-500 mb-4">{{ $plan->name }}</h3>
                        <p class="text-3xl font-bold mb-2">
                            {{ base_currency_name() }}
                            @if($plan->discount > 0)
                                {{ $plan->price - (($plan->discount/100) * $plan->price)}}
                            @else
                                {{ $plan->price }}
                            @endif
                            <span class="text-lg font-normal text-gray-400"> / month</span></p>
                        @if($plan->discount > 0)
                        <p class="text-sm text-gray-400 mb-1">Was <span class="line-through">{{ base_currency_name() .' '. $plan->price }}</span></p>
                        <p class="text-sm text-green-500 font-semibold mb-4">Save {{ $plan->discount }}%</p>
                        @else
                            <p class="d-block mb-8"></p>
                        @endif
                        <ul class="text-gray-300 mb-6">
                            @php($options = json_decode($plan->options))
                            @foreach($options ?? [] as $option)
                            <li class="flex items-center mb-2">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $option }}
                            </li>
                            @endforeach
                        </ul>
                        <a href="#" class="block text-center bg-orange-500 text-white font-bold py-2 px-4 rounded-full hover:bg-orange-600 transition duration-300">Choose Plan</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="assessment" class="py-16 bg-gray-800 ">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center text-white mb-12">Free Fitness Assessment</h2>
                <form action="{{ route('free_fitness_assessment') }}" method="post" id="assessmentForm" class="space-y-6 free_assessment_form">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                        <input type="text" id="name" name="name" value="{{ @Auth::user()->name }}" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="birthday" class="block text-sm font-medium text-gray-300 mb-1">Birthday </label>
                            <input type="date" id="birthday" name="birthday" placeholder="12–120 years" value="{{ @Auth::user()->birthday }}" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-300 mb-1">Sex</label>
                            <select id="sex" name="sex" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select</option>
                                <option {{ @Auth::user()->sex == 'male' ? 'selected' : '' }} value="male">Male</option>
                                <option {{ @Auth::user()->sex == 'female' ? 'selected' : '' }} value="female">Female</option>
                                <option {{ @Auth::user()->sex == 'other' ? 'selected' : '' }} value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="weight_unit" class="block text-sm font-medium text-gray-300 mb-1">Weight Unit</label>
                            <select id="weight_unit" name="weight_unit" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">-- Select KG/Pounds --</option>
                                <option value="kg">KG</option>
                                <option value="pounds">Pounds</option>
                            </select>
                        </div>
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-300 mb-1">Weight</label>
                            <input type="number" id="weight" name="weight" placeholder="kg: 25–300 & lbs: 55–660 " required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                    </div>
                    <div>
                        <label for="height_unit" class="block text-sm font-medium text-gray-300 mb-1">Height Unit</label>
                        <select id="height_unit" name="height_unit" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">-- Select CM/Feet & Inches --</option>
                            <option value="cm">CM</option>
                            <option value="inches">Inches</option>
                        </select>
                    </div>
                    <div id="cmHeight" class="cm_div hidden">
                        <label for="height_cm" class="block text-sm font-medium text-gray-300 mb-1">Height (cm)</label>
                        <input type="number" id="height_cm" name="height_cm" min="91" max="244" placeholder="91–244 cm" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>
                    <div id="inchesHeight" class="inches_div hidden">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="height_feet" class="block text-sm font-medium text-gray-300 mb-1">Height (feet)</label>
                                <input type="number" id="height_feet" min="3" max="8" placeholder="feet: 3–8 ft" name="height_feet" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="height_inches" class="block text-sm font-medium text-gray-300 mb-1">Height (inches)</label>
                                <input type="number" id="height_inches" min="0" max="11" placeholder="inches: 0–11 in" name="height_inches" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="activity_level" class="block text-sm font-medium text-gray-300 mb-1">Activity Level</label>
                        <select id="activity_level" name="activity_level" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Select</option>
                            <option value="sedentary">Sedentary (little to no exercise)</option>
                            <option value="lightly">Light (1-2 days of light activity per week)</option>
                            <option value="moderately">Moderate (3-4 days of moderate exercise per week)</option>
                            <option value="very">heavy (5+ days of intense exercise per week)</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 text-white font-bold py-3 px-4 rounded-full hover:bg-orange-600 transition duration-300">Get Your Free Assessment</button>
                </form>
            </div>
        </section>

        <section id="assessmentResult" class="hidden py-16 bg-gray-900">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center text-white mb-12">Your Fitness Assessment Result</h2>
                <div id="statusResult" class="mb-8"></div>
                <div id="calorieResult" class="mb-8"></div>
                <div id="macroResult" class="mb-8"></div>
                <div class="badge hidden" id="reg_msg">
                   Registration Successful. Redirecting...
                </div>
                @if(!\Illuminate\Support\Facades\Auth::check())
                <form action="{{ route('register') }}" id="regForm" method="post">
                    @csrf
                    <div id="quoteResult" class="mb-8">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Enter your email</label>
                            <input type="email" id="email" name="email" required placeholder="Email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                    <button type="submit" style="width: 100%" id="regBtn" class="block text-center bg-green-500 text-white font-bold py-3 px-4 rounded-full hover:bg-green-600 transition duration-300">Start Your Journey Now</button>

                </form>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $("#height_unit").on('change', function () {
                var height_unit = $(this).val();
                if(height_unit == 'cm'){
                    $(".cm_div").removeClass('hidden');
                    $(".inches_div").addClass('hidden');

                    $("#height_cm").attr('required', true);

                    $("#height_feet").removeAttr('required');
                    $("#height_inches").removeAttr('required');

                }else{
                    $(".cm_div").addClass('hidden');
                    $(".inches_div").removeClass('hidden');

                    $("#height_feet").attr('required', true);
                    $("#height_inches").attr('required', true);

                    $("#height_cm").removeAttr('required');
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

                            var data = json.data;

                            let heightInMeters;
                            if (data.height_unit === 'cm') {
                                heightInMeters = parseFloat(data.height_cm) / 100;
                            } else {
                                const heightInInches = (parseFloat(data.height_feet) * 12) + parseFloat(data.height_inches);
                                heightInMeters = heightInInches * 0.0254;
                            }

                            let weightInKg;
                            if (data.weight_unit === 'kg') {
                                weightInKg = parseFloat(data.weight);
                            } else {
                                weightInKg = parseFloat(data.weight) * 0.453592;
                            }

                            const bmi = weightInKg / (heightInMeters * heightInMeters);

                            // Determine BMI category
                            let bmiCategory;
                            if (bmi < 18.5) bmiCategory = 'Underweight';
                            else if (bmi < 25) bmiCategory = 'Normal';
                            else if (bmi < 30) bmiCategory = 'Overweight';
                            else bmiCategory = 'Obese';

                            // Calculate daily calorie intake (very basic calculation, should be more complex in real app)
                            const birthday = data.birthday;
                            const sex = data.sex;
                            const age = calculateAge(birthday);

                            let bmr;
                            if (sex === 'male') {
                                bmr = 88.362 + (13.397 * weightInKg) + (4.799 * heightInMeters * 100) - (5.677 * age);
                            } else {
                                bmr = 447.593 + (9.247 * weightInKg) + (3.098 * heightInMeters * 100) - (4.330 * age);
                            }

                            let activityFactor;
                            switch (data.activity_level) {
                                case 'sedentary': activityFactor = 1.2; break;
                                case 'lightly': activityFactor = 1.375; break;
                                case 'moderately': activityFactor = 1.55; break;
                                case 'very': activityFactor = 1.725; break;
                                case 'super': activityFactor = 1.9; break;
                            }

                            const dailyCalories = Math.round(bmr * activityFactor);

                            // Generate results
                            document.getElementById('statusResult').innerHTML = `
                                <h3 class="text-2xl font-semibold text-white mb-4">Your Weight Index Status: ${bmiCategory}</h3>
                                <div class="w-full bg-gray-700 rounded-full h-2.5 mb-4">
                                  <div class="bg-orange-500 h-2.5 rounded-full" style="width: ${(bmi / 40) * 100}%"></div>
                                </div>
                              `;

                            document.getElementById('calorieResult').innerHTML = `
                                <h3 class="text-2xl font-semibold text-white mb-4">Recommended Daily Calorie Intake: ${dailyCalories}</h3>
                                <div class="w-full bg-gray-700 rounded-full h-2.5 mb-4">
                                  <div class="bg-orange-500 h-2.5 rounded-full" style="width: ${(dailyCalories / 3000) * 100}%"></div>
                                </div>
                              `;


                            const protein = Math.round(dailyCalories * 0.3 / 4);
                            const carbs = Math.round(dailyCalories * 0.4 / 4);
                            const fat = Math.round(dailyCalories * 0.3 / 9);

                            document.getElementById('macroResult').innerHTML = `
                                <h3 class="text-2xl font-semibold text-white mb-4">Daily Macro Distribution</h3>
                                <div class="flex mb-2">
                                  <div class="bg-blue-500 h-4" style="width: 30%"></div>
                                  <div class="bg-green-500 h-4" style="width: 40%"></div>
                                  <div class="bg-red-500 h-4" style="width: 30%"></div>
                                </div>
                                <div class="flex justify-between text-sm text-gray-300">
                                  <span>Protein: ${protein}g</span>
                                  <span>Carbs: ${carbs}g</span>
                                  <span>Fat: ${fat}g</span>
                                </div>
                              `;


                            document.getElementById('assessmentResult').classList.remove('hidden');
                            document.getElementById('assessmentResult').scrollIntoView({ behavior: 'smooth' });

                        }else{
                            jQuery.each( json['message'], function( i, val ) {
                                iziToast.error({
                                    message: val ,position: 'topRight',
                                    width: '270',
                                });
                            });

                        }
                    },
                    error: function (xhr) {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $(".v-error").addClass('hidden');

                        var data = xhr.responseText;
                        var jsonData = JSON.parse(data);
                        $.each(jsonData.errors, function (key, value) {
                            var name = key;
                            $("input[name='" + name + "']").addClass('is-invalid');
                            $("select[name='" + name + "'] + span").addClass('is-invalid');
                            $("textarea[name='" + name + "']").addClass('is-invalid');
                            $("input[name='" + name + "'], select[name='" + name + "'], textarea[name='" + name + "']").parent().append("<span class='v-error' style='color: red'>" + value + "</span>");
                        });

                        iziToast.error({
                            message: 'Validation failed. please fill all inputs' ,position: 'topRight',
                            width: '270',
                        });

                        window.setTimeout(function(){
                            $(elem).find("button[type=submit]").html(button_val);
                            $(elem).find("button[type=submit]").attr("disabled",false);
                        }, 300);
                    }
                });

                return false;
            });


            $(document).on("submit","#regForm",function(){
                var elem = $(this);
                $("#regBtn").prop("disabled",true);
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
                        button_val = $("#regBtn").text();
                        $("#regBtn").html('Please Wait...');

                    },success: function(res){
                        window.setTimeout(function(){
                            $("#regBtn").html(button_val);
                            $("#regBtn").attr("disabled",false);
                        }, 1000);

                        var json = JSON.parse(res);
                        if(json['result'] == "success"){
                            $("#reg_msg").removeClass('hidden');
                            console.log(json.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('user.complete_info') }}';
                            }, 2000);

                        }else{
                            jQuery.each( json['message'], function( i, val ) {
                                iziToast.error({
                                    message: val ,position: 'topRight',
                                    width: '270',
                                });
                            });

                        }
                    },
                    error: function (xhr) {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $(".v-error").addClass('hidden');

                        var data = xhr.responseText;
                        var jsonData = JSON.parse(data);
                        $.each(jsonData.errors, function (key, value) {
                            var name = key;
                            $("input[name='" + name + "']").addClass('is-invalid');
                            $("select[name='" + name + "'] + span").addClass('is-invalid');
                            $("textarea[name='" + name + "']").addClass('is-invalid');
                            $("input[name='" + name + "'], select[name='" + name + "'], textarea[name='" + name + "']").parent().append("<span class='v-error' style='color: red'>" + value + "</span>");
                        });

                        window.setTimeout(function(){
                            $("#regBtn").html(button_val);
                            $("#regBtn").attr("disabled",false);
                        }, 300);
                    }
                });

                return false;
            });

        });

        function calculateAge(birthdate) {
            const birthYear = new Date(birthdate).getFullYear();
            const currentYear = new Date().getFullYear();
            return currentYear - birthYear;
        }

    </script>
@endpush
