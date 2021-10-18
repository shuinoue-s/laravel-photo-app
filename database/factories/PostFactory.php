<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

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
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'file_name' => asset('images/dummy-image/image' . rand(1, 14) . '.jpeg'),
            'file_path' => $this->faker->sha256(),
            'title' => $this->faker->text($maxNbChars = 20),
            'description' => $this->faker->text($maxNbChars = 200)
        ];
    }
}
