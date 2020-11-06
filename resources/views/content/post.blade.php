<div class="post-box container">
    <div class="post-upper-side-box container">
        <div class="user-link-box container">
            <a href="/">
                <img src="https://scontent.ftbs5-1.fna.fbcdn.net/v/t1.0-1/cp0/p50x50/122174109_178370813883145_8887753915068651092_o.jpg?_nc_cat=100&ccb=2&_nc_sid=7206a8&_nc_eui2=AeGzlaDhSvFVIO9KZtubzbm9osEa2p_GR3CiwRran8ZHcJFM8at-bl95foCEZ7zXtO5jynqKHjsLKngQA5b4BXLP&_nc_ohc=WrtwhjjXR24AX9PAyd2&_nc_ht=scontent.ftbs5-1.fna&tp=27&oh=bcc579be82fe0cefd4a22806cf6744b8&oe=5FC8C2B6"
                     alt="{{ $post->user_name }}">
            </a>
            <a href="/"> {{ $post->user_name }} </a>
        </div>
        <div class="edit-box container">
            <button onclick="showPostOptions{{ $post['id'] }}()" class="btn btn-dark" id="{{ "showPostOptionsButton".$post['id'] }}">
                Edit
            </button>
            <div class="edit-options-box container" id="options{{ $post['id'] }}" style="display: none;">
                <button href="" class="btn btn-success">
                    View
                </button>
                @auth
                    @if($post['user_id'] == Auth::user()->id)
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <button class="btn btn-warning">
                                Update
                            </button>
                        </form>
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="destroy" value="{{ $post->id }}">
                            <button class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <br>
    <h3> {{ $post['title'] }}</h3>
    <div class="post-description-box">
        <p>{{ $post['description'] }}</p>
    </div>
    <p>{{ $post["created_at"]->diffForHumans() }}</p>
    <img src="{{ $post['image_url'] }}" class="post-image">
    <div class="add-comment-div container">
        <button class="like-button btn btn-primary"> 👍 </button>
        <button class="like-button btn btn-primary"> 👎 </button>
        <p style="display: inline-block">Likes: {{ $post['likes'] }} </p>
        <p style="display: inline-block">Dislikes: {{ $post['dislikes'] }} </p>

        @if (count($post['comments'])>0)
            <button onclick="showComments{{ $post['id'] }}()" id="{{ "showCommentsButton".$post['id'] }}" class="btn btn-info">show comments</button>
            <p style="display: inline-block">Count: {{ count($post['comments']) }}</p>
        @endif

        <div class="comment-form-box container">
            <form action="{{ route('storeComment') }}" method="POST">
                @csrf
                <input name="postId" type="hidden" value="{{ $post['id'] }}">
                <textarea name="comment" id="commentInput" class="comment-textarea"></textarea>
                <button class="submit add-comment-button btn btn-dark" > Add </button>
            </form>
        </div>
        <div id="{{ $post['id'] }}" class="comments-box container">
            <h4 style="color: purple"> comments: </h4>
            @foreach ($post['comments'] as $comment)
                <div class="comment-box container">
                    <div class="user-link-box">
                        <a href="/">
                            <img src="https://scontent.ftbs5-1.fna.fbcdn.net/v/t1.0-1/cp0/p50x50/122174109_178370813883145_8887753915068651092_o.jpg?_nc_cat=100&ccb=2&_nc_sid=7206a8&_nc_eui2=AeGzlaDhSvFVIO9KZtubzbm9osEa2p_GR3CiwRran8ZHcJFM8at-bl95foCEZ7zXtO5jynqKHjsLKngQA5b4BXLP&_nc_ohc=WrtwhjjXR24AX9PAyd2&_nc_ht=scontent.ftbs5-1.fna&tp=27&oh=bcc579be82fe0cefd4a22806cf6744b8&oe=5FC8C2B6"
                                 alt="Dilar" class="small-avatar">
                        </a>
                        <a href="/" class="user-link"> Dilar </a>
                    </div>
                    <div class="container comment-text-box">
                        <p> {{ $comment->comment }} <span style="color: purple;">{{ $comment->created_at }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
    @if (count($post['comments'])>0)
        let commentsAreVisible{{ $post['id'] }} = false;
        function showComments{{ $post['id'] }}() {
            if (commentsAreVisible{{ $post['id'] }}) {
                document.getElementById("{{ $post['id'] }}").style.display = "none";
                document.getElementById("{{ "showCommentsButton".$post['id'] }}").innerHTML = "Show comments";
                commentsAreVisible{{ $post['id'] }} = false;
            } else {
                document.getElementById("{{ $post['id'] }}").style.display = "block";
                document.getElementById("{{ "showCommentsButton".$post['id'] }}").innerHTML = "Hide comments";
                commentsAreVisible{{ $post['id'] }} = true;
            }
        }
    @endif
    let postOptionsAreVisible{{ $post['id'] }} = false;
    function showPostOptions{{ $post['id'] }}() {
        if (postOptionsAreVisible{{ $post['id'] }}) {
            document.getElementById("options{{ $post['id'] }}").style.display = "none";
            document.getElementById("{{ "showPostOptionsButton".$post['id'] }}").innerHTML = "Edit";
            postOptionsAreVisible{{ $post['id'] }} = false;
        } else {
            document.getElementById("options{{ $post['id'] }}").style.display = "inline-block";
            document.getElementById("{{ "showPostOptionsButton".$post['id'] }}").innerHTML = "Hide Edit";
            postOptionsAreVisible{{ $post['id'] }} = true;
        }
    }
</script>

