<?php

use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;

// index -> GET /api/genres
// show  -> GET /api/genres/{id}
Route::apiResource('genres', GenreController::class)
    ->only(['index', 'show']);


// index -> GET /api/movies
// show  -> GET /api/movies/{id}
Route::apiResource('movies', MovieController::class)
    ->only(['index', 'show']);
