<p>Hello,</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p>Click the link below to reset your password:</p>
<a href="{{ route('password.reset', $token) }}">{{ route('password.reset', $token) }}</a>
<p>If you did not request a password reset, no further action is required.</p>
<p>Regards,<br>{{ config('app.name') }}</p>
