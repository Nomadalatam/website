@extends('layouts.app')
@section('title')
    {{ __('messages.city.cities') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.city.cities') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="col-md-6 mr-4">
                    {{ Form::select('states', $states, null, ['id' => 'filter_state', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select state']) }}
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-primary form-btn addCityModal">{{ __('messages.common.add') }}
                        <i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('cities.table')
                </div>
            </div>
        </div>
        @include('cities.templates.templates')
        @include('cities.add_modal')
        @include('cities.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let cityUrl = "{{ route('cities.index') }}";
        let citySaveUrl = "{{ route('cities.store') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/cities/cities.js')}}"></script>
@endpush
