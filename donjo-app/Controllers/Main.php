<?php

namespace App\Controllers;

use App\Libraries\Install;

class Main extends BaseController
{
    public function __construct()
    {
        // $this->load->model('header_model');
        // $this->load->model('user_model');
        // $this->load->model('config_model');
    }

    public function index()
    {
        $install = new Install();

        if ($install->installed()) {
            if (isset($_SESSION['siteman'])) {
                if (isset($_SESSION['sesi'])) {
                    $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                    switch ($grup) {
                        case 1:
                            return redirect()->to('hom_desa');
                            break;

                        case 2:
                            return redirect()->to('hom_desa');
                            break;

                        case 3:
                            return redirect()->to('web');
                            break;

                        case 4:
                            return redirect()->to('web');
                            break;

                        default:
                            if (isset($_SESSION['siteman'])) {
                                return redirect()->to('siteman');
                            }

                            return redirect()->to('first');
                    }
                }
            } else {
                return redirect()->to('first');
            }
        } else {
            return redirect()->to('main/initial');
        }
    }

    public function initial()
    {
        echo view('install');
    }

    public function install()
    {
        $install = new Install();
        $out     = $install->run();

        if (null === $out) {
            return redirect()->to('/');
        }

        echo view('init', $out);
    }

    public function init($out = null)
    {
        echo view('init', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];
        echo view('siteman', $header);
    }

    public function logout()
    {
        $this->config_model->opt();
        $this->user_model->logout();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];

        echo view('siteman', $header);
    }
}
