<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationObjection extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'information_objections';

    protected $fillable = [
        'ticket_number',
        'information_request_id',
        'reason_code',
        'objection_detail',
        'status',
        'response_text',
        'responded_at',
        'responded_by',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /**
     * Relasi ke permohonan informasi publik asal.
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(InformationRequest::class, 'information_request_id');
    }

    /**
     * Atasan PPID (Kepala Desa) yang memberikan tanggapan atas keberatan.
     */
    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Scope pencarian nomor tiket keberatan atau tiket asal.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword): void {
            $q->where('ticket_number', 'like', "%{$keyword}%")
                ->orWhereHas('request', function (Builder $rq) use ($keyword): void {
                    $rq->where('ticket_number', 'like', "%{$keyword}%")
                        ->orWhere('applicant_name', 'like', "%{$keyword}%");
                });
        });
    }

    /**
     * Scope filter status keberatan.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Generate nomor tiket keberatan KIP otomatis: KBR-YYYYMMDD-XXXX.
     */
    public static function generateTicketNumber(): string
    {
        $today = Carbon::today()->format('Ymd');
        $prefix = "KBR-{$today}-";

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
     * Keterangan alasan keberatan standar Perki No. 1/2018.
     */
    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason_code) {
            'rejected' => 'Permohonan Informasi Ditolak',
            'not_provided' => 'Informasi Berkala Tidak Disediakan',
            'not_responded' => 'Permohonan Tidak Ditanggapi dalam Batas Waktu',
            'not_as_requested' => 'Permohonan Ditanggapi Tidak Sebagaimana Diminta',
            'excessive_fee' => 'Pengenaan Biaya Tidak Wajar / Melampaui Ketentuan',
            'late_delivery' => 'Penyampaian Informasi Melebihi Batas Waktu Layanan',
            default => ucfirst(str_replace('_', ' ', (string) $this->reason_code)),
        };
    }

    /**
     * Label dan badge status keberatan.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Menunggu Tinjauan Kades',
            'reviewed' => 'Sedang Ditinjau Atasan PPID',
            'upheld' => 'Keberatan Diterima',
            'rejected' => 'Keberatan Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'bg-amber-50 text-amber-700 border-amber-200',
            'reviewed' => 'bg-blue-50 text-blue-700 border-blue-200',
            'upheld' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
            default => 'bg-slate-50 text-slate-700 border-slate-200',
        };
    }
}
