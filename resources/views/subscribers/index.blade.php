@extends('layouts.app')
@section('title')
    {{ __('messages.subscribers') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.subscribers') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('subscribers.table')
                </div>
            </div>
        </div>
        @include('subscribers.templates.templates')
    </section>
@endsection
@push('scripts')
    <script>
        let subscriberUrl = "{{ route('subscribers.index') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/subscribers/subscribers.js')}}"></script>
@endpush
