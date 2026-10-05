<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterRequest extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    public const STATUS_PENDING_RT = 'pending_rt';

    public const STATUS_PENDING_STAFF = 'pending_staff';

    public const STATUS_PENDING_KADES = 'pending_kades';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    // --- Tipe Tanda Tangan Elektronik (UU No. 1/2024 & PP No. 71/2019) ---
    public const SIGNATURE_TYPE_CERTIFIED = 'certified';

    public const SIGNATURE_TYPE_UNCERTIFIED = 'uncertified';

    public const PROVIDER_BSRE = 'bsre_bssn';

    public const PROVIDER_PERURI = 'peruri';

    public const PROVIDER_LOCAL = 'local';

    protected $table = 'letter_requests';

    protected $fillable = [
        'request_number',
        'letter_number',
        'letter_template_id',
        'resident_id',
        'user_id',
        'purpose',
        'extra_data',
        'status',
        'rt_verified_at',
        'rt_verified_by',
        'rt_notes',
        'staff_verified_at',
        'staff_verified_by',
        'staff_notes',
        'kades_approved_at',
        'kades_approved_by',
        'kades_notes',
        'rejection_reason',
        'rejected_by',
        'rejected_at',
        'final_content',
        'qr_token',
        'signed_at',

        // Atribut TTE Tersertifikasi (PSrE / BSrE BSSN)
        'signature_type',
        'tte_provider',
        'certificate_issuer',
        'certificate_serial_number',
        'document_hash',
        'signature_hash',
        'signer_name',
        'signer_nip',
        'signer_nik',
        'signer_position',
        'tte_timestamp',
        'is_tampered',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'rt_verified_at' => 'datetime',
        'staff_verified_at' => 'datetime',
        'kades_approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'signed_at' => 'datetime',
        'tte_timestamp' => 'datetime',
        'is_tampered' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rtVerifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rt_verified_by');
    }

    public function staffVerifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_verified_by');
    }

    public function kadesApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kades_approved_by');
    }

    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING_RT => 'Menunggu Verifikasi RT/RW',
            self::STATUS_PENDING_STAFF => 'Menunggu Verifikasi Staf Desa',
            self::STATUS_PENDING_KADES => 'Menunggu TTE Kades',
            self::STATUS_APPROVED => 'Selesai & Disahkan',
            self::STATUS_REJECTED => 'Ditolak',
            default => $this->status,
        };
    }

    public function canBeProcessedBy(?User $user): bool
    {
        if (! $user || $this->isApproved() || $this->isRejected()) {
            return false;
        }

        if ($user->hasRole('superadmin')) {
            return true;
        }

        return match ($this->status) {
            self::STATUS_PENDING_RT => $user->hasRole(['rt', 'perangkat']) || $user->hasPermission('letters.verify_rt') || $user->hasPermission('letters.process'),
            self::STATUS_PENDING_STAFF => $user->hasRole('perangkat') || $user->hasPermission('letters.process'),
            self::STATUS_PENDING_KADES => $user->hasRole('kades') || $user->hasPermission('letters.approve'),
            default => false,
        };
    }

    public function isCertifiedTte(): bool
    {
        return $this->signature_type === self::SIGNATURE_TYPE_CERTIFIED;
    }

    public function getTteProviderLabelAttribute(): string
    {
        return match ($this->tte_provider) {
            self::PROVIDER_BSRE => 'Balai Sertifikasi Elektronik (BSrE) - BSSN',
            self::PROVIDER_PERURI => 'Perum Peruri Digital Signature',
            self::PROVIDER_LOCAL => 'TTE Lokal SiDesa',
            default => 'Penyelenggara Sertifikasi Elektronik (PSrE)',
        };
    }

    public function getFormattedDocumentHashAttribute(): string
    {
        if (empty($this->document_hash)) {
            return '-';
        }

        return substr($this->document_hash, 0, 16).'...'.substr($this->document_hash, -8);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [
            self::STATUS_PENDING_RT,
            self::STATUS_PENDING_STAFF,
            self::STATUS_PENDING_KADES,
        ]);
    }
}
