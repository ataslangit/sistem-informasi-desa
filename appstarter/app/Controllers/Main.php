<?php

namespace App\Controllers;

class Main extends BaseController
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('header_model');
    //     $this->load->model('user_model');
    //     $this->load->model('config_model');
    // }

    public function index()
    {
        if (isset($_SESSION['siteman'])) {
            if (isset($_SESSION['sesi'])) {
                $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                switch ($grup) {
                    case '1':
                    case '2':
                        return redirect()->to('hom_desa');
                        break;

                    case '3':
                    case '4':
                        return redirect()->to('web');
                        break;

                    default:
                        if (isset($_SESSION['siteman'])) {
                            return redirect()->to('siteman');
                        }

                            return redirect()->to('first');

                        break;
                }
            }
        } else {
            return redirect()->to('first');
        }
    }

    public function initial()
    {
        $this->load->view('install');
    }

    public function init($out = null)
    {
        $this->load->view('init', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = $this->header_model->get_config();
        $this->load->view('siteman', $header);
    }

    public function logout()
    {
        $configModel = new \App\Models\Config_model();
        $configModel->opt();
        $this->user_model->logout();
        $header = $this->header_model->get_config();
        $this->load->view('siteman', $header);
    }
}
