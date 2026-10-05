<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicDocument extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $table = 'public_documents';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'document_type',
        'year',
        'description',
        'file_path',
        'file_size',
        'file_extension',
        'download_count',
        'is_published',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'year' => 'integer',
        'download_count' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * User pembuat/pengunggah berkas dokumen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope dokumen yang telah dipublikasikan.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope filter berdasarkan kategori KIP (berkala, setiap_saat, serta_merta).
     */
    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        if (empty($category)) {
            return $query;
        }

        return $query->where('category', $category);
    }

    /**
     * Scope filter berdasarkan tipe dokumen (RPJMDes, RKPDes, LPPD, dll).
     */
    public function scopeDocumentType(Builder $query, ?string $documentType): Builder
    {
        if (empty($documentType)) {
            return $query;
        }

        return $query->where('document_type', $documentType);
    }

    /**
     * Scope filter berdasarkan tahun anggaran / penetapan.
     */
    public function scopeYear(Builder $query, ?int $year): Builder
    {
        if (empty($year)) {
            return $query;
        }

        return $query->where('year', $year);
    }

    /**
     * Scope pencarian kata kunci judul atau deskripsi dokumen.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword): void {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    /**
     * Ukuran file yang diformat (KB, MB).
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log($bytes, 1024));

        return round($bytes / (1024 ** $i), 2).' '.$units[$i];
    }

    /**
     * Label manusiawi untuk kategori KIP.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'berkala' => 'Informasi Berkala',
            'setiap_saat' => 'Informasi Setiap Saat',
            'serta_merta' => 'Informasi Serta Merta',
            'dikecualikan' => 'Informasi Dikecualikan',
            default => ucfirst(str_replace('_', ' ', (string) $this->category)),
        };
    }
}
