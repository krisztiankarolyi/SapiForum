<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 3),
            'category' => $this->faker->word,
            'title' => $this->faker->word,
            'content' => $this->faker->paragraph,
            'img_ref' => "https://picsum.photos/300/300",
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Set a random date within the last month
        ];
    }
}
