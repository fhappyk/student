<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$data['title']}}</title>
</head>
<body>

    <p>Your Email is: {{ $data['email'] }} </p>
    <p>Your Password is: {{ $data['password'] }} </p>
    <p>Click here to login     <a href="{{ $data['route'] }}">{{ $data['route'] }}</a>
    </p>
    <br>
    <p>Thank You!</p>

</body>
</html>
