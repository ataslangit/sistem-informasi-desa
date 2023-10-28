<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Install extends CI_Controller
{
    /**
     * Menampilkan halaman install
     */
    public function index(): string
    {
        return view('install/index');
    }
}
