<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profilPage = Content::pages()->where('slug', 'profil-desa')->first();
        $visiMisiPage = Content::pages()->where('slug', 'visi-misi')->first();
        $sotkPage = Content::pages()->where('slug', 'struktur-organisasi')->first();

        // 1. Menu Beranda
        Menu::updateOrCreate(
            ['name' => 'Beranda', 'location' => 'header'],
            [
                'url' => '/',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // 2. Menu Induk: Profil Desa (Dropdown)
        $profilMenu = Menu::updateOrCreate(
            ['name' => 'Profil Desa', 'location' => 'header'],
            [
                'url' => $profilPage ? '/halaman/'.$profilPage->slug : '/halaman/profil-desa',
                'type' => 'page',
                'page_id' => $profilPage?->id,
                'target' => '_self',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // Submenu: Visi & Misi
        Menu::updateOrCreate(
            ['name' => 'Visi & Misi', 'parent_id' => $profilMenu->id],
            [
                'url' => $visiMisiPage ? '/halaman/'.$visiMisiPage->slug : '/halaman/visi-misi',
                'type' => 'page',
                'page_id' => $visiMisiPage?->id,
                'location' => 'header',
                'target' => '_self',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // Submenu: Struktur Organisasi
        Menu::updateOrCreate(
            ['name' => 'Struktur Organisasi', 'parent_id' => $profilMenu->id],
            [
                'url' => $sotkPage ? '/halaman/'.$sotkPage->slug : '/halaman/struktur-organisasi',
                'type' => 'page',
                'page_id' => $sotkPage?->id,
                'location' => 'header',
                'target' => '_self',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // 3. Menu Kabar Desa
        Menu::updateOrCreate(
            ['name' => 'Kabar Desa', 'location' => 'header'],
            [
                'url' => '/berita',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // 4. Menu Galeri Foto
        Menu::updateOrCreate(
            ['name' => 'Galeri', 'location' => 'header'],
            [
                'url' => '/galeri',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        // 5. Menu Transparansi APBDes
        Menu::updateOrCreate(
            ['name' => 'APBDes', 'location' => 'header'],
            [
                'url' => '/apbdes',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 5,
                'is_active' => true,
            ]
        );

        // 6. Menu Peta Digital (GIS)
        Menu::updateOrCreate(
            ['name' => 'Peta Desa', 'location' => 'header'],
            [
                'url' => '/peta',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 6,
                'is_active' => true,
            ]
        );

        // 7. Menu Layanan Surat
        Menu::updateOrCreate(
            ['name' => 'Layanan Surat', 'location' => 'header'],
            [
                'url' => '/citizen/letters/create',
                'type' => 'route',
                'target' => '_self',
                'sort_order' => 7,
                'is_active' => true,
            ]
        );
    }
}
