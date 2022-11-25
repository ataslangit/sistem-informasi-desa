<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Surat_master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('surat_master_model');
        $this->load->model('user_model');
        $this->load->model('header_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            redirect('siteman');
        }
    }

    public function clear($id = 0)
    {
        $_SESSION['per_page'] = 20;
        $_SESSION['surat']    = $id;
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['tipe'], $_SESSION['kategori']);

        redirect('surat_master');
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->surat_master_model->paging($p, $o);
        $data['main']    = $this->surat_master_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->surat_master_model->autocomplete();
        $header          = $this->header_model->get_data();

        view('header', $header);
        $nav['act'] = 3;
        view('surat/nav', $nav);
        view('surat_master/table', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['surat_master'] = $this->surat_master_model->get_surat_format($id);
            $data['form_action']  = site_url("surat_master/update/{$p}/{$o}/{$id}");
        } else {
            $data['surat_master'] = null;
            $data['form_action']  = site_url('surat_master/insert');
        }

        $header = $this->header_model->get_data();

        view('header', $header);
        $nav['act'] = 3;
        view('surat/nav', $nav);
        view('surat_master/form', $data);
        view('footer');
    }

    public function form_upload($p = 1, $o = 0, $url = '')
    {
        $data['form_action'] = site_url("surat_master/upload/{$p}/{$o}/{$url}");
        view('surat_master/ajax-upload', $data);
    }

    public function atribut($id = '')
    {
        $data['surat_master'] = $this->surat_master_model->get_surat_format($id);
        $data['surat']        = $this->surat_master_model->get_surat_format();
        $data['main']         = $this->surat_master_model->list_atribut($id);

        $header = $this->header_model->get_data();

        view('header', $header);
        $nav['act'] = 3;
        view('surat/nav', $nav);
        view('surat_master/atribut/table', $data);
        view('footer');
    }

    public function form_parameter($in = '', $id = '')
    {
        if ($id) {
            $data['analisis_parameter'] = $this->surat_master_model->get_analisis_parameter($id);
            $data['form_action']        = site_url("surat_master/p_update/{$in}/{$id}");
        } else {
            $data['analisis_parameter'] = null;
            $data['form_action']        = site_url("surat_master/p_insert/{$in}");
        }

        $data['surat']        = $this->surat_master_model->get_surat();
        $data['surat_master'] = $this->surat_master_model->get_surat_master($in);

        //	view('header', $header);
        //	view('surat/nav');
        view('surat_master/atribut/ajax_form', $data);
        //	view('footer');
    }

    public function menu($id = '')
    {
        $data['surat_master'] = $this->surat_master_model->get_surat_master($id);

        $header = $this->header_model->get_data();

        view('header', $header);
        view('surat/nav');
        view('surat_master/menu', $data);
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
        redirect('surat_master');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('surat_master');
    }

    public function tipe()
    {
        $filter = $this->input->post('tipe');
        if ($filter !== 0) {
            $_SESSION['tipe'] = $filter;
        } else {
            unset($_SESSION['tipe']);
        }
        redirect('surat_master');
    }

    public function kategori()
    {
        $filter = $this->input->post('kategori');
        if ($filter !== 0) {
            $_SESSION['kategori'] = $filter;
        } else {
            unset($_SESSION['kategori']);
        }
        redirect('surat_master');
    }

    public function insert()
    {
        $this->surat_master_model->insert();
        redirect('surat_master');
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->surat_master_model->update($id);
        redirect("surat_master/index/{$p}/{$o}");
    }

    public function upload($p = 1, $o = 0, $url = '')
    {
        $this->surat_master_model->upload($url);
        redirect("surat_master/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->surat_master_model->delete($id);
        redirect("surat_master/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->surat_master_model->delete_all();
        redirect("surat_master/index/{$p}/{$o}");
    }

    public function p_insert($in = '')
    {
        $this->surat_master_model->p_insert($in);
        redirect("surat_master/atribut/{$in}");
    }

    public function p_update($in = '', $id = '')
    {
        $this->surat_master_model->p_update($id);
        redirect("surat_master/atribut/{$in}");
    }

    public function p_delete($in = '', $id = '')
    {
        $this->surat_master_model->p_delete($id);
        redirect("surat_master/atribut/{$in}");
    }

    public function p_delete_all()
    {
        $this->surat_master_model->p_delete_all();
        redirect("surat_master/atribut/{$in}");
    }

    public function lock($id = 0, $k = 0)
    {
        $this->surat_master_model->lock($id, $k);
        redirect('surat_master');
    }

    public function favorit($id = 0, $k = 0)
    {
        $this->surat_master_model->favorit($id, $k);
        redirect('surat_master');
    }
}
