<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageFacility extends Model
{
    use Auditable, HasFactory;

    // --- Klasifikasi Kartu Inventaris Barang (KIB) - Permendagri No. 1/2016 ---
    public const KIB_A = 'kib_a';

    public const KIB_B = 'kib_b';

    public const KIB_C = 'kib_c';

    public const KIB_D = 'kib_d';

    public const KIB_E = 'kib_e';

    public const KIB_F = 'kib_f';

    public const KIB_METAS = [
        self::KIB_A => [
            'code' => 'KIB A',
            'name' => 'Tanah',
            'icon' => '🏞️',
            'description' => 'Tanah kas desa, tanah bengkok, lapangan, dan perkantoran',
            'badge' => 'emerald',
        ],
        self::KIB_B => [
            'code' => 'KIB B',
            'name' => 'Peralatan dan Mesin',
            'icon' => '🚜',
            'description' => 'Kendaraan dinas, traktor, genset, komputer, dan mesin kantor desa',
            'badge' => 'blue',
        ],
        self::KIB_C => [
            'code' => 'KIB C',
            'name' => 'Gedung dan Bangunan',
            'icon' => '🏢',
            'description' => 'Kantor desa, balai pertemuan, posyandu, puskesdes, pasar desa',
            'badge' => 'indigo',
        ],
        self::KIB_D => [
            'code' => 'KIB D',
            'name' => 'Jalan, Irigasi dan Jaringan',
            'icon' => '🛣️',
            'description' => 'Jalan desa, jembatan, saluran irigasi, drainase, perpipaan air',
            'badge' => 'amber',
        ],
        self::KIB_E => [
            'code' => 'KIB E',
            'name' => 'Aset Tetap Lainnya',
            'icon' => '📚',
            'description' => 'Buku perpustakaan desa, barang seni/budaya, tanaman dan hewan ternak',
            'badge' => 'purple',
        ],
        self::KIB_F => [
            'code' => 'KIB F',
            'name' => 'Konstruksi Dalam Pengerjaan',
            'icon' => '🏗️',
            'description' => 'Fasilitas dan bangunan fisik yang masih dalam tahap pembangunan',
            'badge' => 'rose',
        ],
    ];

    // --- Status Hak Kepemilikan Yuridis Aset Desa (Permendagri No. 1/2016 Pasal 6) ---
    public const OWNERSHIP_TKD = 'tanah_kas_desa';

    public const OWNERSHIP_APBDES = 'apbdes';

    public const OWNERSHIP_HIBAH = 'hibah';

    public const OWNERSHIP_PEMERINTAH_PUSAT = 'pemerintah_pusat';

    public const OWNERSHIP_PEMERINTAH_DAERAH = 'pemerintah_daerah';

    public const OWNERSHIP_LAINNYA = 'lainnya_sah';

    public const OWNERSHIP_STATUSES = [
        self::OWNERSHIP_TKD => [
            'label' => 'Tanah Kas Desa (TKD) / Kekayaan Asli Desa',
            'short_label' => 'TKD / Kekayaan Asli',
            'badge' => 'emerald',
            'icon' => '📜',
        ],
        self::OWNERSHIP_APBDES => [
            'label' => 'Pengadaan Beban APBDes',
            'short_label' => 'Beban APBDes',
            'badge' => 'blue',
            'icon' => '💰',
        ],
        self::OWNERSHIP_HIBAH => [
            'label' => 'Hibah / Sumbangan Pihak Ketiga & Swadaya',
            'short_label' => 'Hibah / Swadaya',
            'badge' => 'purple',
            'icon' => '🤝',
        ],
        self::OWNERSHIP_PEMERINTAH_PUSAT => [
            'label' => 'Bantuan Pemerintah Pusat (Kementerian)',
            'short_label' => 'Pemerintah Pusat',
            'badge' => 'amber',
            'icon' => '🏛️',
        ],
        self::OWNERSHIP_PEMERINTAH_DAERAH => [
            'label' => 'Bantuan Pemerintah Daerah (Provinsi/Kab/Kota)',
            'short_label' => 'Pemda / Provinsi',
            'badge' => 'indigo',
            'icon' => '🏢',
        ],
        self::OWNERSHIP_LAINNYA => [
            'label' => 'Perolehan Lain yang Sah',
            'short_label' => 'Lainnya yang Sah',
            'badge' => 'slate',
            'icon' => '📋',
        ],
    ];

    protected $fillable = [
        'name',
        'category',
        'latitude',
        'longitude',
        'address',
        'image_url',
        'condition',
        'description',
        'is_village_asset',
        'kib_type',
        'ownership_status',
        'register_code',
        'surface_area',
        'acquisition_year',
        'asset_value',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_village_asset' => 'boolean',
        'surface_area' => 'float',
        'acquisition_year' => 'integer',
        'asset_value' => 'float',
    ];

    protected $appends = [
        'category_meta',
        'condition_label',
        'kib_meta',
        'ownership_meta',
        'formatted_asset_value',
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

    public static function getKibMetas(): array
    {
        return self::KIB_METAS;
    }

    public static function getOwnershipStatuses(): array
    {
        return self::OWNERSHIP_STATUSES;
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

    public function getKibMetaAttribute(): ?array
    {
        if (! $this->kib_type) {
            return null;
        }

        return self::KIB_METAS[$this->kib_type] ?? null;
    }

    public function getOwnershipMetaAttribute(): ?array
    {
        if (! $this->ownership_status) {
            return null;
        }

        return self::OWNERSHIP_STATUSES[$this->ownership_status] ?? null;
    }

    public function getFormattedAssetValueAttribute(): ?string
    {
        if ($this->asset_value === null) {
            return null;
        }

        return 'Rp '.number_format($this->asset_value, 0, ',', '.');
    }

    /**
     * Scope untuk memfilter fasilitas yang berstatus aset milik desa.
     */
    public function scopeVillageAssets(Builder $query): Builder
    {
        return $query->where('is_village_asset', true);
    }

    /**
     * Scope untuk memfilter berdasarkan klasifikasi KIB.
     */
    public function scopeKib(Builder $query, string $kibType): Builder
    {
        return $query->where('kib_type', $kibType);
    }

    /**
     * Scope untuk memfilter berdasarkan status hak kepemilikan.
     */
    public function scopeOwnership(Builder $query, string $status): Builder
    {
        return $query->where('ownership_status', $status);
    }
}
