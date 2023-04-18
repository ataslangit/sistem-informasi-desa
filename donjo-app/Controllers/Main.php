<?php

namespace App\Controllers;

use App\Libraries\Install;
use App\Models\Config_model;
use App\Models\User_model;

class Main extends BaseController
{
    /**
     * View halaman instalasi pertama
     */
    public function initial()
    {
        return view('install');
    }

    public function install()
    {
        $install = new Install();
        $out     = $install->run();

        if (null === $out) {
            redirect('/');
        }

        view('init', $out);
    }

    public function init($out = null)
    {
        view('init', $out);
    }

    public function auth()
    {
        $userModel   = new User_model();
        $configModel = new Config_model();

        $userModel->login();
        $header = [
            'desa' => $configModel->get_data(),
        ];
        view('siteman', $header);
    }

    public function logout()
    {
        $userModel   = new User_model();
        $configModel = new Config_model();

        $configModel->opt();
        $userModel->logout();
        $header = [
            'desa' => $configModel->get_data(),
        ];

        view('siteman', $header);
    }
}
