<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../css/reset.css">
<link rel="stylesheet" type="text/css" href="../css/registration.css">
{{--    <link rel="stylesheet" type="text/css" href="../css/search_style.css">--}}
<link rel="stylesheet" type="text/css" href="../css/index_style.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&family=Roboto&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,300&family=Rajdhani:wght@500&family=Roboto&family=Squada+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Recursive:wght@500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&family=Roboto&family=Squada+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Francois+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class = 'middle-panel'>

<div class = 'story'>
    <div class = 'story-profile'>
        <a href="/profile/{{ $post->user_id }}" target="_parent">
            <img class='post-story-image' src="/storage/profile_pictures/{{ $post->user_id }}.jpg"
                 onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                 alt="{{ $post->user_name }}">
        </a>
        <div class = 'story-profile-texts'>
            <a href="/profile/{{ $post->user_id }}" target="_parent">
                <p class = 'story-profile-name'>{{ $post->user_name }}</p>
            </a>
            <p class = 'timestamp'>{{ \Carbon\Carbon::parse($post->created_at)->diffForhumans() }}</p>

            <div class="dropdown">
                @if($post->user_id == Auth::user()->id)
                    <span>DD</span>
                    <div class="dropdown-content">
                        <form action="{{ route('editPost') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <button>edit</button>
                        </form>
                        <form action="{{ route('destroyPost') }}" method="POST">
                            @csrf
                            <input type="hidden" name="postId" value="{{ $post->id }}">
                            <button>delete</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class = 'story-post-text' style = 'font-size: 25px;'>
        <p>{{ $post->description }}</p>
    </div>
    <div class='story-post-image-wrapper' id="postBox">
        @if(!empty($post->image_url))
            @if(substr($post->image_url, -3)=='mp4')
                <video controls class="story-post-image-wrapper" id="videoBox">
                    <source src="../{{ $post->image_url }}" type="video/mp4">
                </video>
                <script>
                    document.getElementById('videoBox').videoWidth = document.getElementById('postBox').style.width+'px';
                </script>
            @elseif(substr($post->image_url, -3)=='mp3')
                <audio class='story-post-image-wrapper' controls width="100%" id="audioBox">
                    <source src="../{{ $post->image_url }}" type="audio/ogg">
                </audio>
            @else
                <a href="/{{ $post->image_url }}" target="_parent">
                    <img width="100%" src="/{{ $post->image_url }}" alt="{{ $post->user_name }}'s Post" id="imageBox">
                </a>
            @endif

        @else
            <script>
                document.getElementById('postBox').style.height = '0px'
            </script>
        @endif
    </div>
    <div class = 'reactions-list'>
        <div class="dropdown1">
            <span>Likes-{{ $post->likes }}</span>
            <div class="dropdown-content1">
                @foreach($post->liked_users as $liked_user)
                    <a href="/profile/{{ $liked_user->id }}" target="_parent">{{ $liked_user->name }}</a>
                    <br>
                @endforeach
            </div>
        </div>
        <div class="dropdown1">
            <span>Comments-{{ count($post->comments) }}</span>
            <div class="dropdown-content1">
                @foreach ($post->comments as $comment)
                    <a href="/profile/{{ $comment->user_id }}" target="_parent">{{ $comment->user_name }}</a>
                    <br>
                @endforeach
            </div>
        </div>
        <div class="dropdown1">
            <span>Dislikes-{{ $post->dislikes }}</span>
            <div class="dropdown-content1">
                @foreach($post->disliked_users as $disliked_user)
                    <a href="/profile/{{ $disliked_user->id }}" target="_parent">{{ $disliked_user->name }}</a>
                    <br>
                @endforeach
            </div>
        </div>
    </div>



    <div class = 'story-post-interactions'>

        <form action="{{ route('like') }}" style="display: inline-block" method="POST">
            @csrf
            <input type="hidden" name="postId" value="{{ $post->id }}">
            <input type="hidden" name="is_like" value="1">
            <div class = 'interaction1'>
                <button>
                    @if(!empty($post->user_like) && $post->user_like->is_like == 1)
                        <img src="../img/like_button_blue.png">
                    @else
                        <img src="../img/like_button.png">
                    @endif
                    Like
                </button>
            </div>
        </form>

        <div class = 'interaction2'>
            <button onclick="showComments{{ $post->id }}()">
                @if (count($post->comments)>0)
                    <img src="../img/comment_button_blue.png">
                @else
                    <img src="../img/comment_button.png">
                @endif
                Comments
            </button>
        </div>

        <form action="{{ route('like') }}" style="display: inline-block" method="POST">
            @csrf
            <input type="hidden" name="postId" value="{{ $post->id }}">
            <input type="hidden" name="is_like" value="0">
            <div class = 'interaction3'>
                <button>
                    @if(!empty($post->user_like) && $post->user_like->is_like == 0)
                        <img src="../img/like_button_blue.png">
                    @else
                        <img src="../img/like_button.png">
                    @endif
                    Dislike
                </button>
            </div>
        </form>

            <button onclick="share({{ $post->id }})">
                <img src="../img/share_button.png">
            </button>

    </div>
</div>
<div class='comments-list' id="{{ $post->id }}">
    <div class = 'comments'>
@foreach ($post->comments as $comment)
    <!-- COMMENT -->
            <div class = 'comment'>
                <a href="/profile/{{ $comment->user_id }}" target="_parent">
                    <img class='post-story-wrapper-image' src="/storage/profile_pictures/{{ $comment->user_id }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'">
                </a>
                <div class="comment-text">
                    <p class = 'comment-p'><span class = 'comment-author'> <a href="/profile/{{ $comment->user_id }}" target="_parent">{{ $comment->user_name }}</a> </span><span class = 'comment-post-time'> {{ \Carbon\Carbon::parse($comment->created_at)->diffForhumans() }}</span><br>
                        {{ $comment->comment }}
                    </p>
                    @if($comment->user_id == auth()->id())
                        <form action="{{ route('destroyComment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="commentId" value="{{ $comment->id }}">
                            <button>&times;</button>
                        </form>
                    @endif
                </div>
            </div>
        <!-- COMMENT -->
@endforeach
    </div>
</div>

<div class = 'postcomment'>
    <div class = 'post-story-wrapper'>
        <a href="/profile/{{ auth()->id() }}" target="_parent">
            <img class='post-story-wrapper-image' src="/storage/profile_pictures/{{ auth()->id() }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                 alt="{{ auth()->user()->name }}">
        </a>
        <div class = 'post-comment-form'>
            <form action="{{ route('storeComment') }}" method="POST" class='post-comment-form'>
                @csrf
                <input name="postId" type="hidden" value="{{ $post->id }}">
                <textarea name="comment" id="commentInput" class='inputcomment' placeholder="Write a comment..."></textarea>
                <button>ADD</button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    @if (count($post->comments)>0)
        function showComments{{ $post->id }}() {
            document.getElementById("{{ $post->id }}").style.display = "block";
            commentsAreVisible{{ $post->id }} = true;
        }
    @endif

    function share(postId) {
        prompt('copy this link to share:', String(document.location).replace('iframe/', ''));
    }
</script>

