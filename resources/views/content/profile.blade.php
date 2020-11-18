@extends('main.base')

@section('content')
    <div class = 'page-wrapper'>
        <div class = 'top-page-wrapper'>
            <div class = 'top-page-menu'>
                <div class='image-name'>
                    <img class = 'profile-picture' src="/{{ $profile_picture_url }}"
                         onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                         alt="{{ $user_data->first_name }}">
                    <p>{{ $user_name }}</p>
                </div>
                <div class = 'profile-menu'>
                    <ul>
                        @if($user_id != auth()->id())
                            <li class = 'edit-profile-li'>
                                <form action="{{ route('follow') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="following_id" value="{{ $user_id }}">
                                    @if($following)
                                        <button>
                                            Unfollow
                                        </button>
                                    @else
                                        <button>
                                            Follow
                                        </button>
                                    @endif
                                </form>
                            </li>
                            <li class = 'edit-profile-li'>
                                <form action="{{ route('addContact') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="contactId" value="{{ $user_id }}">
                                    @if($in_contacts)
                                        <button onclick="confirmRemoveContact()">
                                            Rem. Cont.
                                        </button>
                                    @else
                                        <button>
                                            Add. Cont.
                                        </button>
                                    @endif
                                </form>
                            </li>
                        @else
                            <li class = 'edit-profile-li'>
                                <button onclick="showEdit()" id="editButton">
                                    Edit
                                </button>
                            </li>
                        @endif
                        <li class = 'edit-profile-li1'>
                            <button>
                                <a href="/posts/{{ $user_id }}">Posts</a>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class = 'follower-following'>
            <div class = 'firstmodal'>
                <!-- Trigger/Open The Modal -->
                <button id="myBtn" class = 'modalBTN'>Follower ({{ count($user_followers) }})</button>
                <!-- The Modal -->
                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class = 'closes'>Follower List</h2>
                        </div>
                        <div class="modal-body">
                            @foreach($user_followers as $f)
                                <a href="/profile/{{ $f->follower_id }}" target="_blank">
                                    <p><span>{{ $loop->index + 1 }})</span> {{ $f->name }}</p>
                                </a>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <div class = 'secondmodal'>
                <!-- Trigger/Open The Modal -->
                <button id="myBtn1" class = 'modalBTN'>Following ({{ count($user_follows) }})</button>
                <!-- The Modal -->
                <div id="myModal1" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class = 'closes 1'>Following List</h2>
                        </div>
                        <div class="modal-body">
                            @foreach($user_follows as $f)
                                <a href="/profile/{{ $f->following_id }}" target="_blank">
                                    <p><span>{{ $loop->index + 1 }})</span> {{ $f->name }}</p>
                                </a>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- INFORMATION FORMS -->
        <div class = 'bottom-page-wrapper'>
            <div class="testbox">
                @if($user_id == auth()->id())
                    <form action="{{ route("storeUserData") }}" method="POST" enctype="multipart/form-data" id="editForm" style="display: none">
                        @csrf
                        <input type="hidden" name="userId" value="{{ $user_id }}">
                        <h5>Personal Information</h5>
                        <div class="item">
                            <p>Full Name</p>
                            <div class="name-item">
                                <input type="text" name="firstName" placeholder="First Name" value="{{ $user_data->first_name }}"/>
                                <input type="text" name="lastName" placeholder="Last Gelenava" value="{{ $user_data->last_name }}"/>
                            </div>
                        </div>
                        <div class="item">
                            <p>Address</p>
                            <input type="text" name="address" placeholder="Adress" value="{{ $user_data->address }}"/>
                        </div>
                        <div class="item">
                            <p>Birth date</p>
                            <input type="date" name="birthday" placeholder="Birthday" value="{{ $user_data->birthday }}"/>
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="item">
                            <p>Profile Image</p>
                            <input type="file" name="image">
                        </div>
                        <div class="item">
                            <p>User Name</p>
                            <input type="text" name="userName" placeholder="User Name" value="{{ $user_name }}">
                        </div>
                        <div class="item">
                            <p>Gender</p>
                            <div class='radio1' style='display: flex; flex-direction: row;'>
                                მამრობითი
                                <input type="radio" id="male" name="gender" value="1" {{ $male }}>
                                მდედრობითი
                                <input type="radio" id="female" name="gender" value="0" {{ $female }}>
                            </div>
                        </div>

                        <div class="item">
                            <p>Biography</p>
                            <textarea rows="5" name="bio" placeholder="Biography">{{ $user_data->bio }}</textarea>
                        </div>

                        <div class="btn-block">
                            <button type="submit" href="/">Update</button>
                        </div>
                    </form>
                @endif

                <form id="viewForm">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5>Personal Information</h5>
                    <div class="item">
                        <p>Full Name</p>
                        <div class="name-item">
                            <input type="text" name="firstName" placeholder="First Name" value="{{ $user_data->first_name }}" readonly/>
                            <input type="text" name="lastName" placeholder="Last Gelenava" value="{{ $user_data->last_name }}" readonly/>
                        </div>
                    </div>
                    <div class="item">
                        <p>Address</p>
                        <input type="text" name="address" placeholder="Adress" value="{{ $user_data->address }}" readonly/>
                    </div>
                    <div class="item">
                        <p>Birth date</p>
                        <input type="date" name="birthday" placeholder="Birthday" value="{{ $user_data->birthday }}" readonly/>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="item">
                        <p>User Name</p>
                        <input type="text" name="userName" placeholder="User Name" value="{{ $user_name }}" readonly>
                    </div>
                    <div class="item">
                        <p>Gender</p>
                        <div class='radio1' style='display: flex; flex-direction: row;'>
                            მამრობითი
                            <input type="radio" id="male" name="gender" value="1" {{ $male }}>
                            მდედრობითი
                            <input type="radio" id="female" name="gender" value="0" {{ $female }}>
                        </div>
                    </div>
                    <div class="item">
                        <p>Biography</p>
                        <textarea rows="5" placeholder="Biography" readonly>{{ $user_data->bio }}</textarea>
                    </div>
                </form>
            </div>
        </div>
        <!-- INFORMATION FORMS -->

    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("closes")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


    <script>
        // Get the modal
        var windowz = document.getElementById("myModal1")
        var modal1 = document.getElementById("myModal1");

        // Get the button that opens the modal
        var btn1 = document.getElementById("myBtn1");

        // Get the <span> element that closes the modal
        var span1 = document.getElementsByClassName("closes 1")[0];

        // When the user clicks the button, open the modal
        btn1.onclick = function() {
            modal1.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span1.onclick = function() {
            modal1.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        windowz.onclick = function(event) {
            if (event.target == myModal1) {
                modal1.style.display = "none";
            }
        }

        function confirmRemoveContact() {
            confirm("It will delete all messages with this person, continue?");
        }

        function showEdit() {
            document.getElementById('viewForm').style.display = 'none';
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('editForm').style.display = 'block';
            window.scroll(0, document.documentElement.scrollHeight);
        }

    </script>
@endsection
