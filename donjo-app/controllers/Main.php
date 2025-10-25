<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Install;

class Main extends BaseController
{
    private $user_model;
    private $config_model;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);


        // $this->load->model('header_model');
        // $this->load->model('user_model');
        $this->user_model = new \App\Models\User_model();
        // $this->load->model('config_model');
        $this->config_model = new \App\Models\Config_model();
    }

    public function index()
    {
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
                    } else {
                        return redirect()->to('first');
                    }
                }
            }
        } else {
            return redirect()->to('first');
        }
    }

    public function initial()
    {
        view('install');
    }

    public function install()
    {
        $install = new Install();
        $out     = $install->run();

        if (null === $out) {
            return redirect()->to('/');
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
