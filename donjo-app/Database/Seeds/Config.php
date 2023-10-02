<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Config extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `config` (`id`, `nama_desa`, `kode_desa`, `nama_kepala_desa`, `nip_kepala_desa`, `kode_pos`, `nama_kecamatan`, `kode_kecamatan`, `nama_kepala_camat`, `nip_kepala_camat`, `nama_kabupaten`, `kode_kabupaten`, `nama_propinsi`, `kode_propinsi`, `logo`, `lat`, `lng`, `zoom`, `map_tipe`, `path`, `alamat_kantor`, `g_analytic`, `regid`, `macid`, `email_desa`, `gapi_key`) VALUES
        (1, 'Bumi Pertiwi', '07', 'Jarwo', '--', '53482', 'Nusantara', '08', 'Sukirman', '23425525025', 'Sejahtera', '03', 'Banjar Raya', '34', 'logo-kab.png', '-7.817710559245467', '110.24645910630034', 11, 'roadmap', '(-7.79565213709092, 110.28864670079201);(-7.835787886919521, 110.27628708165139);(-7.902445488180415, 110.3428916959092);(-7.914007448532148, 110.39645004551858);(-7.805176223404801, 110.36623764317483);(-7.797012734126373, 110.32435226719826);', 'Jl. Tengah Raya Tinggi No. 77', '', '', '', '', 'AIzaSyDI70EOSFvckxwK-ZGUONYJ6nUJBFf9f7g')");
    }
}
