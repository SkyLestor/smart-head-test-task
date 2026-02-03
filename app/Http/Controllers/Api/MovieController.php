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
     * @throws Throwable
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = $this->service->create($request->validated());

        return new MovieResource($movie);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie = $this->service->update($movie, $request->validated());

        return new MovieResource($movie);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }

    public function publish(Movie $movie)
    {
        $this->service->publish($movie);
        return new MovieResource($movie);
    }

}
