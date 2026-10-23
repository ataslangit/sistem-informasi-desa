<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Content;
use App\Services\SitemapService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Sitemap harus memuat URL portal publik dan mengecualikan area privat.
     */
    public function test_sitemap_contains_public_urls_only(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string((string) $response->getContent());
        $this->assertNotFalse($xml);

        $locations = [];
        foreach ($xml->url as $url) {
            $locations[] = (string) $url->loc;
        }

        $this->assertContains(route('home'), $locations);
        $this->assertContains(route('articles.index'), $locations);
        $this->assertContains(route('pages.show', 'profil-desa'), $locations);
        $this->assertContains(route('galleries.show', 'panen-raya-padi-organik'), $locations);
        $this->assertContains(route('public.ppid.documents'), $locations);

        foreach ($locations as $location) {
            $this->assertStringNotContainsString('/admin', $location);
            $this->assertStringNotContainsString('/install', $location);
            $this->assertStringNotContainsString('/login', $location);
            $this->assertStringNotContainsString('/verify/letter', $location);
        }
    }

    /**
     * Artikel berstatus draft tidak boleh muncul di sitemap.
     */
    public function test_sitemap_excludes_draft_articles(): void
    {
        $draft = Content::create([
            'type' => Content::TYPE_POST,
            'title' => 'Draf Rahasia Belum Terbit',
            'slug' => 'draf-rahasia-belum-terbit',
            'status' => Content::STATUS_DRAFT,
            'published_at' => null,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertDontSee(route('articles.show', $draft->slug), false);
    }

    /**
     * robots.txt harus menunjuk sitemap dan memblokir halaman privat.
     */
    public function test_robots_txt_references_sitemap_and_blocks_private_paths(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('Sitemap: '.route('sitemap'), false);
        $response->assertSee('Disallow: /admin', false);
        $response->assertSee('Disallow: /install', false);
    }

    /**
     * Perubahan konten publik harus membersihkan cache sitemap.
     */
    public function test_sitemap_cache_is_flushed_when_content_changes(): void
    {
        $this->get('/sitemap.xml')->assertOk();
        $this->assertTrue(Cache::has(SitemapService::CACHE_KEY));

        Content::create([
            'type' => Content::TYPE_POST,
            'title' => 'Artikel Baru Setelah Cache',
            'slug' => 'artikel-baru-setelah-cache',
            'status' => Content::STATUS_DRAFT,
        ]);

        $this->assertFalse(Cache::has(SitemapService::CACHE_KEY));
    }
}
