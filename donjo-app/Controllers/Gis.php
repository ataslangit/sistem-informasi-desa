<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Gis extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('config_model');
        $this->load->model('header_model');
        $this->load->model('penduduk_model');
        $this->load->model('plan_area_model');
        $this->load->model('plan_garis_model');
        $this->load->model('plan_lokasi_model');
        $this->load->model('user_model');

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            redirect('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['log'], $_SESSION['cari'], $_SESSION['filter'], $_SESSION['sex'], $_SESSION['warganegara'], $_SESSION['fisik'], $_SESSION['mental'], $_SESSION['menahun'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_id'], $_SESSION['status_penduduk'], $_SESSION['layer_penduduk'], $_SESSION['layer_keluarga'], $_SESSION['layer_desa'], $_SESSION['layer_wilayah'], $_SESSION['layer_area'], $_SESSION['layer_line'], $_SESSION['layer_point']);

        $_SESSION['layer_keluarga'] === 0;
        redirect('gis');
    }

    public function index()
    {
        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_SESSION['sex'])) {
            $data['sex'] = $_SESSION['sex'];
        } else {
            $data['sex'] = '';
        }

        if (isset($_SESSION['dusun'])) {
            $data['dusun']   = $_SESSION['dusun'];
            $data['list_rw'] = $this->penduduk_model->list_rw($data['dusun']);

            if (isset($_SESSION['rw'])) {
                $data['rw']      = $_SESSION['rw'];
                $data['list_rt'] = $this->penduduk_model->list_rt($data['dusun'], $data['rw']);

                if (isset($_SESSION['rt'])) {
                    $data['rt'] = $_SESSION['rt'];
                } else {
                    $data['rt'] = '';
                }
            } else {
                $data['rw'] = '';
            }
        } else {
            $data['dusun'] = '';
            $data['rw']    = '';
            $data['rt']    = '';
        }
        if (isset($_SESSION['agama'])) {
            $data['agama'] = $_SESSION['agama'];
        } else {
            $data['agama'] = '';
        }

        if (isset($_SESSION['layer_penduduk'])) {
            $data['layer_penduduk'] = $_SESSION['layer_penduduk'];
        } else {
            $data['layer_penduduk'] = 0;
        }

        if (isset($_SESSION['layer_keluarga'])) {
            $data['layer_keluarga'] = $_SESSION['layer_keluarga'];
        } else {
            $data['layer_keluarga'] = 0;
        }

        if (isset($_SESSION['layer_desa'])) {
            $data['layer_desa'] = $_SESSION['layer_desa'];
        } else {
            $data['layer_desa'] = 0;
        }

        if (isset($_SESSION['layer_wilayah'])) {
            $data['layer_wilayah'] = $_SESSION['layer_wilayah'];
        } else {
            $data['layer_wilayah'] = 0;
        }

        if (isset($_SESSION['layer_area'])) {
            $data['layer_area'] = $_SESSION['layer_area'];
        } else {
            $data['layer_area'] = 0;
        }

        if (isset($_SESSION['layer_line'])) {
            $data['layer_line'] = $_SESSION['layer_line'];
        } else {
            $data['layer_line'] = 0;
        }

        $data['layer_point'] = @$_SESSION['layer_point'];

        $data['list_dusun']      = $this->penduduk_model->list_dusun();
        $data['wilayah']         = $this->penduduk_model->list_wil();
        $data['list_agama']      = $this->penduduk_model->list_agama();
        $data['list_pendidikan'] = $this->penduduk_model->list_pendidikan();
        $data['desa']            = $this->config_model->get_data();
        $data['lokasi']          = $this->plan_lokasi_model->list_data();
        $data['garis']           = $this->plan_garis_model->list_data();
        $data['area']            = $this->plan_area_model->list_data();
        $data['penduduk']        = $this->penduduk_model->list_data_map();
        $data['keyword']         = $this->penduduk_model->autocomplete();
        $header                  = $this->header_model->get_data();

        view('gis/header', $header);
        view('gis/maps', $data);
        view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('gis');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('gis');
    }

    public function layer_penduduk()
    {
        $layer_penduduk = $this->input->post('layer_penduduk');
        if ($layer_penduduk === '') {
            $_SESSION['layer_penduduk'] = 0;
        } else {
            $_SESSION['layer_penduduk'] = 1;
            $_SESSION['layer_keluarga'] = 0;
        }
        redirect('gis');
    }

    public function layer_wilayah()
    {
        $layer_wilayah = $this->input->post('layer_wilayah');
        if ($layer_wilayah === '') {
            $_SESSION['layer_wilayah'] = 0;
        } else {
            $_SESSION['layer_wilayah'] = 1;
        }
        redirect('gis');
    }

    public function layer_area()
    {
        $layer_area = $this->input->post('layer_area');
        if ($layer_area === '') {
            $_SESSION['layer_area'] = 0;
        } else {
            $_SESSION['layer_area'] = 1;
        }
        redirect('gis');
    }

    public function layer_line()
    {
        $layer_line = $this->input->post('layer_line');
        if ($layer_line === '') {
            $_SESSION['layer_line'] = 0;
        } else {
            $_SESSION['layer_line'] = 1;
        }
        redirect('gis');
    }

    public function layer_point()
    {
        $layer_point = $this->input->post('layer_point');
        if ($layer_point === '') {
            $_SESSION['layer_point'] = 0;
        } else {
            $_SESSION['layer_point'] = 1;
        }
        redirect('gis');
    }

    public function layer_keluarga()
    {
        $layer_keluarga = $this->input->post('layer_keluarga');
        if ($layer_keluarga === '') {
            $_SESSION['layer_keluarga'] = 0;
        } else {
            $_SESSION['layer_keluarga'] = 1;
            $_SESSION['layer_penduduk'] = 0;
        }
        redirect('gis');
    }

    public function layer_desa()
    {
        $layer_desa = $this->input->post('layer_desa');
        if ($layer_desa === '') {
            $_SESSION['layer_desa'] = 0;
        } else {
            $_SESSION['layer_desa'] = 1;
        }
        redirect('gis');
    }

    public function sex()
    {
        $sex = $this->input->post('sex');
        if ($sex !== '') {
            $_SESSION['sex'] = $sex;
        } else {
            unset($_SESSION['sex']);
        }
        redirect('gis');
    }

    public function dusun()
    {
        $dusun = $this->input->post('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            unset($_SESSION['dusun']);
        }
        redirect('gis');
    }

    public function rw()
    {
        $rw = $this->input->post('rw');
        if ($rw !== '') {
            $_SESSION['rw'] = $rw;
        } else {
            unset($_SESSION['rw']);
        }
        redirect('gis');
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt !== '') {
            $_SESSION['rt'] = $rt;
        } else {
            unset($_SESSION['rt']);
        }
        redirect('gis');
    }

    public function agama()
    {
        $agama = $this->input->post('agama');
        if ($agama !== '') {
            $_SESSION['agama'] = $agama;
        } else {
            unset($_SESSION['agama']);
        }
        redirect('gis');
    }

    public function ajax_adv_search()
    {
        $data['dusun']       = $this->penduduk_model->list_dusun();
        $data['agama']       = $this->penduduk_model->list_agama();
        $data['pendidikan']  = $this->penduduk_model->list_pendidikan();
        $data['pekerjaan']   = $this->penduduk_model->list_pekerjaan();
        $data['form_action'] = site_url('gis/adv_search_proses');
        view('gis/ajax_adv_search_form', $data);
    }

    public function adv_search_proses()
    {
        $adv_search = $_POST;
        $i          = 0;

        while ($i++ < count($adv_search)) {
            $col[$i] = key($adv_search);
            next($adv_search);
        }
        $i = 0;

        while ($i++ < count($col)) {
            if ($adv_search[$col[$i]] === '') {
                unset($adv_search[$col[$i]]);
            } else {
                $_SESSION[$col[$i]] = $adv_search[$col[$i]];
            }
        }

        redirect('gis');
    }
}
