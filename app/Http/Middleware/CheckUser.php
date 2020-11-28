<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $post_id = $request->input("postId");
        $user_id = Posts::where('id', $post_id)
        ->select('user_id')
            ->get()
            ->map(function ($post) {
                return $post->user_id;})[0];
        if (auth()->id() == $user_id or auth()->id() == 1) {
            return $next($request);
        }

        return response('<h1>WTF are you trying to do man?</h1>');

    }
}
