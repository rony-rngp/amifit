@extends('layouts.backend.app')

@section('title', 'Settings')

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="float-left">Settings</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.settings') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label  class="form-label"  for="website_name">Website Name <span class="text-danger">*</span></label>
                                    <input type="text" name="website_name" required id="website_name" value="{{ get_settings('website_name') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('website_name') ? $errors->first('website_name') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label  class="form-label" for="whatsapp_number">WhatsApp Number (with +88) <span class="text-danger">*</span></label>
                                    <input type="text" name="whatsapp_number" required id="whatsapp_number" value="{{ get_settings('whatsapp_number') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('whatsapp_number') ? $errors->first('whatsapp_number') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="banner_title">Banner Title <span class="text-danger">*</span></label>
                                    <input type="text" name="banner_title" required id="banner_title" value="{{ get_settings('banner_title') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('banner_title') ? $errors->first('banner_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="banner_subtitle">Banner Sub Title <span class="text-danger">*</span></label>
                                    <input type="text" name="banner_subtitle" required id="banner_subtitle" value="{{ get_settings('banner_subtitle') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('banner_subtitle') ? $errors->first('banner_subtitle') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="footer_title">Footer Title <span class="text-danger">*</span></label>
                                    <input type="text" name="footer_title" required id="footer_title" value="{{ get_settings('footer_title') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('footer_title') ? $errors->first('footer_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="facebook_url">Facebook Url <span class="text-danger">*</span></label>
                                    <input type="text" name="facebook_url" required id="facebook_url" autocomplete="off" value="{{ get_settings('facebook_url') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('facebook_url') ? $errors->first('facebook_url') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="instagram_url">Instagram Url <span class="text-danger">*</span></label>
                                    <input type="text" name="instagram_url" required id="instagram_url" autocomplete="off" value="{{ get_settings('instagram_url') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('instagram_url') ? $errors->first('instagram_url') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="form-label" for="twitter_url">Twitter Url <span class="text-danger">*</span></label>
                                    <input type="text" name="twitter_url" required id="twitter_url" autocomplete="off" value="{{ get_settings('twitter_url') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('twitter_url') ? $errors->first('twitter_url') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="copyright_text">Copyright Text <span class="text-danger">*</span></label>
                                    <textarea name="copyright_text" required id="copyright_text" autocomplete="off" class="form-control">{{ get_settings('copyright_text') }}</textarea>
                                    <span class="text-danger">{{ $errors->has('copyright_text') ? $errors->first('copyright_text') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="meta_title">Meta Title </label>
                                    <input type="text" name="meta_title" id="meta_title" autocomplete="off" value="{{ get_settings('meta_title') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('meta_title') ? $errors->first('meta_title') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="meta_keywords">Meta Keywords </label>
                                    <input type="text" name="meta_keywords" id="meta_keywords" autocomplete="off" value="{{ get_settings('meta_keywords') }}" class="form-control">
                                    <span class="text-danger">{{ $errors->has('meta_keywords') ? $errors->first('meta_keywords') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <label  class="form-label"  for="meta_description">Meta Description </label>
                                    <textarea name="meta_description" id="meta_description" autocomplete="off" class="form-control">{{ get_settings('meta_description') }}</textarea>
                                    <span class="text-danger">{{ $errors->has('meta_description') ? $errors->first('meta_description') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label  class="form-label"  for="favicon">Favicon </label>
                                    <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
                                    <span class="text-danger">{{ $errors->has('favicon') ? $errors->first('favicon') : '' }}</span>
                                </div>

                                <div class="mb-4 col-md-6">
                                    @php($favicon =  get_settings('favicon'))
                                    @if($favicon != '')
                                        <img height="32" width="32" style="margin-top: 25px" src="{{ asset('storage/'.$favicon) }}" alt="Favicon not found">
                                    @endif
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary validate">Update Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
@endsection

@push('js')

@endpush
