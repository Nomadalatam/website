@component('mail::message')
# Hi {{ $emailJob->friend_name }},

I have send you the below job link in which you can find the relevant details for the same.

Link : <a href="{{ $emailJob->job_url }}" target="_blank">{{ $emailJob->job_url }}</a>

Thanks.

Regards,<br>
{{ config('app.name') }}
@endcomponent
