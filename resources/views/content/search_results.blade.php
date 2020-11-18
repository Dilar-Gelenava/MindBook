@extends('layouts.panels')

@section('middle-panel')

    <div class = 'middle-panel'>

        @if(count($users) == 0)
            <div class = 'post-story'>
                <div class = 'post-story-wrapper'>
                    <p class='inputpost'>
                        0 Results found, try another one...
                    </p>
                </div>
            </div>
        @endif

        @foreach($users as $user)
            <div class='post-story'>
                <div class='post-story-wrapper'>
                    <a class='inputpost' href="/profile/{{ $user->id }}" style="padding: 10px">
                        <img class='post-story-wrapper-image' src="{{ $user->avatar }}"
                             onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                             alt="{{ $user->name }}">
                        {{ $user->name }}
                    </a>
                    <span><h6>{{ $user->age }}</h6></span>
                </div>
            </div>
        @endforeach
    </div>

@endsection
