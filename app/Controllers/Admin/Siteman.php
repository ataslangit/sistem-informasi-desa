<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Siteman extends BaseController
{
    /**
     * Menampilkan halaman login untuk pengurus website
     *
     * @return string
     */
    public function index()
    {
        $this->user_model->logout();
        $header = $this->header_model->get_config();

        if (! isset($_SESSION['siteman'])) {
            $_SESSION['siteman'] = 0;
        }
        $_SESSION['success']    = 0;
        $_SESSION['per_page']   = 10;
        $_SESSION['cari']       = '';
        $_SESSION['pengumuman'] = 0;
        $_SESSION['sesi']       = 'kosong';
        $_SESSION['timeout']    = 0;

        echo view('siteman', $header);
        $_SESSION['siteman'] = 0;
    }

    public function auth()
    {
        $this->user_model->siteman();

        return redirect()->to('main');
    }

    public function login()
    {
        $this->user_model->logout();

        return redirect()->to('siteman');
    }
}
