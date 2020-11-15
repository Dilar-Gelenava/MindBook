@extends('layouts.app')

@section('content')

    <div style="text-align: center">

        <div style="display: inline-block; vertical-align: top;">
            @foreach($contacts as $contact)
                <div class="contact-box" style="background-color: #1e1e1e; padding: 15px; border-radius: 15px; width: 150px; border: 2px #c8c8c8 solid;">
                    <form action="{{ route('chat') }}" target="messages">
                        <input type="hidden" name="contactId" value="{{ $contact->contact_id }}">
                        <div onClick="this.parentNode.submit();">
                            <img class="prof" src="/{{ $contact->avatar }}"
                                 style="width: 50px; height: 50px; border: solid 2px; border-radius: 50%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='/default-avatar.jpg'"
                                 alt="{{ $contact->name }}">
                            <span>{{ $contact->name }}</span>
                        </div>
                    </form>
                </div>

            @endforeach
        </div>

        <div style="display: inline-block; vertical-align: top;">
            <iframe name="messages" style="background-color: #000000" width="400px" height="400px"></iframe>
        </div>

    </div>

@endsection
