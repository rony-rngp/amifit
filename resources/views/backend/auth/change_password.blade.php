@extends('layouts.backend.app')

@section('title', 'Change Password')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">

                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Change Password</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('admin.change_password') }}" method="post" >
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="current_password">Current Password <i class="text-danger">*</i></label>
                                <input type="password" class="form-control" name="current_password" id="current_password" required>
                                <span class="text-danger">{{ $errors->has('current_password') ? $errors->first('current_password') : '' }}</span>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="password">New Password <i class="text-danger">*</i></label>
                                <input type="password" class="form-control" name="password" id="password" required>
                                <span class="text-danger">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="password_confirmation">Confirm Password <i class="text-danger">*</i></label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                <span class="text-danger">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</span>
                            </div>


                            <button type="submit" class="btn btn-primary validate">Update Password</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush