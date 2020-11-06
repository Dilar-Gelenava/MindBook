<?php

namespace App\Http\Controllers;

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
//     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $posts = Posts::all()->sortByDesc('id');
//        return view("home", [
//            'posts' => $posts,
//        ]);
//        $posts = DB::table('posts')->get();



        $posts = Posts::all()->sortByDesc('id');
        foreach ($posts as $post) {
            $comments = DB::table('comments')
                ->where('post_id', '=', $post->id)->get();
            $user_name = DB::table('users')
                ->where('id', '=', $post->user_id)
                ->select('name')
                ->get();
            $post->comments = $comments;
            $post->user_name = $user_name[0]->name;

        }
        return view("home", [
            'posts' => $posts,
        ]);

//        return (array)$user_name[0]->name;
//        return $posts;

    }
}
