@extends('layouts.app')
@section('title')
    {{ __('messages.candidates') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.candidates') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="row justify-content-center">
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-md-1">
                        <input type="reset" class="btn btn-danger" id="reset-filter" value="Reset">
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-md-1">
                        <a href="javascript:void(0)" class="btn btn-info"
                           id="candidateFilters">{{__('messages.common.filters')}}</a>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4 mt-1 pr-0">

                        <div class="dropdown candidate-index__action d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" id="action_dropdown">{{__('messages.common.action')}}
                            </button>
                            <div class="dropdown-menu candidate-index__menu">
                                <a class="dropdown-item has-icon" href="{{ route('candidates.create') }}"><i
                                            class="fas fa-plus"></i> {{ __('messages.common.add') }}</a>
                                <a class="dropdown-item has-icon" href="{{ route('candidates.export.excel') }}"><i
                                            class="far fa-file"></i>{{__('messages.common.export_excel')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 col-xl-3 col-sm-12 col-12 d-none filters border border-light"
                         id="candidateFiltersForm">
                        <div class="mb-3">
                            {{  Form::select('job_skill', $jobsSkills, null, ['id' => 'jobSkills', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Job Skill']) }}
                        </div>
                        <div class="mb-3">
                            {{  Form::select('is_immediate_available', $immediateAvailable, null, ['id' => 'immediateAvailable', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Immediate Available']) }}
                        </div>
                        <div class="mb-0">
                            {{  Form::select('is_status', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Status']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('flash::message')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('admin-candidate-search')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let candidateUrl = "{{ route('candidates.index') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/candidate/candidate-list.js') }}"></script>
@endpush
