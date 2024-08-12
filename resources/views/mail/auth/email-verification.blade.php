<x-mail::message>
# Hello {{$user->first_name}} {{$user->last_name}}, you are ok?

Confirm your account creation verifying your email. Click the button below to verify and confirm.

<x-mail::button :url="$verification_link">
Verify and confirm
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
