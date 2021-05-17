@extends('layouts.app')
@section('title')
    {{ __('messages.branding_sliders') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.branding_sliders') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="card-header-action">
                    {{  Form::select('is_active', $statusArr, null, ['id' => 'branding_filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => __('messages.image_slider.select_status')]) }}
                </div>
                <a href="#"
                   class="btn btn-primary form-btn addBrandingSliderModal ml-2">{{ __('messages.image_slider.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('branding_sliders.table')
                </div>
            </div>
        </div>
        @include('branding_sliders.templates.templates')
        @include('branding_sliders.add_modal')
        @include('branding_sliders.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let brandingSliderUrl = "{{ route('branding.sliders.index') }}";
        let brandingSliderSaveUrl = "{{ route('branding.sliders.store') }}";
        let defaultDocumentImageUrl = "{{ asset('assets/img/infyom-logo.png') }}";
        let view = "{{ __('messages.common.view') }}";
        let brandingExtensionMessage = "{{ __('messages.image_slider.image_extension_message') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/branding_sliders/branding_sliders.js')}}"></script>
@endpush
