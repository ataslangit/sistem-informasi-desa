<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Analisis_master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('analisis_master_model');
        $this->load->model('analisis_import_model');
        $this->load->model('user_model');
        $this->load->model('header_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            redirect('siteman');
        }
        unset($_SESSION['submenu'], $_SESSION['asubmenu']);
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['state']);

        redirect('analisis_master');
    }

    public function index($p = 1, $o = 0)
    {
        unset($_SESSION['analisis_master'], $_SESSION['analisis_nama']);

        $data['p']  = $p;
        $data['o']  = $o;
        $nav['act'] = 1;

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

        if (isset($_SESSION['state'])) {
            $data['state'] = $_SESSION['state'];
        } else {
            $data['state'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']      = $this->analisis_master_model->paging($p, $o);
        $data['main']        = $this->analisis_master_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']     = $this->analisis_master_model->autocomplete();
        $data['list_subjek'] = $this->analisis_master_model->list_subjek();
        $header              = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav', $nav);
        view('analisis_master/table', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p']  = $p;
        $data['o']  = $o;
        $nav['act'] = 1;

        if ($id) {
            $data['analisis_master'] = $this->analisis_master_model->get_analisis_master($id);
            $data['form_action']     = site_url("analisis_master/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_master'] = null;
            $data['form_action']     = site_url('analisis_master/insert');
        }

        $data['list_kelompok'] = $this->analisis_master_model->list_kelompok();
        $data['list_analisis'] = $this->analisis_master_model->list_analisis_child();
        $header                = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav', $nav);
        view('analisis_master/form', $data);
        view('footer');
    }

    public function panduan()
    {
        $nav['act'] = 1;
        $header     = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav', $nav);
        view('analisis_master/panduan');
        view('footer');
    }

    public function import_analisis()
    {
        $header = $this->header_model->get_data();

        $nav['act']          = 1;
        $data['form_action'] = site_url('analisis_master/import');
        view('analisis_master/import', $data);
    }

    public function menu($id = '', $p = 0)
    {
        $_SESSION['analisis_master'] = $id;
        $data['analisis_master']     = $this->analisis_master_model->get_analisis_master($id);
        $_SESSION['analisis_nama']   = $data['analisis_master']['nama'];
        $da                          = $data['analisis_master'];
        $subjek                      = $da['subjek_tipe'];
        $_SESSION['subjek_tipe']     = $subjek;

        switch ($subjek) {
                case 1: $data['menu_respon'] = 'analisis_respon_penduduk'; $data['menu_laporan'] = 'analisis_laporan_penduduk'; break;

                case 2: $data['menu_respon'] = 'analisis_respon_keluarga'; $data['menu_laporan'] = 'analisis_laporan_keluarga'; break;

                case 3: $data['menu_respon'] = 'analisis_respon_rtm'; $data['menu_laporan'] = 'analisis_laporan_rtm'; break;

                case 4: $data['menu_respon'] = 'analisis_respon_kelompok'; $data['menu_laporan'] = 'analisis_laporan_kelompok'; break;

                default:redirect('analisis_master');
            }
        $data['menu_respon']  = 'analisis_respon';
        $data['menu_laporan'] = 'analisis_laporan';
        $header               = $this->header_model->get_data();

        //PATCH
        //if($p==1){
        $this->load->model('analisis_respon_model');
        $this->analisis_respon_model->pre_update();
        //}
        //----

        $nav['act'] = 1;
        view('header', $header);
        view('analisis_master/nav', $nav);
        view('analisis_master/menu', $data);
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
        redirect('analisis_master');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('analisis_master');
    }

    public function state()
    {
        $filter = $this->input->post('state');
        if ($filter !== 0) {
            $_SESSION['state'] = $filter;
        } else {
            unset($_SESSION['state']);
        }
        redirect('analisis_master');
    }

    public function insert()
    {
        $this->analisis_master_model->insert();
        redirect('analisis_master');
    }

    public function import()
    {
        $this->analisis_import_model->import_excel();
        redirect('analisis_master');
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->analisis_master_model->update($id);
        redirect("analisis_master/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->analisis_master_model->delete($id);
        redirect("analisis_master/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->analisis_master_model->delete_all();
        redirect("analisis_master/index/{$p}/{$o}");
    }
}
