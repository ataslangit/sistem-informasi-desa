<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidentMutation extends Model
{
    use Auditable, HasFactory;

    protected $table = 'resident_mutations';

    protected $fillable = [
        'resident_id',
        'type',
        'date',
        'reason',
        'notes',
        'reference_number',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relasi ke Penduduk yang mengalami mutasi.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    /**
     * Relasi ke petugas / user yang mencatat mutasi.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Label tipe mutasi dalam Bahasa Indonesia.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'birth' => 'Kelahiran',
            'death' => 'Kematian',
            'moved_out' => 'Pindah Keluar',
            'moved_in' => 'Pindah Datang',
            default => ucfirst($this->type),
        };
    }

    /**
     * Badge warna untuk UI.
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'birth' => 'bg-emerald-100 text-emerald-800',
            'death' => 'bg-slate-100 text-slate-800',
            'moved_out' => 'bg-rose-100 text-rose-800',
            'moved_in' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
