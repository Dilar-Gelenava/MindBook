@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('forms.add_post')
        <div class="container" style="margin-top: 30px; border-radius: 15px; max-width: 600px; color: transparent;">
            @foreach($posts as $post)
                @include('content.post')
            @endforeach
        </div>
    </div>
</div>
@endsection
