<!DOCTYPE html>
<html>

<head>
    <title>Reset Your Password</title>
</head>

<body>
    <p>Hello {{ $email }},</p>
    <p>We received a request to reset your password. You can reset your password using the link below:</p>
    <p><a href="{{ $url }}">Reset Password</a></p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thanks,</p>
    <p>Your Application</p>

</body>

</html>