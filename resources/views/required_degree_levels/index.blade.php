@extends('layouts.app')
@section('title')
    {{ __('messages.required_degree_levels') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.required_degree_levels') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#"
                   class="btn btn-primary form-btn addRequiredDegreeLevelTypeModal">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('required_degree_levels.table')
                </div>
            </div>
        </div>
        @include('required_degree_levels.templates.templates')
        @include('required_degree_levels.add_modal')
        @include('required_degree_levels.edit_modal')
        @include('required_degree_levels.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let requiredDegreeLevelUrl = "{{ route('requiredDegreeLevel.index') }}/";
        let requiredDegreeLevelSaveUrl = "{{ route('requiredDegreeLevel.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/required_degree_levels/required_degree_levels.js')}}"></script>
@endpush
