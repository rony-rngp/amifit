@extends('layouts.user.app')

@section('title', 'Order Details')

@push('css')
<style>
    .fc-event-time{display: none !important;}

    @media (max-width: 576px) {
        .fc-header-toolbar.fc-toolbar{display: block !important;}
    }

</style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
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

            @php($payment_data = checkPayment($order->id, $order->start_date, $order->end_date))

            <div class="col-md-12">
                <div class="card mb-6">
                    <div>
                        <h5 class="card-header border-bottom">Plan Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="d-block mb-2"><span class="fw-bold">Order ID</span> : {{ @$order->id }}</span>
                                <span class="d-block mb-2"><span class="fw-bold">Plan Name</span> : {{ @$order->plan_info['name'] }}</span>
                                <span class="d-block mb-2"><span class="fw-bold">Duration</span> : {{ @$order->plan_info['duration'] }} Month</span>
                                <span class="d-block mb-2"><span class="fw-bold">Monthly Price</span> : {{ @$order['monthly_price'] }} {{ base_currency_name() }}</span>

                            </div>

                            <div class="col-md-6">
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
                    </div>
                </div>
            </div>

        </div>

        {{--@if(date('Y-m-d') >= $order->start_date)--}}
        @if(date('Y-m-d') >= $order->start_date)

            {{--@php($payment_data = checkPayment($order->id, $order->start_date, $order->end_date))--}}
            @if($payment_data['payment_status'] == 'Paid')
                <div class="row">
                    <div class="col-md-12 mb-6">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center" >
                                <h5 class="card-header">Diet Plan</h5>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Food</th>
                                        <th>Serving Size (g)</th>
                                        <th>Carbohydrate (g)</th>
                                        <th>Protein (g)</th>
                                        <th>Fat (g)</th>
                                        <th>Fiber (g)</th>
                                        <th>Sugars (g)</th>
                                        <th>Calories</th>
                                        <th>Tips</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    <?php
                                        $total_carbohydrate = 0;
                                        $total_protein = 0;
                                        $total_fat = 0;
                                        $total_fiber = 0;
                                        $total_sugar = 0;
                                        $total_calorie = 0;
                                    ?>
                                    @forelse($order->diet_plans as $diet_plan)
                                        <tr>
                                            <td>{{ $diet_plan->time }}</td>
                                            <td title="{{ $diet_plan->food }}">
                                                {{ Str::limit($diet_plan->food, 30) }}
                                            </td>
                                            <td>{{ $diet_plan->serving_size }}</td>
                                            <td>{{ $diet_plan->carbohydrate }}</td>
                                            <td>{{ $diet_plan->protein }}</td>
                                            <td>{{ $diet_plan->fat }}</td>
                                            <td>{{ $diet_plan->fiber }}</td>
                                            <td>{{ $diet_plan->sugar }}</td>
                                            <td>{{ $diet_plan->calorie }}</td>
                                            <td>{{ $diet_plan->tips != '' ? $diet_plan->tips :  '-' }}</td>
                                        </tr>
                                        <?php
                                        $total_carbohydrate += $diet_plan->carbohydrate;
                                        $total_protein += $diet_plan->protein;
                                        $total_fat += $diet_plan->fat;
                                        $total_fiber += $diet_plan->fiber;
                                        $total_sugar += $diet_plan->sugar;
                                        $total_calorie += $diet_plan->calorie;
                                        ?>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Data not found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Total :</td>
                                        <td>{{ $total_carbohydrate }}</td>
                                        <td>{{ $total_protein }}</td>
                                        <td>{{ $total_fat }}</td>
                                        <td>{{ $total_fiber }}</td>
                                        <td>{{ $total_sugar }}</td>
                                        <td>{{ $total_calorie }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-6">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center" >
                                <h5 class="card-header">Workout Plan</h5>
                            </div>

                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Workout</th>
                                        <th>Sets</th>
                                        <th>Reps</th>
                                        <th>Rest</th>
                                        <th>Suggestion</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @forelse($order->workout_plans as $workout_plan)
                                        <tr>
                                            <td>{{ $workout_plan->day }}</td>
                                            <td>{{ $workout_plan->workout }}</td>
                                            <td>{{ $workout_plan->sets }}</td>
                                            <td>{{ $workout_plan->reps }}</td>
                                            <td>{{ $workout_plan->rest }}</td>
                                            <td>{{ $workout_plan->suggestion }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data not found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-6">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center border-bottom" >
                                <h5 class="card-header" >Guideline</h5>
                            </div>
                            <div class="card-body">
                                {!! nl2br($order->guideline) !!}
                            </div>
                        </div>
                    </div>
                </div>

                @php($first_info = count($user_infos) > 0 ? $user_infos[0] : null)
                @php($last_info = count($user_infos) > 1 ? $user_infos->last() : null)

                <div class="row">
                    <div class="col-md-5 mb-6">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center border-bottom" >
                                <h5 class="card-header" >Quick Starts</h5>
                            </div>
                            <div class="card-body fw-bold">
                                <?php
                                $first_weight =  convertWeightKG($first_info->weight_unit, $first_info->weight);
                                $first_bmi = calculateBmi($first_info);
                                if($last_info != null){
                                    $last_weight =  convertWeightKG($last_info->weight_unit, $last_info->weight);
                                    $last_bmi = calculateBmi($last_info);
                                }
                                ?>

                                <span class="d-block mb-2">
                                    Weight: {{ $last_info != null ? $last_weight : $first_weight }} KG
                                    @if($last_info != null)
                                        ({{ !isNegative($last_weight - $first_weight) ? '+' : '' }}{{ $last_weight - $first_weight }} KG)
                                    @endif
                                </span>

                                <span class="d-block mb-2">
                                    BMI: {{ $last_info != null ? $last_bmi : $first_bmi }}
                                    @if($last_info != null)
                                        ({{ !isNegative($last_bmi - $first_bmi) ? '+' : '' }}{{ $last_bmi - $first_bmi }})
                                    @endif
                                </span>

                                <?php
                                $first_nick_measurement = convertInchToCM($first_info->neck_circumference_unit, $first_info->neck_circumference);
                                if($last_info != null){
                                    $last_nick_measurement = convertInchToCM($last_info->neck_circumference_unit, $last_info->neck_circumference);
                                }
                                ?>
                                <span class="d-block mb-2">
                                    Nick Measurement: {{ $last_info != null ? $last_nick_measurement : $first_nick_measurement }} CM
                                    @if($last_info != null)
                                        ({{ !isNegative($last_nick_measurement - $first_nick_measurement) ? '+' : '' }}{{ $last_nick_measurement - $first_nick_measurement }} CM)
                                    @endif
                                </span>

                                <?php
                                 $first_waist_measurement = convertInchToCM($first_info->waist_measurement_unit, $first_info->waist_measurement);
                                 if($last_info != null){
                                    $last_waist_measurement = convertInchToCM($last_info->waist_measurement_unit, $last_info->waist_measurement);
                                 }
                                ?>
                                <span class="d-block mb-2">
                                    Waist Measurement: {{ $last_info != null ? $last_waist_measurement : $first_waist_measurement }} CM
                                    @if($last_info != null)
                                        ({{ !isNegative($last_waist_measurement - $first_waist_measurement) ? '+' : '' }}{{ $last_waist_measurement - $first_waist_measurement }} CM)
                                    @endif
                                </span>

                                <?php
                                $first_hip_measurement = convertInchToCM($first_info->hip_measurement_unit, $first_info->hip_measurement);
                                if($last_info != null){
                                    $last_hip_measurement = convertInchToCM($last_info->hip_measurement_unit, $last_info->hip_measurement);
                                }
                                ?>
                                <span class="d-block mb-2">
                                    Hip Measurement: {{ $last_info != null ? $last_hip_measurement : $first_hip_measurement }} CM
                                    @if($last_info != null)
                                        ({{ !isNegative($last_hip_measurement - $first_hip_measurement) ? '+' : '' }}{{ $last_hip_measurement - $first_hip_measurement }} CM)
                                    @endif
                                 </span>


                                <?php
                                $first_chest_measurement = convertInchToCM($first_info->chest_measurement_unit, $first_info->chest_measurement);
                                if($last_info != null){
                                    $last_chest_measurement = convertInchToCM($last_info->chest_measurement_unit, $last_info->chest_measurement);
                                }
                                ?>
                                <span class="d-block mb-2">
                                    Chest Measurement: {{ $last_info != null ? $last_chest_measurement : $first_chest_measurement }} CM
                                    @if($last_info != null)
                                        ({{ !isNegative($last_chest_measurement - $first_chest_measurement) ? '+' : '' }}{{ $last_chest_measurement - $first_chest_measurement }} CM)
                                    @endif
                                </span>




                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 mb-6">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center border-bottom" >
                                <h5 class="card-header" >Daily </h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <p class="fw-bold mb-2">Motivational Boost</p>
                                    <div>
                                        {!! nl2br($order->motivational_boost) !!}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold mb-2">Today's Win</p>
                                    <div>
                                        {!! nl2br($order->today_win) !!}
                                    </div>
                                </div>

                                <div class="">
                                    <p class="fw-bold mb-2">Focus Area</p>
                                    <div>
                                        {!! nl2br($order->focus_area) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


                <div class="row mb-6 mb-6">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center border-bottom" >
                                <h5 class="card-header">Interactive Calender</h5>
                                @if($order->status == 'Running')
                                <div class="me-5">
                                    <a href="{{ route('user.add_calender_event', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" data-title="Calender Event" class="btn btn-primary ajax-modal"> Add Event</a>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card mb-6">
                    <div class="card-body">
                        <span class="d-block fw-bold text-center mt-6 mb-2 text-danger" style="font-size: 20px">Your payment is currently pending.</span>
                        <span class="d-block fw-bold text-center mb-2 text-danger" style="font-size: 20px">Billing Period: {{ \Carbon\Carbon::parse(@$payment_data['start_date'])->format('F j, Y') }} – {{ \Carbon\Carbon::parse(@$payment_data['end_date'])->format('F j, Y') }}</span>
                        <span class="d-block fw-bold text-center  mb-6 text-danger" style="font-size: 20px"> Status: {{ @$payment_data['payment_status'] }} </span>
                    </div>
                </div>
            @endif
        @else
            <div class="card mb-6">
                <div class="card-body">
                    <span class="d-block fw-bold text-center mt-6 mb-6 text-danger" style="font-size: 20px">Your journey will start on {{ $order->start_date }}</span>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Payment Information</h5>
                    </div>

                    <div class="card-body">
                        <div class="">
                            <h3 class="h5 text-dark mb-4 text-center">Payment Progress ({{ ($order->order_payments->where('payment_status', 'Paid')->count()/count($order->order_payments)*100) }}%)</h3>
                            <div class="d-flex mb-2">
                                @foreach($order->order_payments as $order_payment)
                                <div title="{{ $order_payment->payment_status }}" class="bg-{{ $order_payment->payment_status == 'Paid' ? 'primary' : 'danger' }}" style="width: 100%;height: 20px;text-align: center; color: white;border: 1px solid white">
                                    <span class="d-block ds">{{ $order_payment->payment_status }}</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between text-dark small">
                                @foreach($order->order_payments as $order_payment)
                                    <span >({{ $order_payment->start_date }} - {{ $order_payment->end_date }})</span>
                                @endforeach
                            </div>

                            <div class="text-center fw-bold mt-6">
                                @php($last = collect($order->order_payments)->sortDesc()->first())
                                Journey End Date: {{ $last->end_date }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

@endsection

@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        $(document).ready(function() {
            var calendar = new FullCalendar.Calendar($('#calendar')[0], {
                themeSystem: 'bootstrap4',
                events: [
                        @foreach($event_calenders as $event_calender)
                    {
                        title: 'Missed: {{ $event_calender->missed_diet == 1 ? 'Workout' : ''  }} @if($event_calender->missed_workout == 1)& Diet @endif',
                        start: '{{ $event_calender->date.'T00:00:00' }}',
                        end: '{{ $event_calender->date.'T23:59:59' }}',
                    },
                    @endforeach
                ],
                dateClick: function(info) {
                    // Get the "Add Event" button
                    var addEventButton = $('a[data-title="Calender Event"]');
                    if (addEventButton.length) {
                        // Set the clicked date in the event date field (for form submission if necessary)

                        // Dynamically update the button's href to include the selected date as a URL parameter
                        var url = addEventButton.attr('href');  // Get the current href of the "Add Event" button
                        url = new URL(url, window.location.origin);  // Create a full URL from the relative href

                        // Append the selected date to the URL as a query parameter (e.g., ?date=2025-02-27)
                        url.searchParams.set('date', info.dateStr);

                        // Update the href of the "Add Event" button with the new URL
                        addEventButton.attr('href', url.toString());

                        // Trigger the click event on the "Add Event" button
                        addEventButton.trigger('click');
                    }

                },
                eventClick: function(info) {
                    var date = info.event.startStr.split("T")[0]; // Extract only the date
                    calendar.trigger('dateClick', { dateStr: date });
                },
                eventDidMount: function(info) {
                    var eventElement = info.el; // Event DOM element
                    $(info.el).attr('title', info.event.title);
                    $(eventElement).css({
                        'background-color': '#3788D8',
                        'color': 'white',
                        'overflow': 'visible',
                    });
                    /*$(eventElement).css({
                        'background-color': '#3788D8',
                        'color': 'white',
                        'white-space': 'normal', // Allow text to wrap
                        'overflow': 'visible',
                        'text-align': 'center',
                        'padding': '5px' // Add padding for better readability
                    });*/
                }
            });

            calendar.render();
        });
    </script>
@endpush
