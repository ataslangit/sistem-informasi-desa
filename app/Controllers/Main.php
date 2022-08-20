<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        return redirect()->to('first');
    }

    public function initial()
    {
        echo view('install');
    }

    public function install()
    {
        $out = $this->config_model->initial();
        echo view('init', $out);
    }

    public function init($out = null)
    {
        echo view('init', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = $this->header_model->get_config();
        echo view('siteman', $header);
    }

    public function logout()
    {
        $this->config_model->opt();
        $this->user_model->logout();
        $header = $this->header_model->get_config();
        echo view('siteman', $header);
    }
}
