@extends('layouts.app')
@section('title')
    {{ __('messages.candidate.edit_candidate') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.candidate.edit_candidate') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('candidates.index') }}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                @include('layouts.errors')
                <div class="card-body">
                    {{ Form::model($user, ['route' => ['candidates.update', $candidate->id], 'method' => 'put', 'id' => 'editCandidatesForm']) }}

                    @include('candidates.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let companyStateUrl = "{{ route('states-list') }}";
        let companyCityUrl = "{{ route('cities-list') }}";
        let isEdit = true;
        let phoneNo = "{{ old('region_code').old('phone') }}";
        let countryId = '{{$candidate->user->country_id}}';
        let stateId = '{{$candidate->user->state_id}}';
        let cityId = '{{$candidate->user->city_id}}';
        let utilsScript = "{{asset('assets/js/inttel/js/utils.min.js')}}";
    </script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script>
    <script src="{{mix('assets/js/candidate/create-edit.js')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/inttel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/inttel/js/utils.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
@endpush
