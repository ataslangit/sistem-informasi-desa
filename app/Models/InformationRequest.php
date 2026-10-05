<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationRequest extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'information_requests';

    protected $fillable = [
        'ticket_number',
        'applicant_name',
        'applicant_nik',
        'applicant_phone',
        'applicant_email',
        'applicant_address',
        'identity_card_path',
        'information_requested',
        'purpose',
        'acquisition_way',
        'status',
        'response_text',
        'response_file_path',
        'rejection_reason',
        'responded_at',
        'responded_by',
        'user_id',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /**
     * User akun pemohon (jika terdaftar di sistem).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Petugas PPID penjawab permohonan.
     */
    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Relasi ke keberatan informasi (jika diajukan).
     */
    public function objection(): HasOne
    {
        return $this->hasOne(InformationObjection::class, 'information_request_id');
    }

    /**
     * Scope pencarian nomor tiket, nama pemohon, atau email.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword): void {
            $q->where('ticket_number', 'like', "%{$keyword}%")
                ->orWhere('applicant_name', 'like', "%{$keyword}%")
                ->orWhere('applicant_email', 'like', "%{$keyword}%")
                ->orWhere('applicant_phone', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope filter status permohonan.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Generate nomor tiket permohonan KIP otomatis: INF-YYYYMMDD-XXXX.
     */
    public static function generateTicketNumber(): string
    {
        $today = Carbon::today()->format('Ymd');
        $prefix = "INF-{$today}-";

        $latest = static::withTrashed()
            ->where('ticket_number', 'like', "{$prefix}%")
            ->orderByDesc('id')
            ->value('ticket_number');

        if ($latest) {
            $lastSequence = (int) substr($latest, -4);
            $nextSequence = str_pad((string) ($lastSequence + 1), 4, '0', STR_PAD_LEFT);
        } else {
            $nextSequence = '0001';
        }

        return $prefix.$nextSequence;
    }

    /**
     * Label teks dan badge status permohonan.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Menunggu Verifikasi',
            'processed' => 'Sedang Diproses PPID',
            'approved' => 'Disetujui / Selesai',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'bg-amber-50 text-amber-700 border-amber-200',
            'processed' => 'bg-blue-50 text-blue-700 border-blue-200',
            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
            default => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }
}
