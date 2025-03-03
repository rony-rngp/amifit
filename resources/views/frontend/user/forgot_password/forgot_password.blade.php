@extends('layouts.frontend.app')

@push('css')
    <style>
        .badge {
            display: inline-block;
            padding: 11px 10px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            background-color: green;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 10px;
            width: 100%;
        }

        /* Optional: Add hover effect */
        .badge:hover {
            background-color: #0056b3;
        }
    </style>
@endpush

@section('content')
    <main class="flex-grow">
        <section class="relative bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">Forgot Password</h1>

            </div>
        </section>
        <section id="assessment" class="py-16 bg-gray-800 ">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-2xl font-extrabold text-center text-white mb-12">Enter your email address and we will give you password reset mail</p>

                @if (\Session::has('success'))
                    <div class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        <div>
                            <span class="font-medium">Success!</span> {!! \Session::get('success') !!}
                        </div>
                    </div>
                @endif



                <form action="{{ route('forgot_password') }}" method="post" class="space-y-6 free_assessment_form">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        <span class="d-block" style="color: red">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 text-white font-bold py-3 px-4 rounded-full hover:bg-orange-600 transition duration-300">Submit</button>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('js')

@endpush
