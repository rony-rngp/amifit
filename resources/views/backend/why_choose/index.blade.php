@extends('layouts.backend.app')

@section('title', 'Why Choose Amifit List')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center" >
                        <h5 class="card-header">Why Choose Amifit List</h5>
                        @if(\App\Models\WhyChoose::count() < 3)
                        <div class="me-5">
                            <a href="{{ route('admin.why-choose.create') }}" class="btn btn-primary"> Create New</a>
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($why_chooses as $key => $why_choose)
                                <tr>
                                    <td>{{ $why_chooses->firstitem()+$key }}</td>
                                    <td>{{ $why_choose->title }}</td>
                                    <td>{{ $why_choose->sub_title }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.why-choose.edit', $why_choose->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                <button class="dropdown-item" id="delete" type="button" onclick="deleteData({{ $why_choose->id }})">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $why_choose->id }}" action="{{ route('admin.why-choose.destroy', $why_choose->id) }}" method="post" class="d-none">
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
                                    <td colspan="4" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 float-end me-5" >
                            {{ $why_chooses->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')

@endpush