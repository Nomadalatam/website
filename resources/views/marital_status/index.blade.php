@extends('layouts.app')
@section('title')
    {{ __('messages.marital_statuses') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.marital_statuses') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#"
                   class="btn btn-primary form-btn addMaritalStatusModal">{{ __('messages.marital_status.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('marital_status.table')
                </div>
            </div>
        </div>
        @include('marital_status.templates.templates')
        @include('marital_status.add_modal')
        @include('marital_status.edit_modal')
        @include('marital_status.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let maritalStatusUrl = "{{ route('maritalStatus.index') }}/";
        let maritalStatusSaveUrl = "{{ route('maritalStatus.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/marital_status/marital_status.js')}}"></script>
@endpush
