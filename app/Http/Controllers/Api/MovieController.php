<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use Throwable;

class MovieController extends Controller
{

    protected MovieService $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

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

    /**
     * POST /api/movies
     * Creates a new movie.
     * @throws Throwable
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = $this->service->create($request->validated());

        return new MovieResource($movie->load('genres'));
    }

    /**
     * PUT /api/movies/{id}
     * Updates an existing movie.
     * @throws Throwable
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie = $this->service->update($movie, $request->validated());

        return new MovieResource($movie->load('genres'));
    }


    /**
     * DELETE /api/movies/{id}
     * Deletes a specific movie.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }


    /**
     * PATCH /api/movies/{id}/publish
     * Publishes a specific movie.
     */
    public function publish(Movie $movie)
    {
        $this->service->publish($movie);
        return new MovieResource($movie);
    }

}
