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
 * Sebagai Base Controller untuk siteman.
 */
class BaseController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['siteman'])) {
            return redirect('first');
        }
    }
}

/**
 * Sebagai Base Controller untuk halaman publik.
 */
class PublicController extends MY_Controller
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
