<?php

use App\Libraries\Install;

/**
 * Digunakan untuk cek instalasi sistem.
 * Jika belum instal maka akan diarahkan ke halaman install.
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $install = new Install();

        if (! $install->cek()) {
            return redirect('install');
        }
    }
}

/**
 * Sebagai Base Controller untuk semua controller.
 */
class BaseController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

/**
 * Sebagai middleware untuk halaman install.
 */
class InstallController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $install = new Install();

        if ($install->cek()) {
            return redirect('/');
        }
    }
}
