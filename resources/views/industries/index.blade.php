@extends('layouts.app')
@section('title')
    {{ __('messages.industries') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.industries') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addIndustryModal">{{ __('messages.industry.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('industries.table')
                </div>
            </div>
        </div>
        @include('industries.templates.templates')
        @include('industries.add_modal')
        @include('industries.edit_modal')
        @include('industries.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let industryUrl = "{{ route('industry.index') }}/";
        let industrySaveUrl = "{{ route('industry.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/industries/industries.js')}}"></script>
@endpush
