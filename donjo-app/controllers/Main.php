<?php

use App\Libraries\Install;

class Main extends BaseController
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
        if (isset($_SESSION['siteman'])) {
            if (isset($_SESSION['sesi'])) {
                $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

                switch ($grup) {
                    case 1: redirect('hom_desa');
                        break;

                    case 2: redirect('hom_desa');
                        break;

                    case 3: redirect('web');
                        break;

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
    }

    /**
     * View halaman install
     *
     * @return string
     */
    public function initial()
    {
        return view('install/index');
    }

    public function install()
    {
        $install = new Install();
        $out     = $install->run();

        if (null === $out) {
            redirect(route_to('index'));
        }

        view('install/done', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];
        view('siteman', $header);
    }

    public function logout()
    {
        $this->config_model->opt();
        $this->user_model->logout();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];

        view('siteman', $header);
    }
}
