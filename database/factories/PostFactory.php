<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
        $file = UploadedFile::fake()->image('test.png');

        return [
            'user_id' => $this->faker->numberBetween(10),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $file->hashName(),
            'title' => 'test_title',
            'description' => 'test_description'
        ];
    }
}
