<form id="quickForm" action="{{ route('admin.orders.add_calender_event', \Illuminate\Support\Facades\Crypt::encrypt($order_id)) }}" class="ajax-submit">
    @csrf

    <div class="mb-4 col-md-12">
        <label class="form-label" for="date"> <i class="text-danger">*</i> Date (Format: Month-Date-Year )</label>
        <input type="date" class="form-control" name="date" id="date" {{ $event_calender != null ? 'readonly' : '' }} required value="{{ $event_calender != null ? $event_calender->date : $pass_date }}" >
    </div>

    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="missed_diet" {{ $event_calender != null && $event_calender->missed_diet == 1 ? 'checked' : '' }} value="1" id="missed_diet" >
        <label class="form-check-label" for="missed_diet"> I Missed Diet </label>
    </div>


    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="missed_workout" {{ $event_calender != null && $event_calender->missed_workout == 1 ? 'checked' : '' }} value="1" id="missed_workout" >
        <label class="form-check-label" for="missed_workout"> I Missed Workout </label>
    </div>

    <div class="mb-4 col-md-12">
        <label class="form-label" for="comment">Comment <i class="text-danger">*</i></label>
        <textarea name="comment" id="comment" class="form-control" rows="3">{{ $event_calender != null ? $event_calender->comment : '' }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary ">{{ $event_calender != null ? 'Update' : 'Submit' }}</button>
    @if($event_calender != null)
    <a href="{{ route('admin.destroy_event', $event_calender->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
    @endif

</form>
