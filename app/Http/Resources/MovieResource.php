<?php

namespace App\Http\Resources;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @mixin Movie
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,

            'poster_url' => Str::startsWith($this->poster_url, ['http://', 'https://'])
                ? $this->poster_url
                : asset('storage/' . $this->poster_url),

            'is_published' => $this->is_published,

            'genres' => GenreResource::collection($this->whenLoaded('genres')),
        ];
    }
}
