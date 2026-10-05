<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageBoundary extends Model
{
    use Auditable, HasFactory;

    public const TYPE_VILLAGE = 'village';

    public const TYPE_DUSUN = 'dusun';

    public const TYPE_RW = 'rw';

    public const TYPE_RT = 'rt';

    protected $fillable = [
        'name',
        'type',
        'color',
        'coordinates',
        'area_hectares',
        'description',
    ];

    protected $casts = [
        'coordinates' => 'array',
        'area_hectares' => 'float',
    ];

    protected $appends = [
        'type_label',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_VILLAGE => 'Batas Desa',
            self::TYPE_DUSUN => 'Wilayah Dusun',
            self::TYPE_RW => 'Wilayah RW',
            self::TYPE_RT => 'Wilayah RT',
            default => ucfirst($this->type),
        };
    }
}
