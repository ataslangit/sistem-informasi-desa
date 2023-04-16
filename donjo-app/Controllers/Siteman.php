<?php

namespace App\Controllers;

use App\Models\Config_model;
use App\Models\User_model;

class Siteman extends BaseController
{
    public function index()
    {
        // $userModel = new User_model();
        $configModel = new Config_model();

        // $userModel->logout();
        $header = [
            'desa' => $configModel->get_data(),
        ];

        // if (! isset($_SESSION['siteman'])) {
        //     $_SESSION['siteman'] = 0;
        // }
        // $_SESSION['success']    = 0;
        // $_SESSION['per_page']   = 10;
        // $_SESSION['cari']       = '';
        // $_SESSION['pengumuman'] = 0;
        // $_SESSION['sesi']       = 'kosong';
        // $_SESSION['timeout']    = 0;
        // $_SESSION['siteman'] = 0;

        return view('siteman', $header);
    }

    public function auth()
    {
        $userModel = new User_model();

        $userModel->siteman();

        return redirect('main');
    }

    public function login()
    {
        $userModel = new User_model();

        $userModel->logout();
        redirect('siteman');
    }
}
