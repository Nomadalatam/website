@extends('layouts.app')
@section('title')
    {{ __('messages.job_categories') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job_categories') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="card-header-action ">
                    {{  Form::select('is_featured', $featured, null, ['id' => 'filterFeatured', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Featured Job']) }}
                </div>
                <a href="#"
                   class="btn btn-primary form-btn addJobCategoryModal ml-2">{{ __('messages.job_category.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('job_categories.table')
                </div>
            </div>
        </div>
        @include('job_categories.templates.templates')
        @include('job_categories.add_modal')
        @include('job_categories.edit_modal')
        @include('job_categories.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let jobCategoryUrl = "{{ route('job-categories.index') }}/";
        let jobCategorySaveUrl = "{{ route('job-categories.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/job_categories/job_categories.js')}}"></script>
@endpush
