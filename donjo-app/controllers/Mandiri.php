<?php

class Mandiri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2'], true)) {
            redirect('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('mandiri');
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
        $data['paging']   = $this->mandiri_model->paging($p, $o);
        $data['main']     = $this->mandiri_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']  = $this->mandiri_model->autocomplete();

        $header     = $this->header_model->get_data();
        $nav['act'] = 1;
        $this->load->view('header', $header);

        $this->load->view('lapor/nav', $nav);
        $this->load->view('mandiri/mandiri', $data);
        $this->load->view('footer');
    }

    public function ajax_pin($p = 1, $o = 0, $id = 0)
    {
        $data['penduduk']    = $this->mandiri_model->list_penduduk();
        $data['form_action'] = site_url("mandiri/insert/{$id}");
        $this->load->view('mandiri/ajax_pin', $data);
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('mandiri');
    }

    public function filter()
    {
        $filter = $this->input->post('nik');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('mandiri/perorangan');
    }

    public function nik()
    {
        $nik = $this->input->post('nik');
        if ($nik !== 0) {
            $_SESSION['nik'] = $_POST['nik'];
        } else {
            unset($_SESSION['nik']);
        }
        redirect('mandiri/perorangan');
    }

    public function insert()
    {
        $pin             = $this->mandiri_model->insert();
        $_SESSION['pin'] = $pin;
        redirect('mandiri');
    }

    public function ajax_pin_show($pin = '')
    {
        redirect('mandiri');
    }
}
