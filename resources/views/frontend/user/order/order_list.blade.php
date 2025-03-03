@extends('layouts.user.app')

@section('title', 'My Orders')

@push('css')

@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">My Orders</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Plan</th>
                                <th>Duration</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ @$order->plan_info['name'] }}</td>
                                    <td>{{ $order->duration }} Month</td>
                                    <td>
                                        @php($payment_data = checkPayment($order->id, $order->start_date, $order->end_date))
                                        @if($payment_data != null)
                                            <span class="d-block">{{ $payment_data->start_date .' - '.$payment_data->end_date }}</span>
                                            <span class="d-block">{{ $payment_data->payment_status }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->status }}
                                        @if(date('Y-m-d') < $order->start_date)
                                            <span class="d-block text-danger">Plan will start on {{ $order->start_date }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.order_details', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="btn btn-sm btn-success">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3 float-end me-5" >
                            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')

@endpush
