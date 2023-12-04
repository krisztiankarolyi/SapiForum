<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class UserController extends Controller
{
    public function myPosts(Request $request){
        $user = auth()->user();

        return view('user.myPosts');
    }

    public function myPostsFiltered(Request $request)
    {
        $user = auth()->user();

        if ($request->input('filter') !== null) {
            $filter = $request->input('filter');
            $posts = Post::where('user_id', $user->id)
                ->where(function ($query) use ($filter) {
                    $query->where('title', 'like', "%$filter%")
                        ->orWhere('category', 'like', "%$filter%");
                })
                ->get();

            foreach ($posts as $post) {
                $post->comments_count = $post->comments()->count();
            }
            return response()->json(['posts' => $posts]);
        }

        $posts =  $user->posts;
        foreach ($posts as $post) {
            $post->comments_count = $post->comments()->count();
        }
        return response()->json(['posts' => $posts]);
    }


}
