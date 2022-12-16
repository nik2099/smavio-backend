<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Passwort vergessen: Smavio</title>
</head>
<body>
    <h1>Hi {{$first_name}}!</h1>
    <p>Ihr Code zum Zurücksetzen des Passworts lautet: <strong>{{$code}}</strong></p>
    <p>Oder besuchen Sie die URL: <a href="{{config('app.frontend_url')}}/reset-password?email={{$email}}&otp={{$code}}">{{config('app.frontend_url')}}/reset-password?email={{$email}}&otp={{$code}}</a></p>
    <p>Wenn Sie nicht darum gebeten haben, Ihr Passwort bei Smavio zurückzusetzen, ignorieren Sie diese E-Mail.</p>
</body>
</html>
