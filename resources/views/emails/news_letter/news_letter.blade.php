@component('mail::message')
    # Hello Dear,

    {!! nl2br(e($description)) !!}

    Thanks & Regards,
    {{ config('app.name') }}
@endcomponent
