<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * GET /api/movies
     * Returns paginated list of all movies.
     */
    public function index()
    {
        $movies = Movie::paginate(10);

        return MovieResource::collection($movies);
    }

    /**
     * GET /api/movies/{id}
     * Returns specific movie details.
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }
}
