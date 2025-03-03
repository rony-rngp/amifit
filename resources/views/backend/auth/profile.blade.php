@extends('layouts.backend.app')

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
                        <div class="col-md-12 mb-4 mt-10">
                            <a class="text-center img_viewer">
                                <img id="show_img" src="{{ $admin->image != '' && Storage::disk('public')->exists($admin->image) ? asset('storage/'.$admin->image) : asset('backend/no_image.png') }}" alt="">
                                <div class="shadow"><span class="menu-icon tf-icons bx bx-edit" style="height: 17px; width: 17px; margin-top: 3px !important; margin-right: 5px;"></span></div>
                            </a>
                            <input type="file" accept="image/*" class="d-none" id="image" name="image">
                        </div>

                        <div class="col-md-12">
                            <div class="card-body">

                                <form action="{{ route('admin.profile') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <input type="file" accept="image/*" id="adminImage" class="d-none" name="image">

                                    <div class="mb-4">
                                        <label class="form-label" for="name">Name <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="name" id="title" value="{{ $admin->name }}" required >
                                        <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="email">Email <i class="text-danger">*</i></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $admin->email }}" required >
                                        <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="phone">Phone <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $admin->phone }}" required >
                                        <span class="text-danger">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
                                    </div>

                                    <button type="submit" class="btn btn-primary validate">Save</button>

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
