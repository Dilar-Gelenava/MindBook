@extends('main.base')

@section('content')

    <link rel="stylesheet" type="text/css" href="../css/messenger_style.css">
    <link rel="stylesheet" type="text/css" href="../css/messenger_right_panel.css">
    <link rel="stylesheet" type="text/css" href="../css/messenger-left-panel.css">


<div class = 'page-wrapper'>
    <!-- LEFT MENU WRAPPER -->
    <div class = 'left-menu1'>
        <!-- LEFT MENU PAGE WRAPPER -->
        <div class = 'page-wrappers'>
            <!-- LEFT MENU -->
            <div class = 'left-menu'>
                <div class = 'contacts-text'>
                    <div class = 'chats-text-div'>
                        Chats
                    </div>
                    <!-- CONTACT INFO -->
                    <div class = 'contacts-list'>
                        <!-- SINGLE CONTACT -->
                        @foreach($contacts as $contact)
                        <!-- SINGLE CONTACT -->
                            <form id="contact{{ $loop->index+1 }}" action="{{ route('chat') }}" target="messages">
                                <input type="hidden" name="contactId" value="{{ $contact->contact_id }}">
                                <div class='contact-info' onClick="submitForm('contact{{ $loop->index+1 }}', '{{ $contact->contact_id }}')">
                                    <button>
                                        <div class='text'>
                                            <img src="/{{ $contact->avatar }}" onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                                                 alt="{{ $contact->name }}">
                                            {{ $contact->name }}
                                        </div>
                                    </button>
                                </div>
                            </form>
                        <!-- SINGLE CONTACT -->
                        @endforeach
                    </div>
                    <!-- CONTACT INFO -->
                </div>
            </div>
            <!-- LEFT MENU -->
        </div>
        <!-- LEFT MENU PAGE WRAPPER -->
    </div>
    <!-- LEFT MENU WRAPPER -->


    <div class = 'chat-menu'>
        <iframe name="messages" seamless="seamless"></iframe>
    </div>
    <div class = 'right-menu'>
        <iframe name="info" seamless="seamless"></iframe>
    </div>
</div>


    <script>

        function submitForm(formId, contactId) {
            document.getElementById(formId).submit();
            window.open('info/'+contactId, 'info');
        }
    @if(count($contacts) > 0)
        document.getElementById('contact1').submit();
        window.open('info/{{ $contacts[0]->contact_id }}', 'info');
    @endif
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


@endsection
