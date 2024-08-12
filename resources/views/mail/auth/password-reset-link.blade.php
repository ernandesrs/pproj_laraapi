<x-mail::message>
# Hello {{$user->first_name}} {{$user->last_name}}, you are ok?

Here is your password recovery link. Click the button below to continue.

<x-mail::button :url="$reset_link">
Update password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
