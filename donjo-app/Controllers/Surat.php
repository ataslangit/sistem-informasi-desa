<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Surat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }
        $this->load->model('config_model');
        $this->load->model('header_model');
        $this->load->model('penduduk_model');
        $this->load->model('surat_keluar_model');
        $this->load->model('surat_model');
    }

    public function index()
    {
        unset($_SESSION['nik'], $_SESSION['nik_ayah'], $_SESSION['nik_ibu']);

        $header                = $this->header_model->get_data();
        $data['menu_surat']    = $this->surat_model->list_surat();
        $data['menu_surat2']   = $this->surat_model->list_surat2();
        $data['surat_favorit'] = $this->surat_model->list_surat_fav();

        view('header', $header);
        $nav['act'] = 1;

        view('surat/nav', $nav);
        view('surat/format_surat', $data);
        view('footer');
    }

    public function panduan()
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $nav['act'] = 4;

        view('surat/nav', $nav);
        view('surat/panduan');
        view('footer');
    }

    public function form($url = '')
    {
        $data['url'] = $url;
        if (isset($_POST['nik'])) {
            $_SESSION['nik'] = $_POST['nik'];
        }

        if (isset($_POST['nik_ayah'])) {
            $_SESSION['nik_ayah'] = $_POST['nik_ayah'];
        }

        if (isset($_POST['nik_ibu'])) {
            $_SESSION['nik_ibu'] = $_POST['nik_ibu'];
        }

        if (isset($_SESSION['nik'])) {
            $data['individu']     = $this->surat_model->get_penduduk($_SESSION['nik']);
            $data['ayah']         = $this->surat_model->get_penduduk($_SESSION['nik_ayah']);
            $data['ibu']          = $this->surat_model->get_penduduk($_SESSION['nik_ibu']);
            $data['anggota']      = $this->surat_model->list_anggota($data['individu']['id_kk'], $data['individu']['nik']);
            $data['list_dokumen'] = $this->penduduk_model->list_dokumen($_SESSION['nik']);
        } else {
            $data['individu']     = null;
            $data['ayah']         = null;
            $data['ibu']          = null;
            $data['anggota']      = null;
            $data['list_dokumen'] = null;
        }
        $data['penduduk'] = $this->surat_model->list_penduduk();
        $data['pamong']   = $this->surat_model->list_pamong();

        $data['form_action']  = site_url("surat/cetak/{$url}");
        $data['form_action2'] = site_url("surat/doc/{$url}");
        $nav['act']           = 1;
        $header               = $this->header_model->get_data();
        view('header', $header);

        view('surat/nav', $nav);
        $this->load->view("surat/form/{$url}", $data);
        view('footer');
    }

    public function cetak($url = '')
    {
        $f = $url;
        $g = $_POST['pamong'];
        $u = $_SESSION['user'];
        $z = $_POST['nomor'];

        $id                       = $_POST['nik'];
        $data['input']            = $_POST;
        $data['tanggal_sekarang'] = tgl_indo(date('Y m d'));

        $data['data'] = $this->surat_model->get_data_surat($id);
        $data['ayah'] = $this->surat_model->get_data_suami($id);

        $data['pribadi'] = $this->surat_model->get_data_pribadi($id);
        $data['kk']      = $this->surat_model->get_data_kk($id);

        $data['desa']   = $this->config_model->get_data();
        $data['pamong'] = $this->surat_model->get_pamong($_POST['pamong']);

        $data['pengikut'] = $this->surat_model->pengikut();
        $this->surat_keluar_model->log_surat($f, $id, $g, $u, $z);
        view('surat/print/print_' . $url . '', $data);
    }

    public function doc($url = '')
    {
        $format = $this->surat_model->get_surat($url);
        $f      = $format['id'];
        $g      = $_POST['pamong'];
        $u      = $_SESSION['user'];
        $z      = $_POST['nomor'];

        $id = $_POST['nik'];
        $this->surat_keluar_model->log_surat($f, $id, $g, $u, $z);

        $this->surat_model->coba($url);
    }

    public function search()
    {
        $cari = $this->input->post('nik');
        if ($cari !== '') {
            redirect("surat/form/{$cari}");
        } else {
            redirect('surat');
        }
    }
}
