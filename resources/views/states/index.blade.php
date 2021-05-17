@extends('layouts.app')
@section('title')
    {{ __('messages.state.states') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.state.states') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="col-md-6 mr-4">
                    {{ Form::select('country', $countries, null, ['id' => 'filter_country', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Country']) }}
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-primary form-btn addStateModal">{{ __('messages.common.add') }}
                        <i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('states.table')
                </div>
            </div>
        </div>
        @include('states.templates.templates')
        @include('states.add_modal')
        @include('states.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let stateUrl = "{{ route('states.index') }}";
        let stateSaveUrl = "{{ route('states.store') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/states/states.js')}}"></script>
@endpush
