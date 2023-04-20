<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Config_model;

class Hom_desa extends BaseController
{
    /**
     * Menampilkan halaman view Identitas desa
     */
    public function index(): string
    {
        $configModel  = new Config_model();
        $data['main'] = $configModel->first();

        return view('admin/konfigurasi_form', $data);
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
        $this->config_model->insert();
        redirect('hom_desa');
    }

    public function update($id = '')
    {
        $this->config_model->update($id);
        redirect('hom_desa');
    }

    public function ajax_kantor_maps()
    {
        $data['desa']        = $this->config_model->get_data();
        $data['form_action'] = site_url('hom_desa/update_kantor_maps/');
        view('home/ajax_kantor_desa_maps', $data);
    }

    public function ajax_wilayah_maps()
    {
        $data['desa']        = $this->config_model->get_data();
        $data['form_action'] = site_url('hom_desa/update_wilayah_maps/');
        view('home/ajax_wilayah_desa_maps', $data);
    }

    public function update_kantor_maps()
    {
        $this->config_model->update_kantor();
        redirect('hom_desa');
    }

    public function update_wilayah_maps()
    {
        $this->config_model->update_wilayah();
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
