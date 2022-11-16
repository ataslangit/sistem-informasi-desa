<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Data_persil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2') {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('config_model');
        $this->load->model('data_persil_model');
        $this->load->model('penduduk_model');
    }

    public function clear()
    {
        unset($_SESSION['cari']);
        redirect('data_persil');
    }

    public function index($page = 1)
    {
        $header = $this->header_model->get_data();
        view('header', $header);

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        $data['desa']              = $this->config_model->get_data();
        $data['persil']            = $this->data_persil_model->list_persil('', 0, $page);
        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        $data['keyword']           = $this->data_persil_model->autocomplete();
        view('data_persil/persil', $data);
        view('footer');
    }

    public function import()
    {
        $data['form_action'] = site_url('data_persil/import_proses');
        view('data_persil/import', $data);
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('data_persil');
    }

    public function detail($id = 0)
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['persil_detail'] = $this->data_persil_model->get_persil($id);
        if ($id > 0) {
            $data['pemilik'] = $this->data_persil_model->get_penduduk($data['persil_detail']['nik']);
        } else {
            $data['pemilik'] = false;
        }
        $data['persil_lokasi']     = $this->data_persil_model->list_dusunrwrt();
        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();

        view('data_persil/detail', $data);
        view('footer');
    }

    public function create($id = 0)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');

        $header = $this->header_model->get_data();
        view('header', $header);
        $data['penduduk']      = $this->data_persil_model->list_penduduk();
        $data['persil_detail'] = $this->data_persil_model->get_persil($id);
        if ($id > 0) {
            $data['pemilik'] = $this->data_persil_model->get_penduduk($data['persil_detail']['nik']);
        } else {
            $data['pemilik'] = false;
        }
        if (isset($_POST['nik'])) {
            $data['pemilik'] = $this->data_persil_model->get_penduduk($_POST['nik']);
        }

        $data['persil_lokasi'] = $this->data_persil_model->list_dusunrwrt();

        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        view('data_persil/create', $data);
        view('footer');
    }

    public function create_ext($id = 0)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');

        $header = $this->header_model->get_data();
        view('header', $header);
        $data['penduduk']      = $this->data_persil_model->list_penduduk();
        $data['persil_detail'] = $this->data_persil_model->get_persil($id);

        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        view('data_persil/create_ext', $data);
        view('footer');
    }

    public function simpan_persil($page = 1)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['hasil']  = $this->data_persil_model->simpan_persil();
        $data['persil'] = $this->data_persil_model->list_persil(0, $page);

        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        redirect('data_persil/clear');
        view('data_persil/persil', $data);
        view('footer');
    }

    public function jenis($apa = 0, $page = 1)
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        $data['persil']            = $this->data_persil_model->list_persil('jenis', $apa, $page);
        view('data_persil/persil', $data);
        view('footer');
    }

    public function peruntukan($apa = '', $page = 1)
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['persil_peruntukan'] = $this->data_persil_model->list_persil_peruntukan();
        $data['persil_jenis']      = $this->data_persil_model->list_persil_jenis();
        $data['persil']            = $this->data_persil_model->list_persil('peruntukan', $apa, $page);

        view('data_persil/persil', $data);
        view('footer');
    }

    public function persil_jenis($id = 0)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['id'] = $id;
        if ($this->form_validation->run() === false) {
            $data['persil_peruntukan']   = $this->data_persil_model->list_persil_peruntukan();
            $data['persil_jenis']        = $this->data_persil_model->list_persil_jenis();
            $data['persil_jenis_detail'] = $this->data_persil_model->get_persil_jenis($id);
            $data['hasil']               = false;
            view('data_persil/persil_jenis', $data);
        } else {
            $data['hasil']               = $this->data_persil_model->update_persil_jenis($id);
            $data['persil_peruntukan']   = $this->data_persil_model->list_persil_peruntukan();
            $data['persil_jenis']        = $this->data_persil_model->list_persil_jenis();
            $data['persil_jenis_detail'] = $this->data_persil_model->get_persil_jenis($id);
            view('data_persil/persil_jenis', $data);
        }
        view('footer');
    }

    public function hapus_persil_jenis($id)
    {
        $this->data_persil_model->hapus_jenis($id);
        redirect('data_persil/persil_jenis');
    }

    public function persil_peruntukan($id = 0)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['id'] = $id;
        if ($this->form_validation->run() === false) {
            $data['persil_peruntukan']        = $this->data_persil_model->list_persil_peruntukan();
            $data['persil_jenis']             = $this->data_persil_model->list_persil_jenis();
            $data['persil_peruntukan_detail'] = $this->data_persil_model->get_persil_peruntukan($id);
            $data['hasil']                    = false;
            view('data_persil/persil_peruntukan', $data);
        } else {
            $data['hasil']                    = $this->data_persil_model->update_persil_peruntukan($id);
            $data['persil_peruntukan']        = $this->data_persil_model->list_persil_peruntukan();
            $data['persil_jenis']             = $this->data_persil_model->list_persil_jenis();
            $data['persil_peruntukan_detail'] = $this->data_persil_model->get_persil_peruntukan($id);
            view('data_persil/persil_peruntukan', $data);
        }
        view('footer');
    }

    public function hapus_persil_peruntukan($id)
    {
        $this->data_persil_model->hapus_peruntukan($id);
        redirect('data_persil/persil_peruntukan');
    }

    public function hapus($id)
    {
        $this->data_persil_model->hapus_persil($id);
        redirect('data_persil');
    }

    public function import_proses()
    {
        $this->load->model('import_model');
        $this->import_model->persil();
        redirect('data_persil');
    }
}
