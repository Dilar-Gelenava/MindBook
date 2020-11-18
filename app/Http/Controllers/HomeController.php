<?php

namespace App\Http\Controllers;

use App\Likes;
use App\Posts;
use App\User;
use App\UserData;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
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

        $panel_data = $this->get_panel_data();

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

            $user_like = Likes::all()
                ->where('post_id', $post->id)
                ->where('user_id', auth()->user()->id)
                ->first();

            $liked_users = DB::table('likes')
                ->where('post_id', $post->id)
                ->where('is_like', '=', 1)
                ->join('users', 'users.id', 'likes.user_id')
                ->select('users.id', 'users.name')
                ->get();

            $disliked_users = DB::table('likes')
                ->where('post_id', $post->id)
                ->where('is_like', '=', 0)
                ->join('users', 'users.id', 'likes.user_id')
                ->select('users.id', 'users.name')
                ->get();

            $post->user_like = $user_like;
            $post->comments = $comments;
            $post->user_name = $user_name[0]->name;
            $post->liked_users = $liked_users;
            $post->disliked_users = $disliked_users;

        }

        return view("content.posts", [
            'posts' => $posts,
            'panel_data' => $panel_data,
        ]);

    }

    public function search(Request $request) {
        return redirect('search/'.$request->input('userName'));
}

    public function show_results($userName) {

        $panel_data = (new HomeController)->get_panel_data();

        $users = DB::table('users')
            ->orderBy('id', 'DESC')
            ->select('id', 'users.name')
            ->where('users.name', 'like', '%'.$userName.'%')
            ->take(10)
            ->get();


        foreach ($users as $user) {
            $user->age = '';
            $user_data = DB::table('user_data')
                ->orderBy('id', 'DESC')
                ->where('user_id', $user->id)
                ->first();
            if (!empty($user_data)) {
                $user->avatar = '/'.$user_data->profile_picture_url;
                if($user_data->birthday != Null) {
                    $user->age = Carbon::parse($user_data->birthday)->age.' years old';
                }
            } else {
                $user->avatar = 'https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg';
            }
        }

        return view('content.search_results', [
            'users' => $users,
            'panel_data' => $panel_data,
        ]);

    }

    public function get_panel_data() {
        $panel_data = UserData::where('user_id', auth()->id())->first();

        if (empty($panel_data)) {
            UserData::create([
                "user_id" => auth()->id(),
            ]);
            $panel_data = UserData::where('user_id', auth()->id())->first();
        }

        $panel_data->members_online = count(DB::table('users')->get());
        $panel_data->user_followers = DB::table('followers')
            ->orderBy('id', 'desc')
            ->join('users', 'users.id', '=', 'followers.follower_id')
            ->where('followers.following_id', auth()->id())
            ->select('users.name', 'users.id')
            ->take(9)
            ->get();
        $panel_data->followers_count = count(DB::table('followers')
            ->where('following_id', auth()->id())
            ->get());
        $panel_data->following_count = count(DB::table('followers')
            ->where('follower_id', auth()->id())
            ->get());

        $panel_data->user_posts_count = Posts::all()->where('user_id', auth()->id())->count();

        $panel_data->posts_count = Posts::all()->count();

        return $panel_data;
    }

}
