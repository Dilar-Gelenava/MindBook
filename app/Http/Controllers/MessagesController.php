<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Messages;
use App\User;
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
            ->get()
            ->toArray();

        foreach ($contacts as $contact) {
            $contact->requested = 0;
        }

        $other_contacts = DB::table('contacts')
            ->orderBy('contacts.last_message_id', 'DESC')
            ->join('users', 'users.id', '=', 'contacts.user_id')
            ->select('users.*', 'contacts.user_id as contact_id', 'contacts.contact_id as user_id')
            ->where('contacts.contact_id', auth()->id())
            ->get()
            ->toArray();

        $message_requests = array();
        foreach ($other_contacts as $other_contact) {
            $not_in_contacts = empty(DB::table('contacts')
                ->where('user_id', auth()->id())
                ->where('contact_id', $other_contact->contact_id)
                ->first());
            if ($not_in_contacts) {
                $other_contact->requested = 1;
                array_push($message_requests, $other_contact);
            }
        }

        $contacts = array_merge($contacts, $message_requests);

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

        return view('messenger.messenger', [
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
        $contact_name = User::where('id', $contact_id)->first()->name;
        $messages = DB::table('messages')
            ->whereIn('sender_id', [auth()->id(), $contact_id])
            ->whereIn('receiver_id', [auth()->id(), $contact_id])
            ->get();
        if (count($messages) > 20) {
            Messages::where('id', $messages->first()->id)->delete();
        }
        return view('messenger.chat', [
            'messages' => $messages,
            'contact_id' => $contact_id,
            'contact_name' => $contact_name,
        ]);
    }

    public function send(Request $request)
    {

        $request->validate([
            'messageText' => 'string|required',
        ]);

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

    public function contact_info($userId) {

        $user_data = UserData::where("user_id", $userId)->first();
        $user_data->user_name = User::where('id', $userId)->first()->name;
        return view('messenger.contact_info', ['user_data' => $user_data]);

    }

}
