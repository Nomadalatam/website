@extends('layouts.app')
@section('title')
    {{ __('messages.job.edit_job') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job.edit_job') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('admin.jobs.index') }}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                @include('layouts.errors')
                <div class="card-body">
                    {{ Form::model($job, ['route' => ['admin.job.update', $job->id], 'method' => 'put', 'id' => 'editJobForm']) }}

                    @include('jobs.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let jobStateUrl = "{{ route('states-list') }}";
        let jobCityUrl = "{{ route('cities-list') }}";
    </script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{mix('assets/js/jobs/create-edit.js')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>
@endpush
