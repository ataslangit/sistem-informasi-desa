<?php

namespace App\Controllers;

// use App\Libraries\Install;
use Kenjis\CI3Compatible\Core\CI_Controller;

class Install extends CI_Controller
{
    public function index(): string
    {
        return view('install');
    }
}
