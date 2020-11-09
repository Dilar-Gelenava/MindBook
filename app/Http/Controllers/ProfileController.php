<?php

namespace App\Http\Controllers;

use App\Posts;
use App\UserData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $userName
     * @param $userId
     * @return Application|Factory|View|void
     */
    public function index($userId, $userName)
    {

        $user = DB::table('users')->where('id', $userId)->where('name', $userName)->get();
        if (count($user) != 0){
            $user_data = UserData::where('user_id', $userId)->get();
            $posts = Posts::all()->where('user_id', $userId)->sortByDesc('id');
            foreach ($posts as $post) {
                $comments = collect(DB::table('comments')
                    ->where('post_id', '=', $post->id)->get())->sortByDesc('id');
                $post->comments = $comments;
                $post->user_name = $userName;
            }

            if (count($user_data) > 0) {
                return view("profile", [
                    'user_id' => $userId,
                    'posts' => $posts,
                    'user_data' => $user_data[0],
                    'user_image' => '../'.$user_data[0]->profile_picture_url,
                    'user_name' => $user[0]->name
                ]);
            } else {
                return view("profile", [
                    'user_id' => $userId,
                    'posts' => $posts,
                    'user_name' => $user[0]->name
                ]);
            }
        } else {
            return abort(404);
        }

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
     * @return Application|ResponseFactory|RedirectResponse|Response
     */
    public function store_user_data(Request $request)
    {

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $extension = 'jpg';
            $image_name = $request->input('userId').'.'.$extension;
            $image->storeAs('public/profile_pictures', $image_name);
            $image_url = "storage/profile_pictures/".$image_name;
        } else {
            $image_url = 'storage/profile_pictures/blank.png';
        }

        $user_data = UserData::where('user_id', $request->input('userId'))->get();
        if (count($user_data) == 0) {
            UserData::create([
                'user_id'=>$request->input('userId'),
                'first_name'=>$request->input('firstName'),
                'last_name'=>$request->input('lastName'),
                'bio'=>$request->input('bio'),
                'birthday'=>$request->input('birthday'),
                'address'=>$request->input('address'),
                'profile_picture_url'=>$image_url,
            ]);
        } else {
            UserData::where("user_id", $request->input('userId'))
                ->update([
                    'first_name'=>$request->input('firstName'),
                    'last_name'=>$request->input('lastName'),
                    'bio'=>$request->input('bio'),
                    'birthday'=>$request->input('birthday'),
                    'address'=>$request->input('address'),
                ]);
            if ($request->hasFile('image')) {
                UserData::where("user_id", $request->input('userId'))
                    ->update([
                        'profile_picture_url'=>$image_url,
                    ]);
            }
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
