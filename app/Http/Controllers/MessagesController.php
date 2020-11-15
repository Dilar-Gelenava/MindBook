<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Messages;
use App\UserData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Collection|View
     */
    public function index()
    {

        $contacts = DB::table('contacts')
            ->orderBy('contacts.last_message_id', 'DESC')
            ->join('users', 'users.id', '=', 'contacts.contact_id')
            ->select('users.*', 'contacts.user_id', 'contacts.contact_id')
            ->where('contacts.user_id', auth()->id())
            ->get();

        foreach ($contacts as $contact) {
            $avatar = UserData::all()
                ->where('user_id', $contact->contact_id)
                ->first();
            if (empty($avatar)) {
                $contact->avatar = '/default-avatar.jpg';
            } else {
                $contact->avatar = $avatar->profile_picture_url;
            }
        }

        return view('messages', [
            'contacts' => $contacts,
        ]);

    }


    public function add_contact(Request $request)
    {
        $contact_id = $request->input('contactId');

        $in_contacts = !empty(Contacts::all()
            ->where('user_id', auth()->id())
            ->where('contact_id', $contact_id)
            ->first());

        if ($in_contacts) {
            Contacts::all()
                ->where('user_id', auth()->id())
                ->where('contact_id', $contact_id)
                ->first()
                ->delete();
            DB::table('messages')
                ->whereIn('sender_id', [auth()->id(), $contact_id])
                ->whereIn('receiver_id', [auth()->id(), $contact_id])
                ->delete();

        } else {
            Contacts::create([
                'user_id' => auth()->id(),
                'contact_id' => $contact_id,
            ]);
        }
        return redirect()->back();
    }


    public function chat(Request $request)
    {
        $contact_id = $request->input('contactId');
        $messages = DB::table('messages')
            ->whereIn('sender_id', [auth()->id(), $contact_id])
            ->whereIn('receiver_id', [auth()->id(), $contact_id])
            ->get();
        if (count($messages) > 10) {
            Messages::where('id', $messages->first()->id)->delete();
        }
        return view('content.chat', [
            'messages' => $messages,
            'contact_id' => $contact_id,
        ]);
    }

    public function send(Request $request)
    {
        $sender_id = auth()->id();
        $receiver_id = $request->input('receiverId');
        $message_text = $request->input('messageText');

        $data = Messages::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message_text,
        ]);
        DB::table('contacts')
            ->whereIn('user_id', [$sender_id, $receiver_id])
            ->whereIn('contact_id', [$sender_id, $receiver_id])
            ->update([
                'last_message_id' => $data->id,
            ]);

        return redirect()->back();
    }
}
