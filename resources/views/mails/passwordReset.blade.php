@component('mail::message')
# Change password Request

Click on the button below to change password

@component('mail::button', ['url' => 'http://10.0.31.10/#/response-password-reset?token='.$token.'&email='.$email])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent