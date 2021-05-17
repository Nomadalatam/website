@extends('layouts.app')
@section('title')
    {{ __('messages.functional_areas') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.functional_areas') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addFunctionalAreaModal">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('functional_areas.table')
                </div>
            </div>
        </div>
        @include('functional_areas.templates.templates')
        @include('functional_areas.add_modal')
        @include('functional_areas.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let functionalAreaUrl = "{{ route('functionalArea.index') }}/";
        let functionalAreaSaveUrl = "{{ route('functionalArea.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/functional_areas/functional_areas.js')}}"></script>
@endpush
