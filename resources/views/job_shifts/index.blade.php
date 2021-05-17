@extends('layouts.app')
@section('title')
    {{ __('messages.job_shifts') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job_shifts') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addJobShiftModal">{{ __('messages.job_shift.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('job_shifts.table')
                </div>
            </div>
        </div>
        @include('job_shifts.templates.templates')
        @include('job_shifts.add_modal')
        @include('job_shifts.edit_modal')
        @include('job_shifts.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let jobShiftUrl = "{{ route('jobShift.index') }}/";
        let jobShiftSaveUrl = "{{ route('jobShift.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/job_shifts/job_shifts.js')}}"></script>
@endpush
