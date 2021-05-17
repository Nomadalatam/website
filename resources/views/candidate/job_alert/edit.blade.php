@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.job.job_alert') }}
@endsection
@section('content')
    <section class="section">
        @include('flash::message')
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="text-primary">
                    <i class="far fa-bell text-25px mr-2"></i>
                    <span>{{ __('messages.job.job_alert') }}</span>
                </h3>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => 'candidate.job.alert.update']) }}
                <div class="form-group mb-1">
                    <label class="custom-switch switch-label row">
                        <input type="checkbox" name="job_alert" value="1"
                               class="custom-switch-input" {{ ($candidate->job_alert) ? 'checked' : '' }}>
                        <span class="custom-switch-indicator switch-span"></span>
                        <span class="custom-switch-description font-weight-bold">{{ __('messages.candidate.job_alert_message') }}</span>
                    </label>
                </div>
                <div class="form-group ml-md-5 ml-sm-0 mt-4">
                    <div class="custom-switches-stacked">
                        @foreach($jobTypes as $jobType)
                            <label class="custom-switch switch-label mt-2 row">
                                <input type="checkbox" name="job_types[]" value="{{ $jobType->id }}"
                                       class="custom-switch-input" {{ in_array($jobType->id,$jobAlerts) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator switch-span"></span>
                                <span class="custom-switch-description font-weight-bold">{{ htmlspecialchars_decode($jobType->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <!-- Submit Field -->
                <div class="form-group col-sm-12">
                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary btnSave']) }}
                    {{ Form::reset(__('messages.common.cancel'), ['class' => 'btn btn-secondary hover-text-dark text-dark']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </section>
@endsection
