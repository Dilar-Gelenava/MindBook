@extends('main.index')

@section('content')
    <div class = 'page-container'>
        <div class = 'left-panels'>
            <div class = 'left-panel'>
                <div class = 'profile'>
                    <div class='top-color'>
                        <a href="/profile/{{ auth()->id() }}">
                            <img src="/storage/profile_pictures/{{ auth()->id() }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                                 alt="{{ auth()->user()->name }}">
                        </a>
                    </div>
                    <div class = 'profile-info'>
                        <p class = 'profile-name'>{{ auth()->user()->name }}</p>
                        <p class = 'profile-work'>{{ $panel_data->first_name }} {{ $panel_data->last_name }}</p>
                        <div class = 'division'></div>
                        <p class = 'following'>Following</p>
                        <p class = 'following-number'>{{ $panel_data->following_count }}</p>
                        <div class = 'division'></div>
                        <p class = 'followers'>Followers</p>
                        <p class = 'followers-number'>{{ $panel_data->followers_count }}</p>
                        <div class = 'division'></div>
                        <a class = 'view-profile' href="/profile/{{ auth()->id() }}">View Profile</a>
                    </div>
                </div>

                <div class = 'left-panel1'>
                    <div class = 'left-panel1-info'>
                        <p class = 'profile-name'>Members Online</p>
                        <p class = 'following-number'>{{ $panel_data->members_online}}</p>
                        <div class = 'division'></div>
                        <p class = 'following'>Your Posts Count</p>
                        <p class = 'following-number'>{{ $panel_data->user_posts_count }}</p>
                        <div class = 'division'></div>
                        <p class = 'followers'>Posts Count</p>
                        <p class = 'followers-number'>{{ $panel_data->posts_count }}</p>
                        <div class = 'division'></div>
                        <a class = 'view-profile' href="https://btu.edu.ge/ka/chven-shesakheb">Read Q&A</a>
                    </div>
                </div>
            </div>

        </div>

        @yield('middle-panel')

        <div class = 'right-panels'>
            <div class = 'right-panel'>
                <img src="https://www.brandcrowd.com/gallery/brands/pictures/picture15103281443772.png">
                <div class = 'right-panel1-texts'>
                    <div class = 'right-panel-text1'>
                        <p>MindBook</p>
                    </div>

                    <div class = 'right-panel-text2'>
                        <p>Here To Satisfy Crowd</p>
                    </div>

                    <div class = 'right-panel1-color'>

                    </div>

                    <div class = 'right-panel1-text3'>
                        <p> Join Our Team </p>
                    </div>

                    <div class = 'right-panel1-text4'>
                        <a href = 'https://btu.edu.ge/'> Learn More </a>
                    </div>
                </div>
            </div>

            <div class = 'right-panel2'>
                <div class = 'followerss-list'>
                    <div class = 'right-panel-text1'>
                        New Followers
                    </div>
                    <div class = 'right-panel1-color'>
                    </div>
                    @foreach($panel_data->user_followers as $user)
                        <div class = 'follower-info'>
                            <a href="/profile/{{ $user->id }}">
                                <img src="/storage/profile_pictures/{{ $user->id }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                                     alt="{{ $user->name }}">
                            </a>
                            <a href='/profile/{{ $user->id }}'>{{ $user->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

    </div>
@endsection
