<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(private readonly SitemapService $sitemap) {}

    /**
     * Sajikan sitemap XML untuk seluruh halaman publik portal desa.
     */
    public function index(): Response
    {
        return response($this->sitemap->xml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age='.SitemapService::CACHE_TTL,
        ]);
    }

    /**
     * Sajikan robots.txt dinamis berisi lokasi sitemap dan area privat.
     */
    public function robots(): Response
    {
        return response()
            ->view('public.robots', ['sitemapUrl' => route('sitemap')])
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
