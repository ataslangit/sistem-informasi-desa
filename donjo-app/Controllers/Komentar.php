<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Komentar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_komentar_model');
        $this->load->model('KategoriModel', 'kategori_model');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('komentar');
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

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->web_komentar_model->paging($p, $o);
        $data['main']    = $this->web_komentar_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->web_komentar_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 2;

        view('header', $header);
        view('web/nav', $nav);
        view('komentar/table', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['komentar']    = $this->web_komentar_model->get_komentar($id);
            $data['form_action'] = site_url("komentar/update/{$id}/{$p}/{$o}");
        } else {
            $data['komentar']    = null;
            $data['form_action'] = site_url('komentar/insert');
        }

        $data['list_kategori'] = $this->kategori_model->getByType(1);

        $header = $this->header_model->get_data();

        $nav['act'] = 2;
        view('header', $header);
        view('web/spacer');
        view('web/nav', $nav);
        view('komentar/form', $data);
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
        redirect('komentar');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('komentar');
    }

    public function insert()
    {
        $this->web_komentar_model->insert();
        redirect('komentar');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_komentar_model->update($id);
        redirect("komentar/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_komentar_model->delete($id);
        redirect("komentar/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_komentar_model->delete_all();
        redirect("komentar/index/{$p}/{$o}");
    }

    public function komentar_lock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 1);
        redirect("komentar/index/{$p}/{$o}");
    }

    public function komentar_unlock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 2);
        redirect("komentar/index/{$p}/{$o}");
    }
}
