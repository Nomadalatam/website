@extends('layouts.app')
@section('title')
    {{ __('messages.skills') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.skills') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addSkillModal">{{ __('messages.skill.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('skills.table')
                </div>
            </div>
        </div>
        @include('skills.templates.templates')
        @include('skills.add_modal')
        @include('skills.edit_modal')
        @include('skills.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let skillUrl = "{{ route('skills.index') }}/";
        let skillSaveUrl = "{{ route('skills.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/skills/skills.js')}}"></script>
@endpush
