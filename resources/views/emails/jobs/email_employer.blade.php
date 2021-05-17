@component('mail::message')

    # Hii {{ $job->company->user->full_name }},
    <h2>Someone just applied for job : {{ $job->job_title }}</h2>
    Here is short summary :

    @component('mail::panel')
        @if($job->appliedJobs->keyBy('id')->first()->value('notes') !== null)
            My name is {{ getLoggedInUser()->full_name }}. <br/><br/>
            {!! $job->appliedJobs->first()->notes !!}

        @else
            My name is {{ getLoggedInUser()->full_name }}. <br/><br/>
            I have go through with your job details and thereby i have applied for the same. Please kindly contact me if i found suitable based on your needs.
        @endif
    @endcomponent

    @component('mail::button', ['url' => asset('/candidate-details/'.$candidateUniqueId), 'color' => 'success'])
        View Candidate Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}

@endcomponent
