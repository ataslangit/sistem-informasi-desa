<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'residents';

    protected $fillable = [
        'family_id',
        'nik',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'blood_type',
        'religion',
        'marital_status',
        'family_relationship_status',
        'education_level',
        'occupation',
        'nationality',
        'father_name',
        'mother_name',
        'status',
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Relasi ke Kartu Keluarga (Family).
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    /**
     * Relasi ke akun pengguna (User), jika warga memiliki akun aplikasi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke log mutasi kependudukan (ResidentMutation).
     */
    public function mutations(): HasMany
    {
        return $this->hasMany(ResidentMutation::class, 'resident_id')->latest('date');
    }

    /**
     * Scope penduduk berstatus aktif (masih hidup dan berdomisili di desa).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pencarian berdasarkan NIK atau Nama.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('nik', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope filter berdasarkan jenis kelamin.
     */
    public function scopeGender(Builder $query, ?string $gender): Builder
    {
        if (empty($gender)) {
            return $query;
        }

        return $query->where('gender', $gender);
    }

    /**
     * Scope filter berdasarkan status penduduk.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Accessor menghitung umur penduduk dalam tahun.
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->age : 0;
    }

    /**
     * Accessor label jenis kelamin lengkap.
     */
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Cek apakah penduduk adalah Kepala Keluarga di KK-nya.
     */
    public function getIsHeadOfFamilyAttribute(): bool
    {
        return $this->family && (int) $this->family->head_of_family_id === (int) $this->id;
    }

    /**
     * Format Tempat, Tanggal Lahir (TTL).
     */
    public function getFormattedTtlAttribute(): string
    {
        $date = $this->birth_date ? $this->birth_date->translatedFormat('d F Y') : '-';

        return "{$this->birth_place}, {$date}";
    }
}
