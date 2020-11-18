@extends('layouts.panels')

@section('middle-panel')
    <div class = 'middle-panel'>
        <div class = 'top-color-story'>
            <div class = 'post-story'>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class = 'post-story-wrapper'>
                    <form action="{{ route("storePost") }}" method="POST" enctype="multipart/form-data" class = 'post-form'>
                        @csrf
                        <textarea type="text" name="description" class="inputpost" placeholder="What's on your mind Dilar?" @error('description') required @enderror>{{ old('description') }}</textarea>
                        <button>Post Story</button>
                        <input type="file" name="image" id='file' class = 'file' accept="image/png, image/jpeg, video/mp4, audio/mp3">
                        <label for='file' class='filelabel' @error('description') style="background-color: #963232" @enderror>File</label>
                    </form>
                </div>
            </div>
        </div>
        <!-- STORY START -->

    @isset($user_name)

            <h1 style="text-align: center; color: white">
                @if(count($posts) == 0)
                    {{ $user_name }} doesn't have any posts
                @else
                    @if(substr($user_name, -1) == 's' || substr($user_name, -1) == 'S')
                        {{ $user_name }}' posts
                    @else
                        {{ $user_name }}'s posts
                    @endif
                @endif
            </h1>

    @endisset

    @foreach($posts as $post)

        <iframe src="/iframe/{{ $post->id }}" scrolling="no"
                onload="this.style.height=(this.contentWindow.document.body.scrollHeight)+'px';">
        </iframe>

    @endforeach

    <!-- STORY END -->
    </div>
@endsection
<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }
</script>
