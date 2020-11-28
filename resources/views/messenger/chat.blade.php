<!DOCTYPE html>
<html>
<head>

{{--    <meta http-equiv="refresh" content="10">--}}

    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/messenger_chat_style.css">
</head>
<body>
<div class = 'chat-menu'>
<div class="top-text-div-wrapper">
    <div class = 'top-text-div'>
        <div class = 'contact-info'>
            <div class = 'text'>
                <a href="/profile/{{ $contact_id }}" target="_parent">
                    <img src="/storage/profile_pictures/{{ $contact_id }}.jpg"
                         onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                         alt="{{ $contact_name }}">
                </a>
                <span style="margin-left: 10px">{{ $contact_name }}</span>

                <form method="link" action="javascript:document.location.reload()">
                    <button class="file">
                        🔄
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


    @foreach($messages as $message)
        @if($message->sender_id == $contact_id)
            <div class='chatting-stranger'>
                <div class = 'chatting-stranger-texts'>
                    <p title="{{ $message->created_at }}">{{ $message->message }}</p>
                </div>
            </div>
        @else
            <div class = 'chatting-my'>
                <div class='chatting-my-texts'>
                    <p title="{{ $message->created_at }}">{{ $message->message }}</p>
                </div>
            </div>
        @endif
    @endforeach


        <div class='chat-input-footer-wrapper'>
            <div class='chat-input-footer'>
                <div class='footer-items'>
                    <button class='file' onclick="emoji('😃')">
                        😃️
                    </button>
                    <button class='file' onclick="emoji('😢')">
                        😢
                    </button>
                    <button class='file' onclick="emoji('😂')">
                        😂
                    </button>
                    <button class='file' onclick="emoji('😮️')">
                        😮️
                    </button>
                    <button class='file' onclick="emoji('❤️')">
                        ❤️
                    </button>

                    <form id="chatForm" action="{{ route('send') }}" method="POST" class='footer-items'>
                        @csrf
                        <input type="hidden" name="receiverId" value="{{ $contact_id }}">
                        <textarea id="chatTextarea" name="messageText" placeholder="Text something..." required></textarea>
                        <button class = 'send-message'>
                            ➤
                        </button>
                    </form>

                    <form id="xForm" style="display: none" action="{{ route('send') }}" method="POST" class='footer-items'>
                        @csrf
                        <input type="hidden" name="receiverId" value="{{ $contact_id }}">
                        <textarea id="xChat" name="messageText"></textarea>
                    </form>
                    <button class='file' onclick="like()">
                        <img src="/img/like_button_blue.png" alt="like">
                    </button>

                </div>
            </div>
        </div>


    </div>
    <script>
        @if(count($messages) > 5)
            window.scroll(0, document.documentElement.scrollHeight);
        @endif


        function like() {
            document.getElementById('xChat').innerHTML = '👍';
            document.getElementById('xForm').submit();
        }
        function emoji(emoji) {
            document.getElementById('chatTextarea').innerHTML += emoji;
        }

    </script>

    <style type="text/css">
        html{
            scrollbar-color: #242526 #242526;
            scrollbar-width: thin;
        }
    </style>

</body>
</html>
`
