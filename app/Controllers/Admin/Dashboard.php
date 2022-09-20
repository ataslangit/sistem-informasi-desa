<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Config_model as ConfigModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        if (! in_array(session('sesi'), ['1', '2'], true)) {
            return redirect()->to('logout');
        }
    }

    /**
     * Halaman dashboard admin
     *
     * @return void
     */
    public function dashboard()
    {
        $_SESSION['delik'] = 0;
        $nav['act']        = 0;
        $header            = $this->header_model->get_data();
        $data['main']      = $configModel->get_data();

        echo view('header', $header);
        echo view('home/nav', $nav);
        echo view('home/konfigurasi_form', $data);
        echo view('footer');
    }

    public function about()
    {
        $nav['act'] = 2;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('home/nav', $nav);
        echo view('home/desa');
        echo view('footer');
    }

    public function insert()
    {
        $configModel = new ConfigModel();

        $configModel->insert1();

        return redirect()->to('admin/dashboard');
    }

    public function update($id = '')
    {
        $configModel = new ConfigModel();

        $configModel->update1($id);

        return redirect()->to('admin/dashboard');
    }

    public function ajax_kantor_maps()
    {
        $configModel = new ConfigModel();

        $data['desa']        = $configModel->get_data();
        $data['form_action'] = site_url('admin/pengaturan_desa/ajax_kantor_maps');
        echo view('home/ajax_kantor_desa_maps', $data);
    }

    public function ajax_wilayah_maps()
    {
        $configModel = new ConfigModel();

        $data['desa']        = $configModel->get_data();
        $data['form_action'] = site_url('admin/pengaturan_desa/ajax_wilayah_maps');
        echo view('home/ajax_wilayah_desa_maps', $data);
    }

    public function update_kantor_maps()
    {
        $configModel = new ConfigModel();

        $configModel->update_kantor();

        return redirect()->to('admin/dashboard');
    }

    public function update_wilayah_maps()
    {
        $configModel = new ConfigModel();

        $configModel->update_wilayah();

        return redirect()->to('admin/dashboard');
    }

    public function kosong_pend()
    {
        $configModel = new ConfigModel();

        $configModel->kosong_pend();

        return redirect()->to('admin/dashboard');
    }

    public function undelik()
    {
        if (isset($_SESSION['delik'])) {
            unset($_SESSION['delik']);
        }

        return redirect()->to('analisis_master/clear');
    }
}
