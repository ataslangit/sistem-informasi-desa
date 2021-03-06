<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2'], true)) {
            redirect('siteman');
        }
    }

    /**
     * Redirect ke halaman dashboard
     *
     * @return void
     */
    public function index()
    {
        return redirect('admin/dashboard', 'refresh', 301);
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
        $data['main']      = $this->config_model->get_data();

        $this->load->view('header', $header);
        $this->load->view('home/nav', $nav);
        $this->load->view('home/konfigurasi_form', $data);
        $this->load->view('footer');
    }

    public function about()
    {
        $nav['act'] = 2;
        $header     = $this->header_model->get_data();
        $this->load->view('header', $header);
        $this->load->view('home/nav', $nav);
        $this->load->view('home/desa');
        $this->load->view('footer');
    }

    public function insert()
    {
        $this->config_model->insert();
        redirect('admin/dashboard');
    }

    public function update($id = '')
    {
        $this->config_model->update($id);

        redirect('admin/dashboard');
    }

    public function ajax_kantor_maps()
    {
        $data['desa']        = $this->config_model->get_data();
        $data['form_action'] = site_url('admin/pengaturan_desa/ajax_kantor_maps');
        $this->load->view('home/ajax_kantor_desa_maps', $data);
    }

    public function ajax_wilayah_maps()
    {
        $data['desa']        = $this->config_model->get_data();
        $data['form_action'] = site_url('admin/pengaturan_desa/ajax_wilayah_maps');
        $this->load->view('home/ajax_wilayah_desa_maps', $data);
    }

    public function update_kantor_maps()
    {
        $this->config_model->update_kantor();
        redirect('admin/dashboard');
    }

    public function update_wilayah_maps()
    {
        $this->config_model->update_wilayah();
        redirect('admin/dashboard');
    }

    public function kosong_pend()
    {
        $this->config_model->kosong_pend();
        redirect('admin/dashboard');
    }

    public function undelik()
    {
        if (isset($_SESSION['delik'])) {
            unset($_SESSION['delik']);
        }
        redirect('analisis_master/clear');
    }
}
