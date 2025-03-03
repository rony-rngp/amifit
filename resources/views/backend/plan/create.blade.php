@extends('layouts.backend.app')

@section('title', 'Create Plan')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Plan</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.plans.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Plan Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required >
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="duration">Duration (Monthly) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="duration" id="duration" value="{{ old('duration') }}" required >
                                    <span class="text-danger">{{ $errors->has('duration') ? $errors->first('duration') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="price">Price (Monthly) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="price" id="price" value="{{ old('price') }}" required >
                                    <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="discount">Discount (%) <i class="text-danger">*</i></label>
                                    <input type="number" class="form-control" name="discount" id="discount" value="{{ old('discount') ?? 0 }}" required >
                                    <span class="text-danger">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="badge_title">Badge Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="badge_title" id="badge_title" value="{{ old('badge_title') }}" required >
                                    <span class="text-danger">{{ $errors->has('badge_title') ? $errors->first('badge_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="status">Status <i class="text-danger">*</i></label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                </div>


                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-4">
                                            <label class="form-label" for="status">Options <i class="text-danger">*</i></label>
                                            <input type="text"  required name="options[]" class="form-control">
                                            @foreach($errors->get('options.*') ?? [] as $errors)
                                                @foreach($errors as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="newRow1"></div>


                                <div class="col-md-12 mb-4">
                                    <a href="javascript:void(0)" id="addRow1" class="new_btn bg_warning mr-2">Add New Options</a>
                                </div>


                            </div>

                            <button type="submit" class="btn btn-primary validate">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')
<script>
    $("#addRow1").click(function () {
        var html = '';
        html += '<div class="row " id="inputFormRow1">';
        html += '<div class="col-md-6 mb-4">';
        html += '<label class="form-label" for="status">Options <i class="text-danger">*</i></label>';
        html += '<input type="text" required class="form-control c_inp" name="options[]">';
        html += '</div>';
        html += '<div class="col-md-6 form-group">';
        html += '<a href="javascript:void(0)" style="margin-top: 24px;" class="btn btn-sm btn-danger" id="removeRow1"><i class=" bx bx-trash"></i></a>';
        html += '</div>';
        html += '</div>';

        $('#newRow1').append(html);
    });
    // remove row
    $(document).on('click', '#removeRow1', function () {
        $(this).closest('#inputFormRow1').remove();
    });
    // End add remove row
</script>
@endpush