@extends('layouts.backend.app')

@section('title', 'Create New')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header">Create New</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.why-choose.index') }}" class="btn btn-primary"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.why-choose.store') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="title">Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required >
                                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                </div>
                                <div class="mb-4 col-md-12">
                                    <label class="form-label" for="sub_title">Sub Title <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="sub_title" id="sub_title" value="{{ old('sub_title') }}" required >
                                    <span class="text-danger">{{ $errors->has('sub_title') ? $errors->first('sub_title') : '' }}</span>
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