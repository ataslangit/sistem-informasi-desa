<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller as BaseController;

class Modul extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('modul_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            return redirect()->to('siteman');
        }
        $this->load->model('header_model');
    }

    public function clear()
    {
        session()->remove(['cari', 'filter']);

        return redirect()->to('modul');
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
        $data['main']    = $this->modul_model->list_data();
        $data['keyword'] = $this->modul_model->autocomplete();
        $nav['act']      = 1;
        $header          = $this->header_model->get_data();

        echo view('header', $header);
        echo view('setting/nav', $nav);
        echo view('setting/modul/table', $data);
        echo view('footer');
    }

    public function form($id = '')
    {
        if ($id) {
            $data['modul']       = $this->modul_model->get_data($id);
            $data['form_action'] = site_url("modul/update/{$id}");
        } else {
            $data['modul']       = null;
            $data['form_action'] = site_url('modul/insert');
        }

        $header = $this->header_model->get_data();

        echo view('header', $header);

        $nav['act'] = 1;
        echo view('setting/nav', $nav);
        echo view('setting/modul/form', $data);
        echo view('footer');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            session()->remove('filter');
        }

        return redirect()->to('modul');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            session()->remove('cari');
        }

        return redirect()->to('modul');
    }

    public function insert()
    {
        $this->modul_model->insert();

        return redirect()->to('modul');
    }

    public function update($id = '')
    {
        $this->modul_model->update($id);

        return redirect()->to('modul');
    }

    public function delete($id = '')
    {
        $this->modul_model->delete($id);

        return redirect()->to('modul');
    }

    public function delete_all()
    {
        $this->modul_model->delete_all();

        return redirect()->to('modul');
    }
}
