<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        try {
            return [
                'user_id' => random_int(1, 3),
                'post_id' => random_int(1, 3),
                'content' => $this->faker->paragraph,
                'img_ref' => "https://picsum.photos/250/250",
                'added_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Set a random date within the last month
            ];
        }
        catch (Exception $e)
        {
            return  [];
        }
    }
}
