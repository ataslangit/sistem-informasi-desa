<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Content;
use App\Models\PublicDocument;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    public const CACHE_KEY = 'sitemap.xml';

    public const CACHE_TTL = 3600;

    /**
     * Render XML sitemap dari seluruh konten publik yang relevan untuk mesin pencari.
     */
    public function xml(): string
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function (): string {
            return view('public.sitemap', ['urls' => $this->urls()])->render();
        });
    }

    /**
     * Hapus cache sitemap agar dibuat ulang pada permintaan berikutnya.
     */
    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Susun daftar URL publik beserta metadata lastmod, changefreq, dan priority.
     *
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string, priority: string}>
     */
    public function urls(): array
    {
        $urls = [
            $this->entry(route('home'), null, 'daily', '1.0'),
            $this->entry(route('articles.index'), $this->latestTimestamp(Content::posts()->published()), 'daily', '0.9'),
            $this->entry(route('articles.announcements'), $this->latestTimestamp(Content::announcements()->published()), 'daily', '0.8'),
            $this->entry(route('galleries.index'), $this->latestTimestamp(Content::galleries()->published()), 'weekly', '0.6'),
            $this->entry(route('budgets.index'), $this->latestTimestamp(Budget::published()), 'monthly', '0.7'),
            $this->entry(route('map.index'), null, 'monthly', '0.5'),
            $this->entry(route('public.ppid.index'), $this->latestTimestamp(PublicDocument::published()), 'weekly', '0.6'),
            $this->entry(route('public.ppid.documents'), $this->latestTimestamp(PublicDocument::published()), 'weekly', '0.6'),
        ];

        foreach (Content::posts()->published()->orderByDesc('published_at')->get(['slug', 'updated_at', 'published_at']) as $article) {
            $urls[] = $this->entry(
                route('articles.show', $article->slug),
                $this->lastmod($article->updated_at ?? $article->published_at),
                'weekly',
                '0.8'
            );
        }

        foreach (Content::pages()->published()->orderBy('sort_order')->get(['slug', 'updated_at']) as $page) {
            $urls[] = $this->entry(
                route('pages.show', $page->slug),
                $this->lastmod($page->updated_at),
                'monthly',
                '0.7'
            );
        }

        foreach (Content::galleries()->published()->orderByDesc('published_at')->get(['slug', 'updated_at', 'published_at']) as $gallery) {
            $urls[] = $this->entry(
                route('galleries.show', $gallery->slug),
                $this->lastmod($gallery->updated_at ?? $gallery->published_at),
                'weekly',
                '0.6'
            );
        }

        $categories = Category::categories()
            ->whereHas('contents', fn (Builder $query) => $query->posts()->published())
            ->orderBy('name')
            ->get(['id', 'slug', 'updated_at']);

        foreach ($categories as $category) {
            $urls[] = $this->entry(
                route('articles.category', $category->slug),
                $this->lastmod($category->updated_at),
                'weekly',
                '0.6'
            );
        }

        return $urls;
    }

    /**
     * @return array{loc: string, lastmod: string|null, changefreq: string, priority: string}
     */
    private function entry(string $loc, ?string $lastmod, string $changefreq, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    /**
     * Ambil timestamp pembaruan terakhir dari query konten publik.
     */
    private function latestTimestamp(Builder $query): ?string
    {
        $timestamp = $query->max('updated_at');

        return $this->lastmod($timestamp !== null ? Carbon::parse($timestamp) : null);
    }

    /**
     * Format tanggal menjadi W3C Datetime sesuai standar sitemap.org.
     */
    private function lastmod(?CarbonInterface $date): ?string
    {
        return $date?->toAtomString();
    }
}
