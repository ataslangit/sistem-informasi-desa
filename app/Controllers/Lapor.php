<?php

namespace App\Controllers;

class Lapor extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3'], true)) {
            redirect('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('lapor');
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
        $data['main']    = $this->web_komentar_model->list_data($o, $data['paging']->offset, $data['paging']->per_page, 2);
        $data['keyword'] = $this->web_komentar_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 0;

        echo view('header', $header);
        echo view('lapor/nav', $nav);
        echo view('lapor/table', $data);
        echo view('footer');
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

        $data['list_kategori'] = $this->web_komentar_model->list_kategori(1);

        $header = $this->header_model->get_data();

        $nav['act'] = 2;
        echo view('header', $header);
        echo view('web/spacer');
        echo view('web/nav', $nav);
        echo view('lapor/form', $data);
        echo view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('lapor');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('lapor');
    }

    public function insert()
    {
        $this->web_komentar_model->insert();
        redirect('lapor');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_komentar_model->update($id);
        redirect("lapor/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_komentar_model->delete($id);
        redirect("lapor/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_komentar_model->delete_all();
        redirect("lapor/index/{$p}/{$o}");
    }

    public function komentar_lock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 1);
        redirect('lapor/index/');
    }

    public function komentar_unlock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 2);
        redirect('lapor/index/');
    }
}
