<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function viewPost(Request $request, $id){
        if(Auth::user())
        {
            $post = Post::find($id);

            return view("user.viewPost", compact('post'));
        }
        return redirect('login');
    }
}
