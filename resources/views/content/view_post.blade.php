@extends('layouts.panels')

@section('middle-panel')
    <div class = 'middle-panel'>
        <div class = 'top-color-story'>
            <div class = 'post-story'>
                <div class = 'post-story-wrapper'>
                    <form action="{{ route("storePost") }}" method="POST" enctype="multipart/form-data" class = 'post-form'>
                        @csrf
                        <textarea type="text" name="description" class='inputpost' placeholder="What's on your mind Dilar?"></textarea>
                        <button>Post Story</button>
                        <input type="file" name="image" id = 'file' class = 'file' accept="image/png, image/jpeg, video/mp4, audio/mp3">
                        <label for='file' class='filelabel'>File</label>
                    </form>
                </div>
            </div>
        </div>
        <!-- STORY START -->
        <iframe src="/iframe/{{ $post->id }}" scrolling="no"
                onload="this.style.height=(this.contentWindow.document.body.scrollHeight)+'px';">
        </iframe>
        <!-- STORY END -->
    </div>
@endsection
