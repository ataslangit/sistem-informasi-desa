<?php

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
        $out = $this->config_model->install();
        if ($out === 1) {
            if (isset($_SESSION['siteman'])) {
                $this->load->model('user_model');
                if (isset($_SESSION['sesi'])) {
                    $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                    switch ($grup) {
                        case 1: redirect('hom_desa'); break;

                        case 2: redirect('hom_desa'); break;

                        case 3: redirect('web'); break;

                        case 4: redirect('web'); break;

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
            redirect('main/initial');
        }
    }

    public function initial()
    {
        $this->load->view('install');
    }

    public function install()
    {
        $out = $this->config_model->initial();
        $this->load->view('init', $out);
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
        $this->config_model->opt();
        $this->user_model->logout();
        $header = $this->header_model->get_config();
        $this->load->view('siteman', $header);
    }
}
