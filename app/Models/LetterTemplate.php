<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterTemplate extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'letter_templates';

    protected $fillable = [
        'code',
        'name',
        'description',
        'content_template',
        'required_fields',
        'is_active',
    ];

    protected $casts = [
        'required_fields' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke permohonan surat yang menggunakan template ini.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(LetterRequest::class, 'letter_template_id');
    }
}
