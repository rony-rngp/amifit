<form id="quickForm" action="{{ route('admin.orders.store_diet_plan', $order_id) }}" class="ajax-submit">
    @csrf

    <div class="mb-4 col-md-12">
        <label class="form-label">Time <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="time" required >
    </div>
    <div class="mb-4 col-md-12 position-relative">
        <label class="form-label">Food <i class="text-danger">*</i> <a target="_blank" href="{{ route('admin.add_food_nutrition') }}">Add Food Nutrition</a></label>
        <input type="text" class="form-control" autocomplete="off" id="food" name="food" required >
        <a href="javascript:void(0)" style="display: none;" id="nutritionDetails" target="_blank">Food Nutrition Details</a>
        <ul id="food-suggestions" class="list-group position-absolute w-100" style="top: 100%; z-index: 10; display: none;background: white;max-height: 500px; overflow-y: auto;"></ul>
    </div>

    <input type="hidden" name="food_id" id="nutritionFoodID">

    <div class="mb-4 col-md-12">
        <label class="form-label" for="serving_size">Serving Size <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="serving_size" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Tips </label>
        <input type="text" class="form-control" name="tips"  >
    </div>

    <button type="submit" class="btn btn-primary ">Submit</button>

</form>

<script>
    $(document).ready(function () {

        let debounceTimer;

        $("#food").keyup(function () {
            const query = $(this).val().toLowerCase();

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(function () {
                if (query.length > 0) {
                    $.ajax({
                        url: '{{ route('admin.search_food') }}',  // Your API URL here
                        method: 'GET',
                        data: { query: query },
                        success: function (response) {
                            const suggestionList = $("#food-suggestions");
                            suggestionList.empty();
                            $('#nutritionDetails').hide();
                            $("#nutritionFoodID").val('');

                            // Assuming response is an array of suggestions
                            response.suggestions.forEach(function (food) {
                                suggestionList.append(`<li class="list-group-item list-group-item-action" data-id="${food.id}">${food.Name}</li>`);
                            });

                            suggestionList.show();
                        }
                    });
                } else {
                    $("#food-suggestions").hide();
                    $('#nutritionDetails').hide();
                    $("#nutritionFoodID").val('');
                }
            }, 500); // Delay of 500ms after the user stops typing
        });

        // If a suggestion is clicked, set it to the input
        $(document).on('click', '#food-suggestions li', function () {
            $("#food").val($(this).text());

            const foodId = $(this).data('id');
            let nutritionUrl;
            if(foodId > 789770){
                nutritionUrl = `/admin/add-food-nutrition/${foodId}`;
            }else{
                nutritionUrl = `/admin/food-details/${foodId}`;
            }
            $('#nutritionDetails').attr('href', nutritionUrl);
            $('#nutritionDetails').show();

            $("#nutritionFoodID").val(foodId);

            $("#food-suggestions").hide();
        });
    });
</script>

