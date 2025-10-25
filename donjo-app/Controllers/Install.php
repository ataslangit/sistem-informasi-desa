<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Install as InstallLib;

class Install extends InstallController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);


        $this->load->model('header_model');
        $this->load->model('user_model');
        $this->load->model('config_model');
    }

    /**
     * View halaman installasi.
     *
     * @return string
     */
    public function index()
    {
        return view('install/index');
    }

    /**
     * Proses installasi database
     *
     * @todo Perbaiki proses installasi
     *
     * @return string|void
     */
    public function run()
    {
        $install = new InstallLib();
        $out     = $install->run();

        if (null === $out) {
            return redirect()->to('/');
        }

        return view('install/done', $out);
    }
}
