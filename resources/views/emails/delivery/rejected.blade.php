@component('mail::message')
# ⚠️ Hello {{ $user->name }}

Your request to become a Delivery Partner was **rejected**.

You can submit a new request anytime.

@component('mail::button', ['url' => route('delivery.apply')])
Apply Again
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
