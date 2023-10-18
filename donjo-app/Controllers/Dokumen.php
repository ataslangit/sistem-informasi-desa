<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3' && $grup !== '4') {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_dokumen_model');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('dokumen');
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

        $data['paging']  = $this->web_dokumen_model->paging($p, $o);
        $data['main']    = $this->web_dokumen_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->web_dokumen_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 4;

        view('header', $header);
        view('web/nav', $nav);
        view('dokumen/table', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['dokumen']     = $this->web_dokumen_model->get_dokumen($id);
            $data['form_action'] = site_url("dokumen/update/{$id}/{$p}/{$o}");
        } else {
            $data['dokumen']     = null;
            $data['form_action'] = site_url('dokumen/insert');
        }

        $header = $this->header_model->get_data();

        $nav['act'] = 4;
        view('header', $header);
        view('web/nav', $nav);
        view('dokumen/form', $data);
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
        redirect('dokumen');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('dokumen');
    }

    public function insert()
    {
        $this->web_dokumen_model->insert();
        redirect('dokumen');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_dokumen_model->update($id);
        redirect("dokumen/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_dokumen_model->delete($id);
        redirect("dokumen/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_dokumen_model->delete_all();
        redirect("dokumen/index/{$p}/{$o}");
    }

    public function dokumen_lock($id = '')
    {
        $this->web_dokumen_model->dokumen_lock($id, 1);
        redirect("dokumen/index/{$p}/{$o}");
    }

    public function dokumen_unlock($id = '')
    {
        $this->web_dokumen_model->dokumen_lock($id, 2);
        redirect("dokumen/index/{$p}/{$o}");
    }
}
