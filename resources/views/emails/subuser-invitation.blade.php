<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sie sind eingeladen, Smavio beizutreten</title>
</head>
<body>
    <h4>{{$user->first_name}} hat Sie zum Mitmachen eingeladen {{$user->company_name}} bei Smavi.</h4>
    <p>Klicken Sie auf den unten stehenden Link, um beizutreten!</p>
    <a href="{{config('app.frontend_url')}}/sub-user/register?user_id={{$user->id}}&email={{$invitee}}">{{config('app.frontend_url')}}/sub-user/register?user_id={{$user->id}}&email={{$invitee}}</a>
</body>
</html>
