@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="../../css/main.css">

    <style type="text/css">
        table,td,tr,th{
            border:2px solid black;
            padding: 5px;
            border-collapse: collapse;
        }
    </style>

        <div style="width: auto;">

                <table class="table">
                    <tr>
                        <th> <p>First Name</p> </th>
                        <th> <p>Last Name</p> </th>
                        <th> <p>Birthday</p> </th>
                        <th> <p>Address</p> </th>
                        <th> <p>Followers</p> </th>
                        <th> <p>Following</p> </th>
                    </tr>
                    <tr>
                        @isset($user_data)
                            <td> <p>{{ $user_data->first_name }}</p> </td>
                            <td> <p>{{ $user_data->last_name }}</p> </td>
                            <td> <p>{{ $user_data->birthday }}</p> </td>
                            <td> <p>{{ $user_data->address }}</p> </td>
                            <td> <p>{{ $user_data->followers }}</p> </td>
                            <td> <p>{{ $user_data->following }}</p> </td>
                        @else
                            @for($i = 0; $i <= 5; $i++)
                                <td> <p> not assigned </p> </td>
                            @endfor
                        @endisset
                    </tr>
                </table>
            @isset($user_data)
                <div class="container" style="text-align: center; width: 550px; background-color: #1b1e21; border-radius: 15px;">
                    @if(!empty($user_data->profile_picture_url))
                        <img src="../{{ $user_data->profile_picture_url }}" width="400px" alt="{{ $user_data->first_name }}">
                    @endif
                    <p> {{ $user_data->bio }} </p>
                    <a href="/posts/{{ $user_id }}" class="btn btn-info" style="width: 200px;">
                        View {{ $user_name }}'s Posts
                    </a>
                    <br><br>
                </div>
            @endisset
        </div>

    @if ($user_id == auth()->id())
        <br>
        <div class="container" style="width: 300px; background-color: #1b1e21; border-radius: 15px; padding: 10px;">
            <form action="{{ route("storeUserData") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="userId" value="{{ $user_id }}">
                @isset($user_data)
                    <input type="text" class="form-control" placeholder="First Name" name="firstName" value="{{ $user_data->first_name }}">
                    <br>
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName" value="{{ $user_data->last_name }}">
                    <br>
                    <textarea class="form-control" name="bio" placeholder="Bio">{{ $user_data->bio }}</textarea>
                    <br>
                    <input type="date" class="form-control" placeholder="Birthday" name="birthday" value="{{ $user_data->birthday }}">
                    <br>
                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{ $user_data->address }}">
                    <br>
                    <input type="file" name="image" style="width: auto;">
                @else
                    <input type="text" class="form-control" placeholder="First Name" name="firstName">
                    <br>
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName">
                    <br>
                    <textarea class="form-control" name="bio" placeholder="Bio"></textarea>
                    <br>
                    <input type="date" class="form-control" placeholder="Birthday" name="birthday">
                    <br>
                    <input type="text" class="form-control" placeholder="Address" name="address">
                    <br>
                    <input type="file" name="image" style="width: auto;">
                @endisset
                <br><br>
                <button class="btn btn-primary" style="width: 200px;"> Update </button>
            </form>
        </div>
    @endif

    </div>
@endsection
