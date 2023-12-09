<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $users = User::factory(3)->create();
        $posts = Post::factory(10)->create();
      //  $users = Comment::factory(3)->create();
    }
}
