<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Hom_desa extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup === '1') {
            return;
        }
        if ($grup === '2') {
            return;
        }
        redirect('siteman');
    }

    public function index()
    {
        $config = new Config();

        $_SESSION['delik'] = 0;
        $nav['act']        = 0;
        $header            = $this->header_model->get_data();
        $data['main']      = $config->get_data();
        view('header', $header);
        view('home/nav', $nav);
        view('home/konfigurasi_form', $data);
        view('footer');
    }

    public function about()
    {
        $nav['act'] = 2;
        $header     = $this->header_model->get_data();
        view('header', $header);
        view('home/nav', $nav);
        view('home/desa');
        view('footer');
    }

    public function insert()
    {
        $config = new Config();

        $config->insert($_POST);

        redirect('hom_desa');
    }

    public function update($id = '')
    {
        $this->config_model->update($id);
        redirect('hom_desa');
    }

    public function ajax_kantor_maps()
    {
        $config = new Config();

        $data['desa']        = $config->get_data();
        $data['form_action'] = site_url('hom_desa/update_kantor_maps/');
        view('home/ajax_kantor_desa_maps', $data);
    }

    public function ajax_wilayah_maps()
    {
        $config = new Config();

        $data['desa']        = $config->get_data();
        $data['form_action'] = site_url('hom_desa/update_wilayah_maps/');
        view('home/ajax_wilayah_desa_maps', $data);
    }

    public function update_kantor_maps()
    {
        $config = new Config();

        $config->update_(1, $_POST);

        redirect('hom_desa');
    }

    public function update_wilayah_maps()
    {
        $config = new Config();

        $config->update_(1, $_POST);

        redirect('hom_desa');
    }

    public function kosong_pend()
    {
        $this->config_model->kosong_pend();
        redirect('hom_desa');
    }

    public function undelik()
    {
        if (isset($_SESSION['delik'])) {
            unset($_SESSION['delik']);
        }
        redirect('analisis_master/clear');
    }
}
