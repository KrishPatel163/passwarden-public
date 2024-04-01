<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Password</title>
</head>
<body>
    <center>
        <form action="/update-userpass/{{ $password->id }}" method="POST">
            @csrf
            @method('PUT')
            Webiste: <input type="text" name="website" id="website" value="{{$password->website}}" disabled><br>
            Account: <input type="text" name="account_name" id="account_name" value="{{$password->account_name}}"><br>
            Password: <input type="text" name="password" id="password"><br>
            OTP: <input type="text" name="otp" id="otp"><br>
            <button type="submit">Update</button>
        </form>
    </center>
</body>
</html>