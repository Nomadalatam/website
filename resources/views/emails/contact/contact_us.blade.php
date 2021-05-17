@component('mail::message')
    # Hi {{ $inquiry->name }}

    Thanks for contacting us.

    {{ $inquiry->message }}

    @isset($inquiry->phone)
        Apart from the email, you can also contact me on my cell : {{ $inquiry->phone }}
    @endisset

    Thanks & Regards,
    {{ config('app.name') }}
@endcomponent
