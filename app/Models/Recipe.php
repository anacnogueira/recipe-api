<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(RecipeReaction::class);
    }

    public function likesCount(): int
    {
        return $this->reactions()->where('type', 'like')->count();
    }

    public function dislikesCount(): int
    {
        return $this->reactions()->where('type', 'dislike')->count();
    }

    public function views(): HasMany
    {
        return $this->hasMany(RecipeView::class);
    }

    public function scopeTopViewedBetween($query, $start, $end, $limit = 10)
    {
        return $query->withCount(['views' => function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }])->orderByDesc('views_count')->take($limit);
    }

    public function scopeTopLikedBetween($query, $start, $end, $limit = 5)
    {
        return $query->withCount(['reactions' => function ($query) use ($start, $end) {
            $query->where('type', 'like')->whereBetween('created_at', [$start, $end]);
        }])->orderByDesc('reactions_count')->take($limit);
    }
}
