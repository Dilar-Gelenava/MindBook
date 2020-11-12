@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: center; width: 450px; background-color: #323232; border-radius: 15px; padding: 15px;">
        <h1>{{ count($users) }} Result found:</h1>
        @foreach($users as $user)
            <div class="user-link-box" style="background-color: #1e1e1e; padding: 15px; border-radius: 15px;">
                <a href="/profile/{{ $user->id }}">
                    <img class="prof" src="{{ $user->avatar }}"
                         onerror="this.onerror=null; this.src='https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg'"
                         alt="{{ $user->name }}">
                    <span>{{ $user->name }}</span>
                </a>
            </div>
        @endforeach
    </div>


@endsection
