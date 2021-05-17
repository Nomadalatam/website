@extends('layouts.app')
@section('title')
    {{ __('messages.employers') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.company.employers') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="row justify-content-end">
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12">
                        <div class="card-header-action">
                            {{  Form::select('is_featured', $featured, null, ['id' => 'filter_featured', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Featured Company']) }}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 mt-3 mt-md-0 ml-4">
                        <div class="card-header-action w-100">
                            {{  Form::select('is_stauts', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Status']) }}
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3 col-sm-12 mt-md-1 pr-0 jobAddBtn">
                        <a href="{{ route('company.create') }}"
                           class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                            <i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body overflow-hidden">
                    @livewire('employers-search')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let companiesUrl = "{{ route('company.index') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{mix('assets/js/companies/companies.js')}}"></script>
@endpush

