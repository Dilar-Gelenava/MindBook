<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
        }
        body {
            background-color: black;
        }
    </style>
</head>
<body>

@foreach($messages as $message)

    @if($message->sender_id == $contact_id)
    <div style="display: inline-block; margin: 5px;">
        <div style="display: inline-block;">
            <a href="/profile/{{ $contact_id }}" target="_parent">
                <img class="prof" src="/storage/profile_pictures/{{ $contact_id }}.jpg"
                     style="width: 50px; height: 50px; border: solid 2px; border-radius: 50%; object-fit: cover;"
                     onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                     alt="name">
            </a>
        </div>

        <div style="display: inline-block; background-color: #1d2124; border-radius: 15px; width: 200px">
            <p style="color: white; padding: 5px; word-wrap: break-word;">{{ $message->message }}</p>
        </div>
    </div>
    @else
    <div>
        <div style="margin: 5px; padding: 5px; background-color: #005a9f; border-radius: 15px; width: 200px;display: inline-block;
vertical-align: middle;
float: right;">
            <p style="color: white; padding: 5px; word-wrap: break-word;">{{ $message->message }}</p>
        </div>
    </div>
    @endif
@endforeach

<div style="position: fixed; bottom: 0; left: 0; background-color: #1e1e1e; height: 80px; width: 400px; margin-top: 90px">

</div>
<div style="position: fixed; bottom: 0; left: 0;">
    <form action="{{ route('send') }}" method="POST">
        @csrf
        <input type="hidden" name="receiverId" value="{{ $contact_id }}">
        <textarea style="background-color: #1d2124; border-radius: 30px; color: white; padding: 15px" name="messageText" cols="20" rows="1"></textarea>
        <button class="btn btn-primary"> გაგზავნა </button>
    </form>
</div>

<script>
    window.scroll(0, document.documentElement.scrollHeight);
</script>
</body>
</html>





