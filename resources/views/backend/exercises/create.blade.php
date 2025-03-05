@extends('layouts.backend.app')

@section('title', 'Create Custom Exercise')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create Custom Exercise</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.exercises.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Exercise">Exercise Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Exercise" id="Exercise" value="{{ old('Exercise') }}" required >
                                    <span class="text-danger">{{ $errors->has('Exercise') ? $errors->first('Exercise') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Difficulty_Level">Difficulty Level <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Difficulty_Level" id="Difficulty_Level" value="{{ old('Difficulty_Level') }}" required >
                                    <span class="text-danger">{{ $errors->has('Difficulty_Level') ? $errors->first('Difficulty_Level') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Target_Muscle_Group">Target Muscle Group <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Target_Muscle_Group" id="Target_Muscle_Group" value="{{ old('Target_Muscle_Group') }}" required >
                                    <span class="text-danger">{{ $errors->has('Target_Muscle_Group') ? $errors->first('Target_Muscle_Group') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Prime_Mover_Muscle">Prime Mover Muscle <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Prime_Mover_Muscle" id="Prime_Mover_Muscle" value="{{ old('Prime_Mover_Muscle') }}" required >
                                    <span class="text-danger">{{ $errors->has('Prime_Mover_Muscle') ? $errors->first('Prime_Mover_Muscle') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Primary_Equipment">Primary Equipment <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Primary_Equipment" id="Primary_Equipment" value="{{ old('Primary_Equipment') }}" required >
                                    <span class="text-danger">{{ $errors->has('Primary_Equipment') ? $errors->first('Primary_Equipment') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Body_Region">Body Region <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Body_Region" id="Body_Region" value="{{ old('Body_Region') }}" required >
                                    <span class="text-danger">{{ $errors->has('Body_Region') ? $errors->first('Body_Region') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Force_Type">Force Type <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="Force_Type" id="Force_Type" value="{{ old('Force_Type') }}" required >
                                    <span class="text-danger">{{ $errors->has('Force_Type') ? $errors->first('Force_Type') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="Short_YouTube_Demonstration">Short YouTube Demonstration</label>
                                    <input type="url" class="form-control" name="Short_YouTube_Demonstration" id="Short_YouTube_Demonstration" value="{{ old('Short_YouTube_Demonstration') }}" >
                                    <span class="text-danger">{{ $errors->has('Short_YouTube_Demonstration') ? $errors->first('Short_YouTube_Demonstration') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="gif_file">Gif File <i class="text-danger">*</i></label>
                                    <input type="file" class="form-control" accept="image/*" name="gif_file" id="gif_file" >
                                    <span class="text-danger">{{ $errors->has('gif_file') ? $errors->first('gif_file') : '' }}</span>
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

@endpush
