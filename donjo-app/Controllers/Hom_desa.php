<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Hom_desa extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);


        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2') {
            return redirect()->to('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('config_model');
    }

    public function index()
    {
        $_SESSION['delik'] = 0;
        $nav['act']        = 0;
        $header            = $this->header_model->get_data();
        $data['main']      = $this->config_model->get_data();
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
        $this->config_model->insert2();
        return redirect()->to('hom_desa');
    }

    public function update($id = '')
    {
        $this->config_model->update2($id);
        return redirect()->to('hom_desa');
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
        return redirect()->to('hom_desa');
    }

    public function update_wilayah_maps()
    {
        $this->config_model->update_wilayah();
        return redirect()->to('hom_desa');
    }

    public function kosong_pend()
    {
        $this->config_model->kosong_pend();
        return redirect()->to('hom_desa');
    }

    public function undelik()
    {
        if (isset($_SESSION['delik'])) {
            unset($_SESSION['delik']);
        }
        return redirect()->to('analisis_master/clear');
    }
}
