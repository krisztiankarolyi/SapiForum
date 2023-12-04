<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class UserController extends Controller
{
    public function myPosts(){
        $user = auth()->user();
        $posts = $user->posts;

        return view('user.myPosts', compact('posts'));
    }
}
