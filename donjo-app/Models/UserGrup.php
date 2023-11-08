<?php

namespace App\Models;

use CodeIgniter\Model;

class UserGrup extends Model
{
    protected $table            = 'user_grup';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
    ];
}
