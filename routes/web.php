<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'project' => 'Smart Head Test Task API',
        'status' => 'running',
        'version' => '1.0.0',
        'endpoints' => [
            'documentation' => 'See README.md',
            'movies' => url('/api/movies'),
            'genres' => url('/api/genres'),
        ]
    ]);
});
