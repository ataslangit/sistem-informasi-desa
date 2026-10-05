<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use Auditable, HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'url',
        'type',
        'page_id',
        'parent_id',
        'location',
        'target',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'page_id' => 'integer',
        'parent_id' => 'integer',
    ];

    /**
     * Relasi ke menu induk (Parent).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Relasi ke submenu (Children).
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Relasi ke halaman statis jika type = page.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'page_id');
    }

    /**
     * Scope menu header.
     */
    public function scopeHeader(Builder $query): Builder
    {
        return $query->where('location', 'header');
    }

    /**
     * Scope menu footer.
     */
    public function scopeFooter(Builder $query): Builder
    {
        return $query->where('location', 'footer');
    }

    /**
     * Scope menu level teratas (tanpa parent).
     */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope menu aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper URL tujuan yang teresolusi secara dinamis.
     */
    public function getResolvedUrlAttribute(): string
    {
        if ($this->type === 'page' && $this->page) {
            return url('/halaman/'.$this->page->slug);
        }

        if (! empty($this->url)) {
            if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://')) {
                return $this->url;
            }

            return url($this->url);
        }

        return '#';
    }

    /**
     * Cek apakah menu ini sedang aktif di halaman saat ini.
     */
    public function isCurrent(): bool
    {
        $currentUrl = url()->current();
        $menuUrl = $this->resolved_url;

        if ($menuUrl === '#' || empty($menuUrl)) {
            return false;
        }

        return $currentUrl === $menuUrl;
    }
}
