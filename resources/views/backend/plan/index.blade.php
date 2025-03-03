@extends('layouts.backend.app')

@section('title', 'Plan List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Plan List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary"> Create Plan</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Plan Name</th>
                                <th>Options</th>
                                <th>Duration</th>
                                <th>Price (Monthly)</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($plans as $key => $plan)
                                <tr>
                                    <td>{{ $plans->firstitem()+$key }}</td>
                                    <td>
                                        <div>
                                            <span class="d-block mb-1">{{ $plan->name }}</span>
                                            <span class="small d-block">{{ $plan->badge_title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach(json_decode($plan->options, true) as $op_key => $value)
                                            {{ $op_key+1 }}. {{ $value }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $plan->duration }} Month</td>
                                    <td>{{ base_currency().$plan->price }}</td>
                                    <td>{{ $plan->discount }}%</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.plans.edit', $plan->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $plan->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $plan->id }}" action="{{ route('admin.plans.destroy', $plan->id) }}" method="post" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                                <!--End Delete Data-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $plans->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush