<?php

namespace Database\Factories;
use Illuminate\Http\UploadedFile;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

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
            'profile_image' => $file->hashName(),
            'profile_body' => 'profile_test'
        ];
    }
}
