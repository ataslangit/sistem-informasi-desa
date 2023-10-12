<?php

namespace App\Controllers;

use App\Libraries\Install;
use App\Models\Config;

class Main extends BaseController
{
    public function index()
    {
        $install = new Install();

        if ($install->cek()) {
            if (isset($_SESSION['siteman'])) {
                if (isset($_SESSION['sesi'])) {
                    $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                    switch ($grup) {
                        case 1:
                        case 2: redirect('hom_desa');
                            break;

                        case 3:
                        case 4: redirect('web');
                            break;

                        default: if (isset($_SESSION['siteman'])) {
                            redirect('siteman');
                        } else {
                            redirect('first');
                        }
                    }
                }
            } else {
                redirect('first');
            }
        } else {
            return $this->initial();
        }
    }

    /**
     * View halaman instalasi pertama
     */
    public function initial()
    {
        $data = [
            'title'     => 'Instal SID',
            'bodyClass' => 'instal',
        ];

        return view('install/index', $data);
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
        $config = new Config();

        $this->user_model->login();
        $header = [
            'desa' => $config->get_data(),
        ];
        view('siteman', $header);
    }

    public function logout()
    {
        $config = new Config();

        $this->config_model->opt();
        $this->user_model->logout();
        $header = [
            'desa' => $config->get_data(),
        ];

        view('siteman', $header);
    }
}
