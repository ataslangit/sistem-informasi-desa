<?php

namespace App\Models;

use CodeIgniter\Model;

class Penduduk extends Model
{
    protected $table            = 'tweb_penduduk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama', 'nik', 'id_kk', 'kk_level', 'id_rtm',
        'rtm_level', 'sex', 'tempatlahir', 'tanggallahir',
        'agama_id', 'pendidikan_kk_id', 'pendidikan_id',
        'pendidikan_sedang_id', 'pekerjaan_id', 'status_kawin',
        'warganegara_id', 'dokumen_pasport', 'dokumen_kitas',
        'ayah_nik', 'ibu_nik', 'nama_ayah', 'nama_ibu',
        'foto', 'golongan_darah_id', 'id_cluster', 'status',
        'alamat_sebelumnya', 'alamat_sekarang', 'status_dasar',
        'hamil', 'cacat_id', 'sakit_menahun_id', 'jamkesmas',
        'akta_lahir', 'akta_perkawinan', 'tanggalperkawinan',
        'akta_perceraian', 'tanggalperceraian',
    ];
}
