<?php

class Modul extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1'], true)) {
            redirect('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('modul');
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

        $this->load->view('header', $header);

        $this->load->view('setting/nav', $nav);
        $this->load->view('setting/modul/table', $data);
        $this->load->view('footer');
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

        $this->load->view('header', $header);

        $nav['act'] = 1;
        $this->load->view('setting/nav', $nav);
        $this->load->view('setting/modul/form', $data);
        $this->load->view('footer');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('modul');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('modul');
    }

    public function insert()
    {
        $this->modul_model->insert();
        redirect('modul');
    }

    public function update($id = '')
    {
        $this->modul_model->update($id);
        redirect('modul');
    }

    public function delete($id = '')
    {
        $this->modul_model->delete($id);
        redirect('modul');
    }

    public function delete_all()
    {
        $this->modul_model->delete_all();
        redirect('modul');
    }
}
