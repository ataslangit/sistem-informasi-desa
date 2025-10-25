<?php

namespace App\Models;

use CodeIgniter\Model;

use yidas\Model;

class Config extends Model
{
    protected $table            = 'tbl';
    protected $table      = 'config';
    protected $primaryKey = 'id';
    protected $timestamps = false;
}
