@extends('layouts.backend.app')

@section('title',  $food_nutrition == null ? 'Add Food Nutrition' : 'Update Food Nutrition')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">{{ $food_nutrition == null ? 'Add' : 'Update' }} Food Nutrition (100G)</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ $food_nutrition == null ? route('admin.add_food_nutrition') : route('admin.add_food_nutrition', $food_nutrition->id) }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Food Name <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $food_nutrition != null ? $food_nutrition['Name'] : old('name') }}" required >
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Carbohydrate (g) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="carbohydrate" id="carbohydrate" value="{{ $food_nutrition != null ? $food_nutrition['Carbohydrate_(g)'] : old('carbohydrate') }}" required >
                                    <span class="text-danger">{{ $errors->has('carbohydrate') ? $errors->first('carbohydrate') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="name">Protein (g) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="protein" id="protein" value="{{ $food_nutrition != null ? $food_nutrition['Protein_(g)'] : old('protein') }}" required >
                                    <span class="text-danger">{{ $errors->has('protein') ? $errors->first('protein') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="fat">Fat (g) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="fat" id="fat" value="{{ $food_nutrition != null ? $food_nutrition['Fat_(g)'] : old('fat') }}" required >
                                    <span class="text-danger">{{ $errors->has('fat') ? $errors->first('fat') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="fat">Fiber (g) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="fiber" id="fiber" value="{{ $food_nutrition != null ? $food_nutrition['Fiber_(g)'] : old('fiber') }}" required >
                                    <span class="text-danger">{{ $errors->has('fiber') ? $errors->first('fiber') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="sugar">Sugars (g) <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="sugar" id="sugar" value="{{ $food_nutrition != null ? $food_nutrition['Sugars_(g)'] : old('sugar') }}" required >
                                    <span class="text-danger">{{ $errors->has('sugar') ? $errors->first('sugar') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="calorie">Calories <i class="text-danger">*</i></label>
                                    <input type="number" step="any" class="form-control" name="calorie" id="calorie" value="{{ $food_nutrition != null ? $food_nutrition['Calories'] : old('calorie') }}" required >
                                    <span class="text-danger">{{ $errors->has('calorie') ? $errors->first('calorie') : '' }}</span>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary validate">{{ $food_nutrition == null ? 'Submit' : 'Update' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')

@endpush
