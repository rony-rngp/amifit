@extends('layouts.backend.app')

@section('title', 'User List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">User List</h5>
                    </div>

                    <form action="{{ url()->current() }}" method="get">
                        <div class="row p-5">
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Email <i class="text-danger">*</i></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required >
                            </div>
                            <div class="mb-4 col-md-4">
                                <div class="mt-6">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Sex</th>
                                <th>Profile Complete</th>
                                <th>Running Plan</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($users as $key => $user)
                                <tr>
                                    <td>{{ $users->firstitem()+$key }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->birthday }}</td>
                                    <td>{{ $user->sex }}</td>
                                    <td>
                                        {{ $user->profile_complete == 1 ? 'Yes' : 'No' }}
                                        @if($user->profile_complete == 0)
                                        <a href="{{ route('admin.users.complete_profile', $user->id) }}" class="d-block">Complete Profile</a>
                                        @endif
                                    </td>
                                    <td>{{ $user->running_plan != null ? @$user->running_plan->plan_info['name'] : '--N/A--' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.users.assign_plan', $user->id) }}"><i class="bx bx-add-to-queue me-1"></i> Assign Plan</a>
                                                <a class="dropdown-item" href="{{ route('admin.users.complete_profile', $user->id) }}"><i class="bx bx-edit me-1"></i> {{ $user->profile_complete == 1 ? 'Update First Profile' : 'Complete Profile' }}</a>
                                                {{--@if($user->running_plan != null)--}}
                                                <a class="dropdown-item" href="{{ route('admin.users.add_new_survey', $user->id) }}"><i class="bx bx-add-to-queue me-1"></i> Add New Survey</a>
                                                {{--@endif--}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
