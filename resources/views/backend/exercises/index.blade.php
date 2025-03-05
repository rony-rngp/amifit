@extends('layouts.backend.app')

@section('title', 'Exercise List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center border-bottom" >
                        <h5 class="card-header">Exercise List</h5>
                        <div class="me-5">
                            <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary"> Create Custom Exercise</a>
                        </div>
                    </div>

                    <form action="{{ url()->current() }}" method="get">
                        <div class="row p-5">
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Exercise Name <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required >
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
                                <th>ID</th>
                                <th>Exercise Name</th>
                                <th>Difficulty Level</th>
                                <th>Target Muscle Group</th>
                                <th>Prime Mover Muscle</th>
                                <th>Gif</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($exercises as $key => $exercise)
                                <tr>
                                    <td>{{ $exercise->id }}</td>
                                    <td title="{{ $exercise->Exercise }}">{{ \Illuminate\Support\Str::limit($exercise->Exercise, 30) }}</td>
                                    <td>{{ $exercise->Difficulty_Level }}</td>
                                    <td>{{ $exercise->Target_Muscle_Group }}</td>
                                    <td>{{ $exercise->Prime_Mover_Muscle }}</td>
                                    <td>
                                        @if($exercise->gif_file != '')
                                            <a target="_blank" href="{{ asset('backend/upload/exercise/'.$exercise->gif_file) }}">Show Gif File</a>
                                        @else
                                            N\A
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.exercises.edit', $exercise->id) }}?page={{request()->query('page', 1)}}">Edit</a>

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
                            {{ $exercises->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush
