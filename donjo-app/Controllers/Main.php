<?php

namespace App\Controllers;

use App\Libraries\Install;
use Kenjis\CI3Compatible\Core\CI_Controller;

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('header_model');
        $this->load->model('user_model');
        $this->load->model('config_model');
    }

    public function index()
    {
        $install = new Install();

        if ($install->cek()) {
            if (isset($_SESSION['siteman'])) {
                if (isset($_SESSION['sesi'])) {
                    $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                    switch ($grup) {
                        case 1: return redirect()->to('hom_desa');
                            break;

                        case 2: return redirect()->to('hom_desa');
                            break;

                        case 3: return redirect()->to('web');
                            break;

                        case 4: return redirect()->to('web');
                            break;

                        default: if (isset($_SESSION['siteman'])) {
                            return redirect()->to('siteman');
                        }

                            return redirect()->to('first');
                    }
                }
            } else {
                return redirect()->to('first');
            }
        } else {
            return redirect()->route('install.view');
        }
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
