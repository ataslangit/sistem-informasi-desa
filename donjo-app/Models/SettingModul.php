<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModul extends Model
{
    protected $table            = 'setting_modul';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'modul',
        'url',
        'aktif',
        'ikon',
        'urut',
        'level',
        'hidden',
    ];
}
