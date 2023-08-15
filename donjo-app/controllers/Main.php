<?php

use App\Libraries\Install;

class Main extends CI_Controller
{
    public function index()
    {
        $install = new Install();

        if ($install->cek()) {
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
        } else {
            return $this->initial();
        }
    }

    /**
     * View halaman instalasi pertama
     */
    public function initial()
    {
        view('install');
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
