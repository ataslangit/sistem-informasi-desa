<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $table = 'gallery_photos';

    protected $fillable = [
        'gallery_id',
        'image_url',
        'caption',
        'sort_order',
    ];

    protected $casts = [
        'gallery_id' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relasi ke Album Galeri (Content type: gallery).
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'gallery_id');
    }
}
