<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Main extends BaseController
{
    /**
     * Tampil halaman depan
     *
     * @return string
     */
    public function index()
    {
        $artikelModel = new ArtikelModel();

        $data = [
            'artikel' => $artikelModel->ambilPos()->orderBy('tgl_upload desc')->paginate(5),
            'pager'   => $artikelModel->pager,
        ];

        return view('frontend/main', $data);
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
