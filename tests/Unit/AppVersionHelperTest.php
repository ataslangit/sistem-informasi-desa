<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class AppVersionHelperTest extends TestCase
{
    /**
     * Test app_name() mengembalikan nama aplikasi dari konfigurasi.
     */
    public function test_app_name_returns_configured_name(): void
    {
        config(['app.name' => 'SiDesa Test']);

        $this->assertEquals('SiDesa Test', app_name());
    }

    /**
     * Test app_version() mengembalikan versi tanpa atau dengan prefiks 'v'.
     */
    public function test_app_version_returns_version_string(): void
    {
        config(['app.version' => '2.1.0']);

        $this->assertEquals('2.1.0', app_version());
        $this->assertEquals('v2.1.0', app_version(withPrefix: true));
        $this->assertEquals('v2.1.0', app_version(true));
    }

    /**
     * Test app_version() dengan parameter withName menyertakan nama aplikasi.
     */
    public function test_app_version_with_name_returns_full_identity(): void
    {
        config(['app.name' => 'SiDesa', 'app.version' => '1.0.0']);

        $this->assertEquals('SiDesa v1.0.0', app_version(withName: true));
    }

    /**
     * Test app_name_version() menghasilkan format gabungan nama dan versi.
     */
    public function test_app_name_version_helper_returns_combined_string(): void
    {
        config(['app.name' => 'SiDesa', 'app.version' => '1.0.0']);

        $this->assertEquals('SiDesa v1.0.0', app_name_version());
        $this->assertEquals('CustomSiDesa v1.0.0', app_name_version('CustomSiDesa'));
    }
}
