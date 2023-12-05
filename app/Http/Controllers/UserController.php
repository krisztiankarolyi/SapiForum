<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // UserController.php
    public function myPosts(Request $request){
        $user = auth()->user();
        $query = $user->posts();

        // Limitálás
        $limit = $request->query('limit');
        $query->when($limit, function ($query, $limit) {
            return $query->limit($limit);
        }, function ($query) {
            // Ha nincs limit megadva, akkor alapértelmezett érték: 10
            return $query->limit(10);
        });

        // Rendezés
        $orderBy = $request->query('orderby', 'created_at');
        $direction = $request->query('direction', 'desc'); // Alapértelmezett: csökkenő sorrend
        $query->orderBy($orderBy, $direction);

        // Title szűrő
        $title = $request->query('title', '');
        if ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }
        $category = $request->query('category', '');
        if ($category) {
            $query->where('category', 'LIKE', '%' . $category . '%');
        }

        $posts = $query->get();

        foreach ($posts as $post) {
            $post->comments_count = $post->comments()->count();
        }

        return view('user.myPosts', compact('posts'));
    }

    public function posts(Request $request){
        $query = Post::query();

        // Limitálás
        $limit = $request->query('limit');
        $query->when($limit, function ($query, $limit) {
            return $query->limit($limit);
        }, function ($query) {
            // Ha nincs limit megadva, akkor alapértelmezett érték: 10
            return $query->limit(10);
        });

        // Rendezés
        $orderBy = $request->query('orderby', 'created_at');
        $direction = $request->query('direction', 'desc'); // Alapértelmezett: csökkenő sorrend
        $query->orderBy($orderBy, $direction);

        // Title szűrő
        $title = $request->query('title', '');
        if ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        $category = $request->query('category', '');
        if ($category) {
            $query->where('category', 'LIKE', '%' . $category . '%');
        }
        $author = $request->query('author', '');
        if ($author) {
            $authorID =  User::where('name', $author)->first()->id;
            $query->where('user_id', '=', '%' . $authorID . '%');
        }

        $posts = $query->get();
        foreach ($posts as $post) {
            $post->comments_count = $post->comments()->count();
        }

        return view('Posts', compact('posts'));
    }

    public function createPost(){
        return view('user.createPost');
    }

    public function storePost(Request $request){
        $validatedData = $request->validate([
            'category' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'img_ref' => 'string'
        ]);

        // You can add user_id to the post if needed
        $validatedData['user_id'] = auth()->user()->id;

        // Save the post to the database
        Post::create($validatedData);

        return redirect()->route('myPosts');
    }

    public function editPost(Request $request, $id){
        $post = Post::find($id);
        $user = Auth()->user();
        if($post && $user){
            if($user == $post->user)
                return view('user.editPost', compact('post'));
        }
        return  redirect('posts');

    }

    public function deletePost(Request $request, $id){
        $post = Post::find($id);
        $user = Auth()->user();

        if($post && $user){
            if($user == $post->user)
            {
                if($post->delete())
                    return redirect()->route('myPosts')->withState('Post deleted successfully');
                else
                    return redirect()->route('myPosts')->withErrors('Could not delete post ');
            }
        }
        return redirect()->route('myPosts')->withErrors('Could not delete post ');

    }
    public function updatePost(Request $request){
        $id=$request->id;
        $post = Post::find($id);

        // Ellenőrizzük, hogy a bejegyzés létezik-e
        if (!$post) {
            abort(404); // Vagy egyéb kezelés, például visszatérés a hibaoldalra
        }

        $validatedData = $request->validate([
            'category' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'img_ref' => 'string'
        ]);

        // Frissítjük a bejegyzés a validált adatokkal
        if($post->update($validatedData))
            return redirect()->route('myPosts')->withState('Post updated successfully');
        else
            return redirect()->route('myPosts')->withErrors('Could not update post ');
    }


    public function editProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'password' => 'nullable|min:6|confirmed',
            'avatar_url' => 'nullable|string',
        ]);

        // Frissítés az adatbázisban
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->avatar_url = $request->avatar_url;

        $user->save();

        return redirect()->route('editProfile')->with('success', 'Profile updated successfully.');
    }

    public function addComment(Request $request)
    {
       $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'content' => $request->content_,
            'added_at' => now(),
        ]);

        if($comment)
            return redirect()->back()->with('success', 'Comment added successfully.');

        return redirect()->back()->withErrors('failed', 'Failed to add comment.');
    }


}
