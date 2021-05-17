@extends('layouts.app')
@section('title')
    {{ __('messages.company_sizes') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.company_sizes') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary form-btn addCompanySizeModal">{{ __('messages.company_size.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('company_sizes.table')
                </div>
            </div>
        </div>
        @include('company_sizes.templates.templates')
        @include('company_sizes.add_modal')
        @include('company_sizes.edit_modal')
    </section>
@endsection
@push('scripts')
    <script>
        let companySizeUrl = "{{ route('companySize.index') }}/";
        let companySizeSaveUrl = "{{ route('companySize.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/company_sizes/company_sizes.js')}}"></script>
@endpush
