<?php

namespace App\Controllers;

use App\Libraries\Install;
use App\Models\Config_model;
use App\Models\User_model;

class Main extends BaseController
{
    public function index()
    {
        $install   = new Install();
        $userModel = new User_model();

        if ($install->cek()) {
            if (isset($_SESSION['siteman'])) {
                if (isset($_SESSION['sesi'])) {
                    $grup = $userModel->sesi_grup($_SESSION['sesi']);

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
