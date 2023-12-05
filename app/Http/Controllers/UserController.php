<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

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

        // Category szűrő
        $category = $request->query('category', '');
        if ($category) {
            $query->where('category', 'LIKE', '%' . $category . '%');
        }

        $posts = $query->get();

        foreach ($posts as $post) {
            $post->comments_count = $post->comments()->count();
        }

        return view('Posts', compact('posts'));
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



}
