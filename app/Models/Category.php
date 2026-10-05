<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    /**
     * Relasi ke Content.
     */
    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_category', 'category_id', 'content_id');
    }

    /**
     * Scope kategori reguler.
     */
    public function scopeCategories(Builder $query): Builder
    {
        return $query->where('type', 'category');
    }

    /**
     * Scope tag.
     */
    public function scopeTags(Builder $query): Builder
    {
        return $query->where('type', 'tag');
    }
}
