@extends('layouts.app')
@section('title')
    {{ __('messages.faq.faq') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.faq.faq') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addFaqModal">{{ __('messages.faq.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('faqs.table')
                </div>
            </div>
        </div>
        @include('faqs.templates.templates')
        @include('faqs.add_modal')
        @include('faqs.edit_modal')
        @include('faqs.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let faqUrl = "{{ route('faqs.index') }}/";
        let faqSaveUrl = "{{ route('faqs.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/faqs/faqs.js')}}"></script>
@endpush
