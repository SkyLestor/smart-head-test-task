<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $genres = Genre::factory(10)->create();

        $movies = Movie::factory(50)->create();

        $movies->each(function ($movie) use ($genres) {
            $randomGenres = $genres->random(rand(1, 3))->pluck('id');
            $movie->genres()->attach($randomGenres);
        });
    }

}
