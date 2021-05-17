@extends('layouts.app')
@section('title')
    {{ __('messages.ownership_types') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.ownership_types') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addOwnerShipTypeModal">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('ownership_types.table')
                </div>
            </div>
        </div>
        @include('ownership_types.templates.templates')
        @include('ownership_types.add_modal')
        @include('ownership_types.edit_modal')
        @include('ownership_types.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let ownerShipTypeUrl = "{{ route('ownerShipType.index') }}/";
        let ownerShipTypeSaveUrl = "{{ route('ownerShipType.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/ownership_types/ownership_types.js')}}"></script>
@endpush
