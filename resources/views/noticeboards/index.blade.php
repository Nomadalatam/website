@extends('layouts.app')
@section('title')
    {{ __('messages.noticeboards') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.noticeboards') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addNoticeboardModal">{{ __('messages.job_skill.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('noticeboards.table')
                </div>
            </div>
        </div>
        @include('noticeboards.templates.templates')
        @include('noticeboards.add_modal')
        @include('noticeboards.edit_modal')
        @include('noticeboards.show_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let noticeboardUrl = "{{ route('noticeboards.index') }}/";
        let noticeboardSaveUrl = "{{ route('noticeboards.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/noticeboards/noticeboards.js')}}"></script>
@endpush
