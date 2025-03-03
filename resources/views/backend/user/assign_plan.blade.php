@extends('layouts.backend.app')

@section('title', 'Assign Plan')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Assign Plan for {{ $user->name }} - ({{ $user->email }})</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url()->current() }}" enctype="multipart/form-data" method="get">
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="title">Plan <i class="text-danger">*</i></label>
                                    <select name="plan_id" id="plan_id" class="form-control" required>
                                        <option value="">Select One</option>
                                        @foreach($plans as $plan)
                                        <option {{ old('plan_id') == $plan->id ? 'selected' : '' }} data-duration="{{ $plan->duration }}" value="{{ $plan->id }}">{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="start_date">Start Date Date <i class="text-danger">*</i></label>
                                    <input min="{{ date('Y-m-d', strtotime(now())) }}" value="{{ old('start_date') }}" type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>

                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary validate">Get Date</button>
                                &nbsp;
                                <a href="{{ url()->current() }}" class="btn btn-danger ">Clear Data</a>
                            </div>
                        </form>


                        @if(!empty($data_range))
                            <br>
                            <br>
                            <form action="{{ route('admin.users.assign_plan_store', $user->id) }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="row">

                                    <input type="hidden" name="plan_id" value="{{ old('plan_id') }}">

                                    @foreach($data_range as $key => $range)
                                    <div class="row">
                                        <div class="mb-4 col-md-4">
                                            <label class="form-label" for="start_date{{$key}}">Start Date Date <i class="text-danger">*</i></label>
                                            <input type="date" name="start_date[]" value="{{ $range['start_date'] }}" id="start_date{{$key}}" class="form-control" required>
                                        </div>
                                        <div class="mb-4 col-md-4">
                                            <label class="form-label" for="end_date{{$key}}">Start Date Date <i class="text-danger">*</i></label>
                                            <input type="date" name="end_data[]" value="{{ $range['end_date'] }}" id="end_date{{$key}}" class="form-control" required>
                                        </div>
                                        <div class="mb-4 col-md-4">
                                            <label class="form-label" for="payment_status">Month {{ $key+1 }} Payment Status <i class="text-danger">*</i></label>
                                            <select name="payment_status[]"  id="payment_status" class="form-control" required>
                                                <option {{ $key == 0 ? 'selected' : '' }} value="Paid">Paid</option>
                                                <option {{ $key != 0 ? 'selected' : '' }} value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary validate">Assign Plan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Trigger the function when the select option changes
        $('#plan_id').change(function() {
            // Get the selected plan's duration
            var duration = $('#plan_id option:selected').data('duration');

            // Clear any existing inputs
            $('#inputsContainer').empty();

            for (var i = 0; i < duration; i++) {
                var inputHTML = `

                <div class="card shadow mb-6">
                    <div class="card-body">
                        <div class="row">
                             <div class="col-md-12 text-center">Month ${i + 1}</div>
                            <div class="mb-4 col-md-4">
                              <label class="form-label" for="month${i + 1}_start_date">Start Date <i class="text-danger">*</i></label>
                              <input  type="date" ${i === 0 ? '' : 'readonly'} name="start_date[]" id="month${i + 1}_start_date" class="form-control" required>
                            </div>

                            <div class="mb-4 col-md-4">
                              <label class="form-label" for="month${i + 1}_end_date">End Date <i class="text-danger">*</i></label>
                              <input type="date" readonly name="end_date[]" id="month${i + 1}_end_date" class="form-control" required>
                            </div>

                            <div class="mb-4 col-md-4">
                              <label class="form-label" for="month${i + 1}_payment_status">Month ${i + 1} Payment Status <i class="text-danger">*</i></label>
                              <select name="payment_status[]"  id="month${i + 1}_payment_status" class="form-control" required>
                                <option value="Paid" ${i === 0 ? 'selected' : ''}>Paid</option>
                                <option ${i !== 0 ? 'selected' : ''} value="Unpaid">Unpaid</option>
                              </select>
                            </div>
                        </div>
                    </div>
                </div>

                `;

              // Append the input fields to the container
              $('#inputsContainer').append(inputHTML);
            }

            $(document).on('change', '#month1_start_date', function() {
                var firstStartDate = $(this).val();  // Get the selected start date of the first month
                if (firstStartDate) {
                    // Convert the first start date to a JavaScript Date object
                    var startDate = new Date(firstStartDate);

                    // Loop through all months and set the start and end dates
                    $('#inputsContainer .mb-4').each(function(index) {
                        var monthIndex = index + 1;  // Start month from 1

                        var currentStartDate = new Date(startDate); // Copy the current start date for each month
                        currentStartDate.setMonth(startDate.getMonth() + index); // Set the next month's start date

                        // Set the start date for each month input
                        $(`#month${monthIndex}_start_date`).val(currentStartDate.toISOString().split('T')[0]);

                        // Calculate the end date (1 month after the start date)
                        var currentEndDate = new Date(currentStartDate);
                        currentEndDate.setMonth(currentStartDate.getMonth() + 1); // End date is 1 month after start date

                        // Fixing the end date to ensure it's the last valid day of the month (if needed)
                        // Adjust the end date to the last day of the next month
                        currentEndDate.setMonth(currentEndDate.getMonth() + 1, 0); // This gives us the last day of the next month

                        // If the selected start date is the 31st, we ensure the end date is the correct last day of the month.
                        if (currentEndDate.getDate() === 1) {
                            // If the end date is the 1st, adjust it to the previous day's date (last day of the previous month)
                            currentEndDate.setDate(0);
                        }

                        // Set the end date for each month input
                        $(`#month${monthIndex}_end_date`).val(currentEndDate.toISOString().split('T')[0]);
                    });
                }
            });

            /*$(document).on('change', '#month1_start_date', function() {
                var firstStartDate = $(this).val();  // Get the selected start date of the first month
                if (firstStartDate) {
                    // Convert the first start date to a JavaScript Date object
                    var startDate = new Date(firstStartDate);

                    // Loop through all months and set the start and end dates
                    $('#inputsContainer .mb-4').each(function(index) {
                        var monthIndex = index + 1;  // Start month from 1

                        var currentStartDate = new Date(startDate); // Copy the current start date for each month
                        currentStartDate.setMonth(startDate.getMonth() + index); // Set the next month's start date

                        // Set the start date for each month input
                        $(`#month${monthIndex}_start_date`).val(currentStartDate.toISOString().split('T')[0]);

                        // Calculate the end date (1 month after the start date)
                        var currentEndDate = new Date(currentStartDate);
                        currentEndDate.setMonth(currentStartDate.getMonth() + 1); // End date is 1 month after start date

                        // Set the end date for each month input
                        $(`#month${monthIndex}_end_date`).val(currentEndDate.toISOString().split('T')[0]);
                    });
                }
            });*/

        });


    });
</script>
@endpush
