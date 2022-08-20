<?php

namespace App\Controllers;

class Komentar extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3', '4'], true)) {
            return redirect()->to('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        return redirect()->to('komentar');
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

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('komentar/table', $data);
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
        echo view('komentar/form', $data);
        echo view('footer');
    }

    public function search()
    {
        $cari = $this->request->getPost('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }

        return redirect()->to('komentar');
    }

    public function filter()
    {
        $filter = $this->request->getPost('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }

        return redirect()->to('komentar');
    }

    public function insert()
    {
        $this->web_komentar_model->insert();

        return redirect()->to('komentar');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_komentar_model->update($id);

        return redirect()->to("komentar/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_komentar_model->delete($id);

        return redirect()->to("komentar/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_komentar_model->delete_all();

        return redirect()->to("komentar/index/{$p}/{$o}");
    }

    public function komentar_lock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 1);

        return redirect()->to('komentar/index/');
    }

    public function komentar_unlock($id = '')
    {
        $this->web_komentar_model->komentar_lock($id, 2);

        return redirect()->to('komentar/index/');
    }
}
