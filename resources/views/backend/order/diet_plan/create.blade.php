<form id="quickForm" action="{{ route('admin.orders.store_diet_plan', $order_id) }}" class="ajax-submit">
    @csrf

    <div class="mb-4 col-md-12">
        <label class="form-label">Time <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="time" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label">Food <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="food" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="serving_size">Serving Size <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="serving_size" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Tips <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="tips" required >
    </div>

    <button type="submit" class="btn btn-primary ">Submit</button>

</form>
