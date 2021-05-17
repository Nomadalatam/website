@component('mail::message')
    # Hii {{ $job->name }},

<h2>Job Title: {{ $job->job_title }} </h2>

@component('mail::panel')
    New job posted with {{ $job->job_title }}, if you are interested then you can apply for this job.
@endcomponent

@component('mail::button', ['url' => asset('/job-details/'.$job->job_id), 'color' => 'success'])
    View Job
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
