@extends('layouts.app')
@section('title')
    {{ __('messages.candidate.reported_candidates') }}
@endsection
@push('css')
    @livewireStyles
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.candidate.reported_candidates') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="row justify-content-end">
                    <div class="mt-3 mt-md-0 ml-4">
                        <div class="card-header-action w-100">
                            {!! Form::selectMonth('month', null, ['id' => 'filter_by_reported_date', 'class'=>'form-control w-100','placeholder' => 'Select Month']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('reported-candidate')
                </div>
            </div>
        </div>
        @include('candidate.reported_candidate.show_reported_candidate_modal')
    </section>
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let reportedCandidatesUrl = "{{ route('reported.candidates') }}";
    </script>
    <script src="{{mix('assets/js/candidate/reported_candidates.js')}}"></script>
@endpush

