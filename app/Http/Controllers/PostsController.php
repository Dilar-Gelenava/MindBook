<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Likes;
use App\Posts;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $userId
     * @return Application|Factory|Response|View
     */
    public function index($userId)
    {
        $panel_data = (new HomeController)->get_panel_data();

        $name = User::where('id', $userId)->firstOrFail()->name;
        $posts = collect(Posts::where('user_id', $userId)->get())->sortByDesc('id');

        foreach ($posts as $post) {
            $comments = collect(DB::table('comments')
                ->where('post_id', '=', $post->id)->get())
                ->sortByDesc('id');
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
            'user_name' => $name,
            'panel_data' => $panel_data,
        ]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store_post(Request $request)
    {

        $request->validate([
            'description' => 'required',
            'image' => 'mimes:jpeg,png,mp4,mp3|max:102400',
        ]);

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $image_name = auth()->user()->id.'-'.time().'.'.$extension;
            $image->storeAs('public/post_images', $image_name);
            $image_url = "storage/post_images/".$image_name;
        } else {
            $image_url = Null;
        }

        Posts::create([
            "description"=>$request->input("description"),
            "user_id"=>auth()->user()->id,
            "image_url"=>$image_url
        ]);
        return redirect('posts/'.auth()->id());
    }

    /**
     * Display the specified resource.
     * @param $postId
     * @return Application|Factory|View|int
     */
    public function show_post($postId)
    {
        $panel_data = (new HomeController)->get_panel_data();
        $post = $this->get_iframe_post($postId);
        return view("content.view_post", [
            'post' => $post,
            'panel_data' => $panel_data
            ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function edit_post(Request $request)
    {
        $post = Posts::where("id", $request->input("id"))->firstOrFail();
        return view("forms.edit_post")
            ->with(['post' => $post]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return array|Application|ResponseFactory|RedirectResponse|Response|string
     */
    public function update_post(Request $request)
    {

        $request->validate([
            'description' => 'required',
            'image' => 'mimes:jpeg,bmp,png,mp4,mp3|max:102400',
        ]);

        $post_id = $request->input('post_id');
        if($request->hasFile('image'))
        {
            $image_url = DB::table('posts')
                ->where('id', '=', $post_id)->select("image_url")->get()
                ->map(function ($post) {
                    return $post->image_url;})[0];
            Storage::delete(str_replace('storage', 'public', $image_url));
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $image_name = auth()->user()->id.'-'.time().'.'.$extension;
            $image->storeAs('public/post_images', $image_name);
            $image_url = "storage/post_images/".$image_name;
            Posts::where("id", $post_id)
                ->update([
                    'image_url'=>$image_url
                ]);
        }
        Posts::where("id", $post_id)
            ->update([
            "description"=>$request->input("description"),
        ]);
        return redirect('/iframe/'.$post_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return string
     */
    public function destroy_post(Request $request)
    {
        $post_id = $request->input("postId");
        $image_url = DB::table('posts')
            ->where('id', '=', $post_id)->select("image_url")->get()
            ->map(function ($post) {
                return $post->image_url;})[0];
        Storage::delete(str_replace('storage', 'public', $image_url));
        Posts::where("id", $post_id)->delete();
        Comments::where("post_id", $post_id)->delete();
        Likes::where('post_id', $post_id)->delete();

        return view('content.deleted_post', ['post_id' => $post_id]);
    }


    public function iframe_post($postId) {
        $post = $this->get_iframe_post($postId);
        return view("content.post",
            ['post' => $post]
        );
    }

    public function get_iframe_post($postId) {
        $post = Posts::where("id",$postId)->firstOrFail();

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

        return $post;
    }

}
