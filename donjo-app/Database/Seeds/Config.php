<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Config extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('config');

        $builder->insertBatch([
            [
                'id'                => '',
                'nama_desa'         => 'Bumi Pertiwi',
                'kode_desa'         => '07',
                'nama_kepala_desa'  => 'Jarwo',
                'nip_kepala_desa'   => '--',
                'kode_pos'          => '53482',
                'nama_kecamatan'    => 'Nusantara',
                'kode_kecamatan'    => '08',
                'nama_kepala_camat' => 'Sukirman',
                'nip_kepala_camat'  => '23425525025',
                'nama_kabupaten'    => 'Sejahtera',
                'kode_kabupaten'    => '03',
                'nama_propinsi'     => 'Banjar Raya',
                'kode_propinsi'     => '34',
                'logo'              => 'logo-kab.png',
                'lat'               => '-7.817710559245467',
                'lng'               => '110.24645910630034',
                'zoom'              => 11,
                'map_tipe'          => 'roadmap',
                'path'              => '(-7.79565213709092, 110.28864670079201);(-7.835787886919521, 110.27628708165139);(-7.902445488180415, 110.3428916959092);(-7.914007448532148, 110.39645004551858);(-7.805176223404801, 110.36623764317483);(-7.797012734126373, 110.32435226719826);',
                'alamat_kantor'     => 'Jl. Tengah Raya Tinggi No. 77',
                'g_analytic'        => '',
                'regid'             => '',
                'macid'             => '',
                'email_desa'        => '',
                'gapi_key'          => 'AIzaSyDI70EOSFvckxwK-ZGUONYJ6nUJBFf9f7g',
            ],
        ]);
    }
}
