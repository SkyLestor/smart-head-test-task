<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MovieService
{

    const string DEFAULT_IMAGE_PATH = 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=400&auto=format&fit=crop';

    /**
     * Movie creation with attaching genres
     * @throws Throwable
     */
    public function create(array $data): Movie
    {
        $uploadedFilePath = null;
        try {
            return DB::transaction(function () use ($data, &$uploadedFilePath) {
                $posterPath = $this->handleUpload($data['poster'] ?? null);

                if ($data['poster'] ?? null instanceof UploadedFile) {
                    $uploadedFilePath = $posterPath;
                }

                $movie = Movie::create([
                    'title' => $data['title'],
                    'poster_url' => $posterPath,
                    'is_published' => false,
                ]);

                if (!empty($data['genres'])) {
                    $movie->genres()->attach($data['genres']);
                }

                return $movie;
            });
        } catch (Throwable $e) {
            if ($uploadedFilePath) {
                Storage::disk('public')->delete($uploadedFilePath);
            }
            throw $e;
        }
    }

    /**
     * Updating the existing movie
     * @throws Throwable
     */
    public function update(Movie $movie, array $data): Movie
    {
        $newPosterPath = null;
        $oldPosterPath = $movie->poster_url;

        try {
            $updatedMovie = DB::transaction(function () use ($movie, $data, &$newPosterPath) {

                if (isset($data['poster']) && $data['poster'] instanceof UploadedFile) {
                    $newPosterPath = $this->handleUpload($data['poster']);
                    $data['poster_url'] = $newPosterPath;
                }

                $movie->update($data);
                if (isset($data['genres'])) {
                    $movie->genres()->sync($data['genres']);
                }

                return $movie;
            });

            if ($newPosterPath && $oldPosterPath && $oldPosterPath !== self::DEFAULT_IMAGE_PATH) {
                Storage::disk('public')->delete($oldPosterPath);
            }
            return $updatedMovie;

        } catch (Throwable $e) {
            if ($newPosterPath) {
                Storage::disk('public')->delete($newPosterPath);
            }
            throw $e;
        }

    }

    /**
     * Image upload function
     */
    protected function handleUpload($file): string
    {
        if ($file instanceof UploadedFile) {
            return $file->store('posters', 'public');
        }

        return self::DEFAULT_IMAGE_PATH;
    }
}
