<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/messenger_right_panel.css">
</head>
<body>
<div class = 'right-panel-top'>
    <div class='image-cropper'>

        <img src="/storage/profile_pictures/{{ $user_data->user_id }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
             alt="{{ $user_data->name }}">

    </div>
    <a href="/profile/{{ $user_data->user_id }}" target="_parent">
        <p>{{ $user_data->user_name }}</p>
    </a>

</div>
<div class = 'right-panel-middle'>
    <p>{{ $user_data->bio }}</p>

</div>
<div class = 'right-panel-footer'>

    <p>{{ Carbon\Carbon::parse($user_data->birthday)->age.' years old' }}</p>
    <p>First Name: {{ $user_data->first_name }}</p>
    <p>Last Name: {{ $user_data->last_name }}</p>
    <p>From: {{ $user_data->address }}</p>
</div>

</body>
</html>
