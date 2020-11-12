<?php

namespace App\Http\Controllers;

use App\Followers;
use App\Likes;
use App\User;
use App\UserData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Posts;
use App\Comments;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {

        $posts = DB::table('posts')
            ->orderBy('id', 'DESC')
            ->join('followers', 'posts.user_id', '=', 'followers.following_id')
            ->select('posts.*', 'follower_id')
            ->where('follower_id', auth()->id())
            ->take(10)
            ->get();

        foreach (collect($posts) as $post) {
            $comments = collect(DB::table('comments')
                ->where('post_id', '=', $post->id)->get())->sortByDesc('id');
            $user_name = DB::table('users')
                ->where('id', '=', $post->user_id)
                ->select('name')
                ->get();

            foreach ($comments as $comment) {
                $user = User::where('id', $comment->user_id)->get()[0];
                $comment->user_name = $user->name;
                $comment->user_id = $user->id;
            }

            $liked_users = Likes::all()->where('post_id', $post->id)->where('user_id', auth()->user()->id)->first();
            $post->liked_users = $liked_users;
            $post->comments = $comments;
            $post->user_name = $user_name[0]->name;

        }

        return view("home", [
            'posts' => $posts,
        ]);

    }

    public function search(Request $request) {
    return redirect('search/'.$request->input('userName'));
}

    public function show_results($userName) {

        $users = DB::table('users')
            ->orderBy('id', 'DESC')
            ->select('id', 'users.name')
            ->where('users.name','like','%'.$userName.'%')
            ->take(10)
            ->get();


        foreach ($users as $user) {
            $user_avatar = DB::table('user_data')
                ->orderBy('id', 'DESC')
                ->select('profile_picture_url')
                ->where('user_id', $user->id)
                ->first();
            if (!empty($user_avatar)) {
                $user->avatar = '/'.$user_avatar->profile_picture_url;
            } else {
                $user->avatar = 'https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg';
            }
        }

        return view('search_results', [
            'users' => $users,
        ]);

    }

}
