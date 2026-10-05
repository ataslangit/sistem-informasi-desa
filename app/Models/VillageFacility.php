<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'latitude',
        'longitude',
        'address',
        'image_url',
        'condition',
        'description',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $appends = [
        'category_meta',
        'condition_label',
    ];

    public static function getCategories(): array
    {
        return [
            'pemerintahan' => ['label' => 'Pemerintahan', 'icon' => '🏛️', 'color' => '#2563eb'],
            'kesehatan' => ['label' => 'Kesehatan', 'icon' => '🏥', 'color' => '#dc2626'],
            'pendidikan' => ['label' => 'Pendidikan', 'icon' => '🏫', 'color' => '#d97706'],
            'ibadah' => ['label' => 'Tempat Ibadah', 'icon' => '🕌', 'color' => '#059669'],
            'ekonomi' => ['label' => 'Sarana Ekonomi & Pasar', 'icon' => '🏪', 'color' => '#7c3aed'],
            'wisata' => ['label' => 'Pariwisata & Budaya', 'icon' => '🌳', 'color' => '#16a34a'],
            'infrastruktur' => ['label' => 'Infrastruktur & Transportasi', 'icon' => '🛣️', 'color' => '#475569'],
        ];
    }

    public function getCategoryMetaAttribute(): array
    {
        $categories = self::getCategories();

        return $categories[$this->category] ?? ['label' => ucfirst($this->category), 'icon' => '📍', 'color' => '#64748b'];
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'baik' => 'Kondisi Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            default => ucfirst((string) $this->condition),
        };
    }
}
