@extends('layouts.app')
@section('title')
    {{ __('messages.salary_currencies') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.salary_currencies') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('salary_currencies.table')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let salaryCurrencyUrl = "{{ route('salaryCurrency.index') }}/";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/salary_currencies/salary_currencies.js')}}"></script>
@endpush
