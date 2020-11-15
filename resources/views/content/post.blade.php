<div class="post-box container">
    <div class="post-upper-side-box container">
        <div class="container" style = "display: flex">
            <div class="user-link-box container">

                <a href="/profile/{{ $post->user_id }}">
                    <img src="/storage/profile_pictures/{{ $post->user_id }}.jpg"
                         onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                         alt="{{ $post->user_name }}">
                </a>
                <a href="/profile/{{ $post->user_id }}">
                    {{ $post->user_name }}
                </a>
            </div>
            <div>
                <div class="edit-box container">
                    @if($post->user_id == Auth::user()->id)
                        <a href="{{ route('showPost', ["postId"=>$post->id]) }}" class="btn btn-success">
                            დათვალიერება
                        </a>
                        <button onclick="showPostOptions{{ $post->id }}()" class="btn btn-dark" id="{{ "showPostOptionsButton".$post->id }}">
                            რედაქტირება
                        </button>
                        <div class="edit-options-box container" id="options{{ $post->id }}" style="display: none;">
                            @auth
                                @if($post->user_id == Auth::user()->id)
                                    <form action="{{ route('editPost') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $post->id }}">
                                        <button class="btn btn-warning">
                                            განახლება
                                        </button>
                                    </form>
                                    <form action="{{ route('destroyPost') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="postId" value="{{ $post->id }}">
                                        <button class="btn btn-danger">
                                            წაშლა
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @else
                        <a href="{{ route('showPost', ["postId"=>$post->id]) }}" class="btn btn-success">
                            დათვალიერება
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="post-description-box">
        <p>{{ $post->description }}</p>
    </div>
    <p>{{ \Carbon\Carbon::parse($post->created_at)->diffForhumans() }}</p>

    @if(!empty($post->image_url))
        @if(substr($post->image_url, -3)=='mp4')
            <video width="100%" controls>
                <source src="../{{ $post->image_url }}" type="video/mp4">
            </video>
        @elseif(substr($post->image_url, -3)=='mp3')
            <div style="text-align: center;">
                <audio controls width="100%">
                    <source src="../{{ $post->image_url }}" type="audio/ogg">
                </audio>
            </div>
        @else
            <a href="/{{ $post->image_url }}">
                <img src="../../{{ $post->image_url }}" class="post-image" alt="{{ $post->user_name }}'s Post">
            </a>
        @endif
    @endif


    <div class="container" style="display: inline-block">
        <form action="{{ route('like') }}" style="display: inline-block" method="POST">
            @csrf
            <input type="hidden" name="postId" value="{{ $post->id }}">
            <input type="hidden" name="is_like" value="1">
            @if(!empty($post->user_like) && $post->user_like->is_like == 1)
                <input type="submit" name="like_button" value=" 👍 " class="btn btn-warning">
            @else
                <input type="submit" name="like_button" value=" 👍 " class="btn btn-success">
            @endif
        </form>

        <form action="{{ route('like') }}" style="display: inline-block" method="POST">
            @csrf
            <input type="hidden" name="postId" value="{{ $post->id }}">
            <input type="hidden" name="is_like" value="0">
            @if(!empty($post->user_like) && $post->user_like->is_like == 0)
                <input type="submit" name="dislike_button" value=" 🖕 " class="btn btn-warning">
            @else
                <input type="submit" name="dislike_button" value=" 🖕 " class="btn btn-success">
            @endif

        </form>

        <p style="display: inline-block">მოწონს: {{ $post->likes }} </p>
        <p style="display: inline-block">არ მოწონს: {{ $post->dislikes }} </p>

        @if (count($post->comments)>0)
            <button onclick="showComments{{ $post->id }}()" id="{{ "showCommentsButton".$post->id }}" class="btn btn-info">მაჩვენე კომენტარები</button>
            <p style="display: inline-block">Count: {{ count($post->comments) }}</p>
        @endif
    </div>

    <div style="display: inline-block;">
        <div style="display: inline-block; background-color: #1e1e1e; vertical-align: top; border-radius: 15px; padding: 10px;">
            <h5>მოწონს</h5>
            @foreach($post->liked_users as $liked_user)
                <a href="profile/{{ $liked_user->id }}">{{ $liked_user->name }}</a>
                <br>
            @endforeach
        </div>
        <div style="display: inline-block; background-color: #1e1e1e; vertical-align: top; border-radius: 15px; padding: 10px;">
            <h5>არ მოწონს</h5>
            @foreach($post->disliked_users as $disliked_user)
                <a href="profile/{{ $disliked_user->id }}">{{ $disliked_user->name }}</a>
                <br>
            @endforeach
        </div>
    </div>

    <div class="add-comment-div container">

        <div class="comment-form-box container">
            <form action="{{ route('storeComment') }}" method="POST">
                @csrf
                <input name="postId" type="hidden" value="{{ $post->id }}">
                <textarea name="comment" id="commentInput" class="comment-textarea"></textarea>
                <button class="submit add-comment-button btn btn-dark" > დამატება </button>
            </form>
        </div>
        <div id="{{ $post->id }}" class="comments-box container">
            <h4 style="color: purple"> კომენტარები: </h4>
            @foreach ($post->comments as $comment)
                <div class="comment-box container">
                    <div class="user-link-box">
                        <a href="/profile/{{ $comment->user_id }}">
                            <img src="/storage/profile_pictures/{{ $comment->user_id }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                                 alt="{{ $comment->user_name }}" class="small-avatar">
                        </a>
                        <a href="/profile/{{ $comment->user_id }}" class="user-link"> {{ $comment->user_name }} </a>
                    </div>

                    <div class="container comment-text-box">
                        <p> {{ $comment->comment }}
                            <span style="color: purple;">
                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForhumans() }}
                            </span>
                        </p>
                        @if($comment->user_id == auth()->id())
                            <form action="{{ route('destroyComment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="commentId" value="{{ $comment->id }}">
                                <button class="btn btn-danger"> კომენტარის წაშლა </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>

    @if (count($post->comments)>0)
        let commentsAreVisible{{ $post->id }} = false;
        function showComments{{ $post->id }}() {
            if (commentsAreVisible{{ $post->id }}) {
                document.getElementById("{{ $post->id }}").style.display = "none";
                document.getElementById("{{ "showCommentsButton".$post->id }}").innerHTML = "მაჩვენე კომენტარები";
                commentsAreVisible{{ $post->id }} = false;
            } else {
                document.getElementById("{{ $post->id }}").style.display = "block";
                document.getElementById("{{ "showCommentsButton".$post->id }}").innerHTML = "დამალე კომენტარები";
                commentsAreVisible{{ $post->id }} = true;
            }
        }
    @endif

    @if($post->user_id == Auth::user()->id)
        let postOptionsAreVisible{{ $post->id }} = false;
        function showPostOptions{{ $post->id }}() {
            if (postOptionsAreVisible{{ $post->id }}) {
                document.getElementById("options{{ $post->id }}").style.display = "none";
                document.getElementById("{{ "showPostOptionsButton".$post->id }}").innerHTML = "რედაქტირება";
                postOptionsAreVisible{{ $post->id }} = false;
            } else {
                document.getElementById("options{{ $post->id }}").style.display = "block";
                document.getElementById("{{ "showPostOptionsButton".$post->id }}").innerHTML = "დამალვა";
                postOptionsAreVisible{{ $post->id }} = true;
            }
        }
    @endif

</script>

