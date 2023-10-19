<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Siteman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('config_model');
    }

    /**
     * Menampilkan halaman login
     */
    public function index(): string
    {
        $data = [
            'title' => 'Masuk',
            'desa'  => $this->config_model->get_data(),
        ];

        return view('siteman/login', $data);
    }

    public function auth()
    {
        $this->user_model->siteman();

        return redirect()->to('main');
    }

    public function login()
    {
        $this->user_model->logout();

        return redirect()->to('siteman');
    }
}
