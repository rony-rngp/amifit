@extends('layouts.backend.app')

@section('title', 'Food nutrition details')

@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="d-flex justify-content-between align-items-center ">
                        <h5 class="card-header">{{ $food_nutrition->Name }} </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            @foreach($columns as $column)
                                @if(@$food_nutrition[$column] != '' && @$food_nutrition[$column] != 0)
                                <tr>
                                    <td>{{ str_replace('_', ' ', $column) }}</td>
                                    <td>{{ @$food_nutrition[$column] }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('js')

@endpush
