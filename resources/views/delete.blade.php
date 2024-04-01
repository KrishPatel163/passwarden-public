<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Password</title>
</head>
<body>
    <center>
        Webiste name: {{ $password->website }} <br>
        Accoutn name: {{ $password->account_name }} <br>
        <form action="/delete/{{ $password->id }}" method="post">
            @method('DELETE')
            @csrf
            Enter OTP: <input type="text" name="otp" id="otp"><br>
            Enter The Saved Password: <input type="password" name="password" id="password"><br>
            <button type="submit">Delete</button>
        </form>
    </center>
</body>
</html>