<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectDemoBanner
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya aktif jika APP_DEMO_MODE=true
        if (! config('app.demo_mode', false)) {
            return $response;
        }

        // Jangan inject jika response berupa file download, JSON, atau redirect
        if ($response->isRedirection()) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        if (! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $content = $response->getContent();
        if (false === $content || ! str_contains($content, '</body>')) {
            return $response;
        }

        $bannerHtml = $this->renderBanner();

        // Inject banner dan style tepat sebelum penutup tag </body>
        $newContent = str_replace('</body>', $bannerHtml . "\n</body>", $content);
        $response->setContent($newContent);

        return $response;
    }

    /**
     * Render banner informasi demo sticky mengambang.
     */
    protected function renderBanner(): string
    {
        return <<<'HTML'
<!-- SiDesa Demo Mode Floating Banner -->
<div id="sidesa-demo-badge" style="position: fixed; bottom: 16px; right: 16px; z-index: 999999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; max-width: 360px; pointer-events: auto;">
    <div style="background: rgba(15, 23, 42, 0.94); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); color: #ffffff; padding: 14px 16px; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.12); line-height: 1.4;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-block; width: 8px; height: 8px; background-color: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981;"></span>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #34d399;">Mode Demo Publik</span>
            </div>
            <span style="font-size: 10px; color: #94a3b8; background: rgba(255, 255, 255, 0.08); padding: 2px 6px; border-radius: 4px;">Reset 00:00 WIB</span>
        </div>
        <p style="margin: 0 0 10px 0; font-size: 12px; color: #cbd5e1;">
            Website ini adalah demo online <strong>SiDesa</strong>. Anda dapat mencoba login dengan akun berikut:
        </p>
        <div style="background: rgba(255, 255, 255, 0.06); padding: 6px 10px; border-radius: 6px; font-size: 11px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; color: #f8fafc; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <span>admin@sidesa.timacodecraft.com</span>
            <span style="color: #94a3b8;">password</span>
        </div>
        <div style="display: flex; gap: 6px; align-items: center;">
            <a href="/login" style="flex: 1; text-align: center; background: #2563eb; color: #ffffff; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">Masuk Admin</a>
            <a href="https://sidesa-7ch.pages.dev" target="_blank" rel="noopener noreferrer" style="text-align: center; background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.3)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.2)'">Dokumentasi</a>
            <a href="https://github.com/TIMA-Codecraft/sidesa" target="_blank" rel="noopener noreferrer" style="text-align: center; background: rgba(255, 255, 255, 0.1); color: #e2e8f0; padding: 6px 10px; border-radius: 6px; font-size: 11px; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">GitHub</a>
            <button type="button" onclick="document.getElementById('sidesa-demo-badge').style.display='none'" style="background: transparent; border: none; color: #94a3b8; cursor: pointer; padding: 4px 6px; border-radius: 4px; font-size: 14px; line-height: 1;" title="Tutup Banner">&times;</button>
        </div>
    </div>
</div>
HTML;
    }
}
