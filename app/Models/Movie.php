<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'is_published',
        'poster_url',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected $with = ['genres'];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function publish(): void
    {
        $this->update(['is_published' => true]);
    }

    public function unpublish(): void
    {
        $this->update(['is_published' => false]);
    }

    public function hasPoster(): bool
    {
        return !empty($this->poster_url);
    }
}
