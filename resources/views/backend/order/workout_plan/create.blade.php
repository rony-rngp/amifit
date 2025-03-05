<style>
    .table.dataTable.no-footer{border-color: rgb(228, 230, 232) !important;}
    div#myTable_filter{margin-bottom: 20px !important;}
</style>

<form id="quickForm" action="{{ route('admin.orders.add_workout_plan', $order_id) }}" class="ajax-submit">
    @csrf

    <div class="table-responsive mb-6">
        <table id="myTable" class="table-bordered table mb-2">
            <thead>
            <tr>
                <th>Exercise</th>
                <th>Difficulty Level</th>
                <th>Target Muscle Group</th>
                <th>Prime Mover Muscle</th>
                <th>Primary Equipment</th>
                <th>Body Region</th>
                <th>Force Type</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exercises as $exercise)
                <tr onclick="setData('{{ $exercise->id }}','{{ $exercise->Exercise }}', '{{ $exercise->Short_YouTube_Demonstration }}')" style="cursor: pointer">
                    <td>{{ @$exercise->Exercise }}</td>
                    <td>{{ @$exercise->Difficulty_Level }}</td>
                    <td>{{ @$exercise->Target_Muscle_Group }}</td>
                    <td>{{ @$exercise->Prime_Mover_Muscle }}</td>
                    <td>{{ @$exercise->Primary_Equipment }}</td>
                    <td>{{ @$exercise->Body_Region }}</td>
                    <td>{{ @$exercise->Force_Type }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4 col-md-12">
        <label class="form-label">Day <i class="text-danger">*</i></label>
        <select name="day" required class="form-control">
            <option value="">Select One</option>
            <option value="day_1">Day 1</option>
            <option value="day_2">Day 2</option>
            <option value="day_3">Day 3</option>
            <option value="day_4">Day 4</option>
            <option value="day_5">Day 5</option>
            <option value="day_6">Day 6</option>
            <option value="day_7">Day 7</option>
        </select>
    </div>

    <input type="hidden" name="exercise_id" id="exercise_id">

    <div class="mb-4 col-md-12">
        <label class="form-label">Workout <i class="text-danger">*</i></label>
        <input type="text" readonly class="form-control" name="workout" id="workout" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="weight">Weight </label>
        <input type="number" class="form-control" name="weight" >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="sets">Sets <i class="text-danger">*</i></label>
        <input type="number" class="form-control" name="sets" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Reps <i class="text-danger">*</i></label>
        <input type="number" class="form-control" name="reps" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Rest <i class="text-danger">*</i></label>
        <input type="number" class="form-control" name="rest" required >
    </div>
    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Youtube Link </label>
        <input type="text" class="form-control" name="youtube_link" id="youtube_link">
    </div>

    <div class="mb-4 col-md-12">
        <label class="form-label" for="tips">Suggestion </label>
        <input type="text" class="form-control" name="suggestion" >
    </div>

    <button type="submit" class="btn btn-primary ">Submit</button>

</form>

<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();

    });

    function setData(id, name, youtube) {
        $("#workout").val(name);
        $("#youtube_link").val(youtube);
        $("#exercise_id").val(id);
    }

</script>
