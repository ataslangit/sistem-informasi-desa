<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'families';

    protected $fillable = [
        'family_card_number',
        'head_of_family_id',
        'address',
        'rt',
        'rw',
        'hamlet',
        'postal_code',
        'social_assistance_status',
        'economic_status',
    ];

    /**
     * Relasi ke Kepala Keluarga (Resident).
     */
    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'head_of_family_id');
    }

    /**
     * Relasi ke seluruh anggota keluarga (Residents).
     */
    public function members(): HasMany
    {
        return $this->hasMany(Resident::class, 'family_id');
    }

    /**
     * Mengambil anggota keluarga yang berstatus aktif.
     */
    public function activeMembers(): HasMany
    {
        return $this->hasMany(Resident::class, 'family_id')->where('status', 'active');
    }

    /**
     * Scope untuk pencarian berdasarkan nomor KK atau nama kepala keluarga.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('family_card_number', 'like', "%{$keyword}%")
                ->orWhereHas('headOfFamily', function (Builder $hq) use ($keyword) {
                    $hq->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nik', 'like', "%{$keyword}%");
                });
        });
    }

    /**
     * Scope filter berdasarkan dusun / wilayah.
     */
    public function scopeByHamlet(Builder $query, ?string $hamlet): Builder
    {
        if (empty($hamlet)) {
            return $query;
        }

        return $query->where('hamlet', $hamlet);
    }

    /**
     * Format alamat lengkap KK.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            "RT {$this->rt} / RW {$this->rw}",
            $this->hamlet ? "Dusun {$this->hamlet}" : null,
            $this->postal_code ? "Kode Pos {$this->postal_code}" : null,
        ]);

        return implode(', ', $parts);
    }
}
