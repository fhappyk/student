<!DOCTYPE html>
<html>
<head>
    <title>Registration Information</title>
</head>
<body>
<pre>
    @php
        print_r($data);
    @endphp
</pre>
{{--    <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>--}}
{{--    <p>Welcome! Your account has been created with the following details:</p>--}}
{{--    <p>Email: {{ $user->email }}</p>--}}
{{--    <p>Please reset your password to move forward: <a href="{{ $resetUrl }}">Reset Password</a></p>--}}
{{--    <p>Thank you for joining us!</p>--}}
    <p>Email: {{ $data['resetUrl'] }}</p>
</body>
</html>
