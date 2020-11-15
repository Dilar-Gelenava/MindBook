@extends('layouts.app')

@section('content')

        <div class="container" style="text-align: center; width: 350px; background-color: #646464; border-radius: 15px;">

            <h1>{{ $user_name }}</h1>
            <a href="../{{ $profile_picture_url }}">
                <img style="border-radius: 15px; margin-top: 5px;"
                     src="/{{ $profile_picture_url }}" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                     width="300px" alt="{{ $user_data->first_name }}">
            </a>

            <p> {{ $user_data->bio }} </p>
            <a href="/posts/{{ $user_id }}" class="btn btn-info" style="width: 200px;">
                {{ $user_name }}(ი)-ს პოსტები
            </a>

            @if($user_id != auth()->id())
                <form action="{{ route('addContact') }}" method="POST">
                    @csrf
                    <input type="hidden" name="contactId" value="{{ $user_id }}">
                    @if($in_contacts)
                        <button onclick="confirmRemoveContact()" class="btn btn-warning" style="margin: 10px;">
                            კონტაქტებიდან ამოშლა
                        </button>
                    @else
                        <button class="btn btn-success" style="margin: 10px;">
                            კონტაქტებში დამატება
                        </button>
                    @endif
                </form>
            @endif

            @if($user_id != auth()->id())
                <form action="{{ route('follow') }}" method="POST">
                    @csrf
                    <input type="hidden" name="following_id" value="{{ $user_id }}">
                    @if($following)
                        <button class="btn btn-warning">
                            განფოლოვება
                        </button>
                    @else
                        <button class="btn btn-success">
                            დაფოლოვება
                        </button>
                    @endif
                </form>
            @endif
            <button id="showFollowersButton" onclick="showFollowers()" class="btn btn-info">
                მანახე ფოლოვერები
            </button>
            <br>
            <div id="followersList" style="display: none; background-color: #4b4b4b; border-radius: 15px; padding: 10px;">
                <div style="display: inline-block; background-color: #323232; border-radius: 15px; padding: 5px; vertical-align: top">
                    <h4>Follower-ები</h4>
                    @foreach($user_followers as $f)
                        <div style="background-color: #141414; padding: 5px; border-radius: 10px; text-align: center; margin: 5px;">
                            <span>{{ $loop->index + 1 }}</span>
                            <a href="/profile/{{ $f->follower_id }}" target="_blank">
                                {{ $f->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div style="display: inline-block; background-color: #323232; border-radius: 15px; padding: 5px; vertical-align: top">
                    <h4>Following-ები</h4>
                    @foreach($user_follows as $f)
                        <div style="background-color: #141414; padding: 5px; border-radius: 10px; text-align: center; margin: 5px;">
                            <span>{{ $loop->index + 1 }}</span>
                            <a href="/profile/{{ $f->following_id }}" target="_blank">
                                {{ $f->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div style="background-color: #282828; border-radius: 15px; width: 320px;">
                <table class="table">
                    <tr>
                        <th> <p>სახელი</p> </th>
                        <td> <p>{{ $user_data->first_name }}</p> </td>
                    </tr>
                    <tr>
                        <th> <p>გვარი</p> </th>
                        <td> <p>{{ $user_data->last_name }}</p> </td>
                    </tr>
                    <tr>
                        <th> <p>სქესი</p> </th>
                        <td> <p>{{ $user_data->sex }}</p> </td>
                    </tr>
                    <tr>
                        <th> <p>დაბადების დღე</p> </th>
                        <td> <p>{{ $user_data->birthday }}<br>({{ Carbon\Carbon::parse($user_data->birthday)->age }} წლის)</p> </td>
                    </tr>
                    <tr>
                        <th> <p>მისამართი</p> </th>
                        <td> <p>{{ $user_data->address }}</p> </td>
                    </tr>
                    <tr>
                        <th> <p>Follower-ები</p> </th>
                        <td> <p>{{ $user_data->followers }}</p> </td>
                    </tr>
                    <tr>
                        <th> <p>Following-ები</p> </th>
                        <td> <p>{{ $user_data->following }}</p> </td>
                    </tr>
                </table>
            </div>
        </div>

    @if ($user_id == auth()->id())
        <div class="container" style="width: 300px; background-color: #1e1e1e; border-radius: 15px; padding: 10px;">
            <form action="{{ route("storeUserData") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="userId" value="{{ $user_id }}">
                @isset($user_data)
                    <input type="text" class="form-control" placeholder="სახელი" name="firstName" value="{{ $user_data->first_name }}">
                    <br>
                    <input type="text" class="form-control" placeholder="გვარი" name="lastName" value="{{ $user_data->last_name }}">
                    <br>
                    <textarea class="form-control" name="bio" placeholder="ბიოგრაფია">{{ $user_data->bio }}</textarea>
                    <br>
                    <input type="date" class="form-control" placeholder="დაბადების დღე" name="birthday" value="{{ $user_data->birthday }}">
                    <br>
                    <input type="text" class="form-control" placeholder="მისამართი" name="address" value="{{ $user_data->address }}">
                    <br>
                    <input type="radio" id="male" name="gender" value="1" {{ $male }}>
                    <label for="male">მამრობითი</label><br>
                    <input type="radio" id="female" name="gender" value="0" {{ $female }}>
                    <label for="female">მდედრობითი</label><br>
                @else
                    <input type="text" class="form-control" placeholder="სახელი" name="firstName">
                    <br>
                    <input type="text" class="form-control" placeholder="გვარი" name="lastName">
                    <br>
                    <textarea class="form-control" name="bio" placeholder="ბიოგრაფია"></textarea>
                    <br>
                    <input type="date" class="form-control" placeholder="დაბადების დღე" name="birthday">
                    <br>
                    <input type="text" class="form-control" placeholder="მისამართი" name="address">
                    <br>
                    <input type="radio" id="male" name="gender" value="1" {{ $male }}>
                    <label for="male">მამრობითი</label><br>
                    <input type="radio" id="female" name="gender" value="0" {{ $female }}>
                    <label for="female">მდედრობითი</label><br>
                @endisset
                <input type="text" name="userName" class="form-control" placeholder="მომხმარებლის სახელი" value="{{ $user_name }}">
                <br>
                <input  type="file" name="image">
                <br><br>
                <button class="btn btn-primary" style="width: 200px;"> განახლება </button>
            </form>
        </div>
    @endif

    </div>
@endsection

<script>

    let followersAreVisible = false;

    function showFollowers() {
        if (followersAreVisible) {
            document.getElementById('followersList').style.display = 'none';
            document.getElementById('showFollowersButton').innerHTML = 'მანახე ფოლოვერები';
            followersAreVisible = false;
        } else {
            document.getElementById('followersList').style.display = 'inline-block';
            document.getElementById('showFollowersButton').innerHTML = 'დამალე ფოლოვერები';
            followersAreVisible = true;
        }

    }
    function confirmRemoveContact() {
        confirm("კონტაქტებიდან ამოშლით წაიშლება მიმოწერებიც! გავაგრძელო?");
    }

</script>
