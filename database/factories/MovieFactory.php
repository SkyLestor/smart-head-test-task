<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'is_published' => fake()->boolean(70),
            'poster_url' => MovieService::DEFAULT_IMAGE_PATH,
        ];
    }
}
