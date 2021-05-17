@extends('layouts.app')
@section('title')
    {{ __('messages.career_levels') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.career_levels') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addCareerLevelModal">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('career_levels.table')
                </div>
            </div>
        </div>
        @include('career_levels.templates.templates')
        @include('career_levels.add_modal')
        @include('career_levels.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let careerLevelUrl = "{{ route('careerLevel.index') }}/";
        let careerLevelSaveUrl = "{{ route('careerLevel.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/career_levels/career_levels.js')}}"></script>
@endpush
