@extends('layouts.app')
@section('title')
    {{ __('messages.job_types') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job_types') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addJobTypeModal">{{ __('messages.job_type.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('job_types.table')
                </div>
            </div>
        </div>
        @include('job_types.templates.templates')
        @include('job_types.add_modal')
        @include('job_types.edit_modal')
        @include('job_types.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let jobTypeUrl = "{{ route('jobType.index') }}/";
        let jobTypeSaveUrl = "{{ route('jobType.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/job_types/job_types.js')}}"></script>
@endpush
