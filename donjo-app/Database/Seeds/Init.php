<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Init extends Seeder
{
    public function run()
    {
        $this->call('AnalisisRefState');
        $this->call('AnalisisRefSubjek');
        $this->call('AnalisisTipeIndikator');
        $this->call('Artikel');
        $this->call('Config');
        $this->call('DataJenisPersil');
        $this->call('DataPersilPeruntukan');
        $this->call('GambarGallery');
        $this->call('GisSimbol');
        $this->call('Kategori');
        $this->call('KelompokMaster');
        $this->call('MediaSosial');
        $this->call('Menu');
        $this->call('SettingModul');
        $this->call('SettingSms');
        $this->call('TwebCacat');
        $this->call('TwebDesaPamong');
        $this->call('TwebGolonganDarah');
        $this->call('TwebPendudukAgama');
        $this->call('TwebPendudukHubungan');
        $this->call('TwebPendudukKawin');
        $this->call('TwebPendudukPekerjaan');
        $this->call('TwebPendudukPendidikan');
        $this->call('TwebPendudukPendidikanKk');
        $this->call('TwebPendudukSex');
        $this->call('TwebPendudukStatus');
        $this->call('TwebPendudukUmur');
        $this->call('TwebPendudukWarganegara');
        $this->call('TwebRtmHubungan');
        $this->call('TwebSakitMenahun');
        $this->call('TwebStatusDasar');
    }
}
