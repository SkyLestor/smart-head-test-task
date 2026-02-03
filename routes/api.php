<?php

use App\Http\Controllers\Api\GenreController;
use Illuminate\Support\Facades\Route;

// index -> GET /api/genres
// show  -> GET /api/genres/{id}
Route::apiResource('genres', GenreController::class)
    ->only(['index', 'show']);
