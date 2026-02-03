<?php

use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;

/**
 * index -> GET /api/genres
 * show  -> GET /api/genres/{id}
 */
Route::apiResource('genres', GenreController::class)
    ->only(['index', 'show']);


/**
 * Movie CRUD Routes
 * index   -> GET /api/movies
 * store   -> POST /api/movies
 * show    -> GET /api/movies/{id}
 * update  -> PUT/PATCH /api/movies/{id}
 * destroy -> DELETE /api/movies/{id}
 */
Route::apiResource('movies', MovieController::class);

/**
 * Custom Route: Publish/Unpublish a movie
 * publish -> PATCH /api/movies/{id}/publish
 */
Route::patch('movies/{movie}/publish', [MovieController::class, 'publish']);
