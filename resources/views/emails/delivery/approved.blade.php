@component('mail::message')
# 🎉 Congratulations {{ $user->name }}!

Your request to become a **Delivery Partner** has been approved.

You can now access your delivery dashboard and start earning.

@component('mail::button', ['url' => route('delivery.dashboard')])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
