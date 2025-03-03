<form id="quickForm" action="{{ route('admin.orders.add_workout_plan', $order_id) }}" class="ajax-submit">
    @csrf

    <div class="mb-4 col-md-12">
        <label class="form-label">Day <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="day" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label">Workout <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="workout" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="sets">Sets <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="sets" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Reps <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="reps" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Rest <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="rest" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Suggestion <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="suggestion" required >
    </div>

    <button type="submit" class="btn btn-primary ">Submit</button>

</form>
