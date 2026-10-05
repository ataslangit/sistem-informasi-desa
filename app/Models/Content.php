<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    public const TYPE_POST = 'post';

    public const TYPE_PAGE = 'page';

    public const TYPE_ANNOUNCEMENT = 'announcement';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_ARCHIVED = 'archived';

    protected $table = 'contents';

    protected $fillable = [
        'tenant_type',
        'tenant_id',
        'author_id',
        'type',
        'title',
        'slug',
        'summary',
        'body',
        'meta',
        'status',
        'sort_order',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relasi ke penulis (User).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relasi many-to-many ke Kategori / Tag.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'content_category', 'content_id', 'category_id');
    }

    /**
     * Scope artikel berita (type: post).
     */
    public function scopePosts(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_POST);
    }

    /**
     * Scope halaman statis (type: page).
     */
    public function scopePages(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_PAGE);
    }

    /**
     * Scope konten yang sudah tayang / terbit publik.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Helper URL gambar sampul/cover.
     */
    public function getCoverImageAttribute(): ?string
    {
        return $this->meta['cover_image'] ?? null;
    }

    /**
     * Helper estimasi waktu baca (menit).
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags((string) $this->body));
        $minutes = (int) ceil($words / 200);

        return max(1, $minutes);
    }

    /**
     * Render konten body dengan sanitasi XSS yang aman untuk format HTML dan plain text.
     */
    public function getRenderedBodyAttribute(): string
    {
        $body = (string) $this->body;

        // Cek jika konten mengandung markup HTML
        if ($body !== strip_tags($body)) {
            // Izinkan hanya tag aman untuk tata letak artikel & halaman
            $allowedTags = '<p><br><hr><h1><h2><h3><h4><h5><h6><strong><b><em><i><u><s><del><strike><a><ul><ol><li><blockquote><code><pre><img><table><thead><tbody><tr><th><td><div><span>';
            $sanitized = strip_tags($body, $allowedTags);

            // Bersihkan event handler javascript berbahaya (on* attributes)
            $sanitized = preg_replace('/(\s+on\w+\s*=\s*(?:["\'][^"\']*["\']|[^\s>]+))/i', '', (string) $sanitized);

            // Bersihkan href/src yang memuat skema javascript: atau vbscript:
            $sanitized = preg_replace('/((?:href|src)\s*=\s*["\']\s*(?:javascript|vbscript|data):[^"\']*["\'])/i', '', (string) $sanitized);

            return (string) $sanitized;
        }

        // Jika konten berupa plain text murni dari textarea, konversi newline ke <br> dengan auto-escape
        return nl2br(e($body));
    }
}
