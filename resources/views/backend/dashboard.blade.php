@extends('layouts.backend.app')

@section('title', 'Admin Dashboard')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-8 mb-6 order-0">
                <div class="card">
                    <div class="d-flex align-items-start row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Congratulations {{ auth('admin')->user()->name }}! 🎉</h5>
                                <p class="mb-6">
                                    You have done 72% more sales today.
                                    <br />Check your new badge in your profile.
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-6">
                                <img src="{{ asset('backend/assets') }}/img/illustrations/man-with-laptop.png" height="175" class="scaleX-n1-rtl" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-10">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('backend/assets') }}/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="{{ route('admin.orders') }}">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-1">Total Orders</p>
                                <h4 class="card-title">{{ \App\Models\Order::count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-10">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('backend/assets') }}/img/icons/unicons/wallet-info.png" alt="chart success" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-1">Total Users</p>
                                <h4 class="card-title">{{ \App\Models\User::count() }}</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')
    <!-- Vendors JS -->
    <script src="{{ asset('backend/assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Page JS -->
    <script src="{{ asset('backend/assets') }}/js/dashboards-analytics.js"></script>
@endpush
