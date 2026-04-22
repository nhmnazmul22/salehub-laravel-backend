<x-mail::message>
    # Password Reset OTP

    Your OTP code is:

    # {{ $otp }}

    This OTP will expire in 5 minutes.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
