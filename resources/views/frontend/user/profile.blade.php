@extends('layouts.user.app')

@section('title', 'Profile')

@push('css')
    <style>
        .img_viewer {
            height: 120px;
            width: 120px;
            cursor: pointer;
            border-radius: 50%;
            position: relative;
            display: flex;
            margin: auto;
            border: 2px solid #E7EAF3;
            background: #E7EAF3;
        }
        .img_viewer img {
            position: absolute;
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .img_viewer div {
            position: absolute;
            bottom: 0;
            right: 7px;
            background: #FFFFFF;
            padding: 5px;
            border-radius: 50%;
            height: 35px;
            width: 35px;
        }

        .shadow {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">

                    <div class="row">


                        <div class="col-md-12 mt-2">
                            <div class="card-body">

                                <form action="{{ route('user.profile') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label" for="name">Name <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="name" id="title" value="{{ $user->name }}" required >
                                        <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="email">Email <i class="text-danger">*</i></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required >
                                        <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="birthday">Birthday <i class="text-danger">*</i></label>
                                        <input type="date" class="form-control" name="birthday" id="birthday" value="{{ $user->birthday }}" required >
                                        <span class="text-danger">{{ $errors->has('birthday') ? $errors->first('birthday') : '' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="sex">Sex <i class="text-danger">*</i></label>
                                        <select name="sex" id="sex" class="form-control">
                                            <option value="">Select One</option>
                                            <option {{ $user->sex == 'male' ? 'selected' : '' }} value="male">Male</option>
                                            <option {{ $user->sex == 'female' ? 'selected' : '' }} value="female">Female</option>
                                            <option {{ $user->sex == 'other' ? 'selected' : '' }} value="other">Other</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->has('sex') ? $errors->first('sex') : '' }}</span>
                                    </div>


                                    <button type="submit" class="btn btn-primary validate">Update</button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(".img_viewer").on('click', function () {
            $('#adminImage').click();
        });
        $('#adminImage').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#show_img').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
