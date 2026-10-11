<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Middleware\InjectDemoBanner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class InjectDemoBannerMiddlewareTest extends TestCase
{
    public function test_does_not_inject_when_demo_mode_is_disabled(): void
    {
        config(['app.demo_mode' => false]);

        $request = Request::create('/', 'GET');
        $middleware = new InjectDemoBanner();

        $response = $middleware->handle($request, function () {
            return new Response('<html><body><h1>Halo Desa</h1></body></html>', 200, [
                'Content-Type' => 'text/html',
            ]);
        });

        $this->assertStringNotContainsString('sidesa-demo-badge', (string) $response->getContent());
    }

    public function test_injects_demo_banner_when_demo_mode_is_enabled(): void
    {
        config(['app.demo_mode' => true]);

        $request = Request::create('/', 'GET');
        $middleware = new InjectDemoBanner();

        $response = $middleware->handle($request, function () {
            return new Response('<html><body><h1>Halo Desa</h1></body></html>', 200, [
                'Content-Type' => 'text/html; charset=UTF-8',
            ]);
        });

        $content = (string) $response->getContent();
        $this->assertStringContainsString('sidesa-demo-badge', $content);
        $this->assertStringContainsString('admin@sidesa.timacodecraft.com', $content);
        $this->assertStringContainsString('https://sidesa-7ch.pages.dev', $content);
        $this->assertStringContainsString('Mode Demo Publik', $content);
        $this->assertStringContainsString('</body>', $content);
    }

    public function test_does_not_inject_for_json_responses(): void
    {
        config(['app.demo_mode' => true]);

        $request = Request::create('/api/status', 'GET');
        $middleware = new InjectDemoBanner();

        $response = $middleware->handle($request, function () {
            return new Response('{"status":"ok"}', 200, [
                'Content-Type' => 'application/json',
            ]);
        });

        $this->assertStringNotContainsString('sidesa-demo-badge', (string) $response->getContent());
    }
}
