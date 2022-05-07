<?php

namespace App\Models;

use CodeIgniter\Model;

class Apis extends Model
{
    public function view($page = 'indeks')
    {
        if (! file_exists(APPPATH . '/views/apis/' . $page . '.php')) {
            echo $page;
        }
    }
}
