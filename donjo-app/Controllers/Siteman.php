<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Siteman extends BaseController
{
    public function index()
    {
        $config = new Config();

        $this->user_model->logout();
        $header = [
            'desa' => $config->get_data(),
        ];

        if (! isset($_SESSION['siteman'])) {
            $_SESSION['siteman'] = 0;
        }
        $_SESSION['success']    = 0;
        $_SESSION['per_page']   = 10;
        $_SESSION['cari']       = '';
        $_SESSION['pengumuman'] = 0;
        $_SESSION['sesi']       = 'kosong';
        $_SESSION['timeout']    = 0;

        view('siteman', $header);
        $_SESSION['siteman'] = 0;
    }

    public function auth()
    {
        $this->user_model->siteman();

        return redirect('main');
    }

    public function login()
    {
        $this->user_model->logout();
        redirect('siteman');
    }
}
