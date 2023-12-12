<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateComment(Request $request){
        $token = $request->header('X-CSRF-TOKEN');

        if (empty($token || $token != csrf_token()) ) {
            abort(419, 'Page Expired');
        }

        $comment_id = $request->comment_id;
        $comment = Comment::find(  $comment_id );
        $user_id = $request->user_id;
        $content = $request->new_content;


        if($comment->update(["content" => $content]))
            return response()->json(['success' => "successfully updated comment"], 200);

        return response()->json(['error' => 'failed to update comment', 'request'=>$request], 500);

    }

}
