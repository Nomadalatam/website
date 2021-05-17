@extends('layouts.app')
@section('title')
    {{ __('messages.jobs') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.jobs') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="row justify-content-end">
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-md-1">
                        <input type="reset" class="btn btn-danger" id="reset-filter" value="Reset">
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-md-1">
                        <a href="javascript:void(0)" class="btn btn-info"
                           id="jobsFilters">{{__('messages.common.filters')}}</a>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-1 pr-0">
                        <a href="{{ route('admin.job.create') }}"
                           class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                            <i class="fas fa-plus"></i></a>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4 col-xl-3 col-sm-12 col-12 d-none jobsFilter border border-light"
                     id="jobsFiltersForm">
                    <div class="mb-1">
                        {{  Form::select('is_featured', $featured, null, ['id' => 'filter_featured', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Featured Job']) }}
                    </div>
                    <div class="mb-1">
                        {{  Form::select('is_suspended', $suspended, null, ['id' => 'filter_suspended', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Suspended Job']) }}
                    </div>
                    <div class="mb-1">
                        {{  Form::select('is_freelancer', $freelancer, null, ['id' => 'filter_freelancer', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Freelancer Job']) }}
                    </div>
                    <div class="mb-0">
                        {!! Form::selectMonth('month', null, ['id' => 'filter_expiry_date', 'class'=>'form-control status-filter w-100','placeholder' => 'Select Job Expiry Month']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body overflow-hidden">
                    @include('jobs.table')
                </div>
            </div>
        </div>
        @include('jobs.templates.templates')
    </section>
@endsection
@push('scripts')
    <script>
        let jobsUrl = "{{ route('admin.jobs.index') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/jobs/job_datatable_admin.js')}}"></script>
@endpush

