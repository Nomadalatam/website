@extends('layouts.app')
@section('title')
    {{ __('messages.country.countries') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.country.countries') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addCountryModal">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('countries.table')
                </div>
            </div>
        </div>
        @include('countries.templates.templates')
        @include('countries.add_modal')
        @include('countries.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let countryUrl = "{{ route('countries.index') }}";
        let countrySaveUrl = "{{ route('countries.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/countries/countries.js')}}"></script>
@endpush
