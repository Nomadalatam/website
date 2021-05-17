@extends('layouts.app')
@section('title')
    {{ __('messages.testimonial.testimonials') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.testimonial.testimonials') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addTestimonialModal">{{__('messages.common.add')}}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('testimonial.table')
                </div>
            </div>
        </div>
        @include('testimonial.templates.templates')
        @include('testimonial.add_modal')
        @include('testimonial.edit_modal')
        @include('testimonial.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let testimonialUrl = "{{ route('testimonials.index') }}/";
        let testimonialSaveUrl = "{{ route('testimonials.store') }}";
        let defaultDocumentImageUrl = "{{ asset('assets/img/infyom-logo.png') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/testimonial/testimonial.js')}}"></script>
@endpush
