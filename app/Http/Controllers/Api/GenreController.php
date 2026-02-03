<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Http\Resources\MovieResource;
use App\Models\Genre;

class GenreController extends Controller
{
    // GET /api/genres
    public function index()
    {
        return GenreResource::collection(Genre::all());
    }

    // GET /api/genres/{id}
    public function show(Genre $genre)
    {
        $movies = $genre->movies()->paginate(10);

        return MovieResource::collection($movies);
    }
}
