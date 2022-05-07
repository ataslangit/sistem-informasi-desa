<?php

namespace App\Controllers;

class First extends BaseController
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     mandiri_timeout();

    //     $this->load->model('header_model');
    //     $this->load->model('config_model');
    //     $this->load->model('first_keluarga_m');
    //     $this->load->model('first_m');
    //     $this->load->model('first_artikel_m');
    //     $this->load->model('first_gallery_m');
    //     $this->load->model('first_menu_m');
    //     $this->load->model('first_penduduk_m');
    //     $this->load->model('penduduk_model');
    //     $this->load->model('surat_model');
    //     $this->load->model('surat_keluar_model');
    // }

    public function auth()
    {
        $firstModel = new \App\Models\First_m();

        if ($_SESSION['mandiri_wait'] !== 1) {
            $firstModel->siteman();
        }
        if ($_SESSION['mandiri'] === 1) {
            redirect('first/mandiri/1/1');
        } else {
            redirect('first');
        }
    }

    public function mobile($user = '', $pass = '')
    {
        $firstModel = new \App\Models\First_m();

        return $firstModel->m_siteman();
    }

    public function logout()
    {
        $firstModel = new \App\Models\First_m();

        $firstModel->logout();
        redirect('first');
    }

    public function ganti()
    {
        $firstModel = new \App\Models\First_m();

        $firstModel->ganti();
        redirect('first');
    }

    public function index($p = 1)
    {
        $firstModel         = new \App\Models\First_m();
        $firstMenuModel     = new \App\Models\First_menu_m();
        $firstArtikelModel  = new \App\Models\First_artikel_m();
        $firstGalleryModel  = new \App\Models\First_gallery_m();
        $firstPendudukModel = new \App\Models\First_penduduk_m();
        $configModel        = new \App\Models\Config_model();

        $data['p']             = $p;
        $data['desa']          = $configModel->findAll();
        $data['menu_atas']     = [];
        $data['menu_kiri']     = [];
        $data['headline']      = [];
        $data['teks_berjalan'] = [];

        $data['paging']  = [];
        $data['artikel'] = [];

        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['komen']  = $firstArtikelModel->komentar_show();
        $data['agenda'] = $firstArtikelModel->agenda_show();
        $data['slide']  = $firstArtikelModel->slide_show();

        $data['stat']        = $firstPendudukModel->list_data(4);
        $data['sosmed']      = $firstArtikelModel->list_sosmed();
        $data['w_gal']       = $firstGalleryModel->gallery_widget();
        $data['w_cos']       = $firstArtikelModel->cos_widget();
        $data['data_config'] = $configModel->get_data();

        $this->load->view('layouts/main.tpl.php', $data);
    }

    public function cetak_biodata($id = '')
    {
        $data['desa']     = $this->header_model->get_data();
        $data['penduduk'] = $this->penduduk_model->get_penduduk($id);
        $this->load->view('sid/kependudukan/cetak_biodata', $data);
    }

    public function mandiri($p = 1, $m = 0)
    {
        if ($_SESSION['mandiri'] !== 1) {
            redirect('first');
        } else {
            $data['p']             = $p;
            $data['desa']          = $firstModel->get_data();
            $data['menu_atas']     = $firstMenuModel->list_menu_atas();
            $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();
            $data['headline']      = $firstArtikelModel->get_headline();
            $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();

            //$data['paging']  = $firstArtikelModel->paging($p);
            //$data['artikel'] = $firstArtikelModel->artikel_show(0,$data['paging']->offset,$data['paging']->per_page);

            $data['penduduk'] = $this->penduduk_model->get_penduduk($_SESSION['id']);
            $data['arsip']    = $firstArtikelModel->arsip_show();
            $data['komen']    = $firstArtikelModel->komentar_show();
            $data['agenda']   = $firstArtikelModel->agenda_show();
            $data['slide']    = $firstArtikelModel->slide_show();

            $data['stat']        = $firstPendudukModel->list_data(4);
            $data['sosmed']      = $firstArtikelModel->list_sosmed();
            $data['w_gal']       = $firstGalleryModel->gallery_widget();
            $data['w_cos']       = $firstArtikelModel->cos_widget();
            $data['data_config'] = $configModel->get_data();

            $data['list_dokumen']  = $this->penduduk_model->list_dokumen($_SESSION['id']);
            $data['list_kelompok'] = $this->penduduk_model->list_kelompok($_SESSION['id']);

            //if($m == 2)
            $data['surat_keluar'] = $this->surat_keluar_model->list_data_surat($_SESSION['id']);

            //$data['menu_surat2'] = $this->surat_model->list_surat2();
            $data['m'] = $m;
            $this->load->view('layouts/mandiri.php', $data);
        }
    }

    public function artikel($id = '', $p = 1)
    {
        $id           = explode('-', $id);
        $id           = $id[0];
        $data['p']    = $p;
        $data['desa'] = $firstModel->get_data();

        $data['paging']  = $firstArtikelModel->paging($p);
        $data['artikel'] = $firstArtikelModel->list_artikel(0, $data['paging']->offset, $data['paging']->per_page);

        $data['teks_berjalan']  = $firstArtikelModel->get_teks_berjalan();
        $data['menu_atas']      = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']      = $firstMenuModel->list_menu_kiri();
        $data['komentar']       = $firstArtikelModel->list_komentar($id);
        $data['sosmed']         = $firstArtikelModel->list_sosmed();
        $data['single_artikel'] = $firstArtikelModel->get_artikel($id);
        $data['arsip']          = $firstArtikelModel->arsip_show();
        $data['komen']          = $firstArtikelModel->komentar_show();
        $data['agenda']         = $firstArtikelModel->agenda_show();
        $data['slide']          = $firstArtikelModel->slide_show();
        $data['stat']           = $firstPendudukModel->list_data(5);
        $data['w_gal']          = $firstGalleryModel->gallery_widget();
        $data['w_cos']          = $firstArtikelModel->cos_widget();

        $data['data_config'] = $configModel->get_data();
        $this->load->view('layouts/artikel.tpl.php', $data);
    }

    public function arsip($p = 1)
    {
        $data['p']      = $p;
        $data['paging'] = $firstArtikelModel->paging_arsip($p);

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['desa']          = $firstModel->get_data();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();
        $data['sosmed']        = $firstArtikelModel->list_sosmed();
        $data['farsip']        = $firstArtikelModel->full_arsip($data['paging']->offset, $data['paging']->per_page);
        $data['arsip']         = $firstArtikelModel->arsip_show();
        $data['komen']         = $firstArtikelModel->komentar_show();
        $data['agenda']        = $firstArtikelModel->agenda_show();
        $data['slide']         = $firstArtikelModel->slide_show();
        $data['stat']          = $firstPendudukModel->list_data(5);
        $data['w_gal']         = $firstGalleryModel->gallery_widget();
        $data['w_cos']         = $firstArtikelModel->cos_widget();
        $data['data_config']   = $configModel->get_data();

        $this->load->view('layouts/arsip.tpl.php', $data);
    }

    public function gallery($p = 1)
    {
        $data['p'] = $p;

        $data['desa'] = $firstModel->get_data();

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['paging']        = $firstArtikelModel->paging($p);
        $data['artikel']       = $firstArtikelModel->artikel_show(0, $data['paging']->offset, $data['paging']->per_page);

        $data['menu_atas'] = $firstMenuModel->list_menu_atas();
        $data['menu_kiri'] = $firstMenuModel->list_menu_kiri();
        $data['arsip']     = $firstArtikelModel->arsip_show();
        $data['komen']     = $firstArtikelModel->komentar_show();
        $data['agenda']    = $firstArtikelModel->agenda_show();
        $data['slide']     = $firstArtikelModel->slide_show();
        $data['sosmed']    = $firstArtikelModel->list_sosmed();

        $data['paging']  = $firstGalleryModel->paging($p);
        $data['gallery'] = $firstGalleryModel->gallery_show($data['paging']->offset, $data['paging']->per_page);

        $data['stat']        = $firstPendudukModel->list_data(6);
        $data['w_gal']       = $firstGalleryModel->gallery_widget();
        $data['w_cos']       = $firstArtikelModel->cos_widget();
        $data['data_config'] = $configModel->get_data();
        $this->load->view('layouts/gallery.tpl.php', $data);
    }

    public function sub_gallery($gal = 0, $p = 1)
    {
        $data['p']    = $p;
        $data['gal']  = $gal;
        $data['desa'] = $firstModel->get_data();

        $data['paging']  = $firstGalleryModel->paging($p);
        $data['gallery'] = $firstGalleryModel->gallery_show($data['paging']->offset, $data['paging']->per_page);

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();

        $data['paging']  = $firstGalleryModel->paging2($gal, $p);
        $data['gallery'] = $firstGalleryModel->sub_gallery_show($gal, $data['paging']->offset, $data['paging']->per_page);

        $data['parrent'] = $firstGalleryModel->get_parrent($gal);
        $data['arsip']   = $firstArtikelModel->arsip_show();
        $data['komen']   = $firstArtikelModel->komentar_show();
        $data['agenda']  = $firstArtikelModel->agenda_show();
        $data['slide']   = $firstArtikelModel->slide_show();
        $data['sosmed']  = $firstArtikelModel->list_sosmed();

        $data['stat']        = $firstPendudukModel->list_data(4);
        $data['w_gal']       = $firstGalleryModel->gallery_widget();
        $data['w_cos']       = $firstArtikelModel->cos_widget();
        $data['data_config'] = $configModel->get_data();
        $data['mode']        = 1;
        $this->load->view('layouts/sub_gallery.tpl.php', $data);
    }

    public function statistik($stat = '', $tipe = 0)
    {
        switch ($stat) {
            case 'pendidikan-dalam-kk':$data['heading'] = 'Pendidikan'; break;

            case 'pekerjaan':$data['heading'] = 'Pekerjaan'; break;

            case 'status-perkawinan':$data['heading'] = 'Status Perkawinan'; break;

            case 'agama':$data['heading'] = 'Agama'; break;

            case 'jenis-kelamin':$data['heading'] = 'Jenis Kelamin'; break;

            case 'golongan-darah':$data['heading'] = 'Golongan Darah'; break;

            case 'kelompok-umur':$data['heading'] = 'Kelompok Umur'; break;

            case 'warga-negara':$data['heading'] = 'Warga Negara'; break;

            case 'wilayah':redirect('first/wilayah'); break;

            case 'pendidikan-ditempuh':$data['heading'] = 'Pendidikan Sedang Ditempuh'; break;

            default:$data['heading'] = ''; redirect('first'); break;
        }

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['slide']         = $firstArtikelModel->slide_show();
        $data['desa']          = $firstModel->get_data();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();
        $data['stat']          = $firstPendudukModel->list_data($stat);
        $data['tipe']          = $tipe;

        $data['sosmed'] = $firstArtikelModel->list_sosmed();
        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['w_cos']  = $firstArtikelModel->cos_widget();

        $data['data_config'] = $configModel->get_data();
        $data['st']          = $stat;

        $this->load->view('layouts/stat.tpl.php', $data);
    }

    public function data_analisis($stat = '', $sb = 0, $per = 0)
    {
        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['slide']         = $firstArtikelModel->slide_show();
        $data['desa']          = $firstModel->get_data();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();

        if ($stat === '') {
            $data['list_indikator'] = $firstPendudukModel->list_indikator();
            $data['list_jawab']     = null;
            $data['indikator']      = null;
        } else {
            $data['list_indikator'] = '';
            $data['list_jawab']     = $firstPendudukModel->list_jawab($stat, $sb, $per);
            $data['indikator']      = $firstPendudukModel->get_indikator($stat);
        }
        $data['sosmed'] = $firstArtikelModel->list_sosmed();
        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['w_cos']  = $firstArtikelModel->cos_widget();

        $data['data_config'] = $configModel->get_data();

        $this->load->view('layouts/analisis.tpl.php', $data);
    }

    public function wilayah()
    {
        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['main']          = $firstPendudukModel->wilayah();
        $data['heading']       = 'Populasi Per Wilayah';
        $data['desa']          = $firstModel->get_data();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();

        $data['slide']  = $firstArtikelModel->slide_show();
        $data['sosmed'] = $firstArtikelModel->list_sosmed();
        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['w_cos']  = $firstArtikelModel->cos_widget();

        $data['tipe'] = 3;

        $data['total']       = $firstPendudukModel->total();
        $data['st']          = 1;
        $data['data_config'] = $configModel->get_data();
        $this->load->view('layouts/stat.tpl.php', $data);
    }

    public function statistik_k($tipex = 0)
    {
        $data['tipe']  = 2;
        $data['tipex'] = $tipex;

        $data['desa'] = $firstModel->get_data();

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['menu_atas']     = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']     = $firstMenuModel->list_menu_kiri();

        $data['slide']  = $firstArtikelModel->slide_show();
        $data['sosmed'] = $firstArtikelModel->list_sosmed();
        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['w_cos']  = $firstArtikelModel->cos_widget();
        $data['stat']   = $firstPendudukModel->list_data(4);

        $data['main']        = $this->first_keluarga_m->list_raskin($tipex);
        $data['data_config'] = $configModel->get_data();
        $this->load->view('layouts/stat.tpl.php', $data);
    }

    public function agenda($stat = 0)
    {
        $data['desa']        = $firstModel->get_data();
        $data['menu_atas']   = $firstMenuModel->list_menu_atas();
        $data['menu_kiri']   = $firstMenuModel->list_menu_kiri();
        $data['artikel']     = $firstArtikelModel->agenda_show();
        $data['arsip']       = $firstArtikelModel->arsip_show();
        $data['komen']       = $firstArtikelModel->komentar_show();
        $data['agenda']      = $firstArtikelModel->agenda_show();
        $data['sosmed']      = $firstArtikelModel->list_sosmed();
        $data['stat']        = $firstPendudukModel->list_data(4);
        $data['data_config'] = $configModel->get_data();

        $this->load->view('layouts/main.tpl.php', $data);
    }

    public function kategori($kat = 0, $p = 0)
    {
        $data['p']         = $p;
        $data['desa']      = $firstModel->get_data();
        $data['menu_atas'] = $firstMenuModel->list_menu_atas();
        $data['menu_kiri'] = $firstMenuModel->list_menu_kiri();
        $data['headline']  = null;

        $data['teks_berjalan'] = $firstArtikelModel->get_teks_berjalan();
        $data['paging']        = $firstArtikelModel->paging_kat($p, $kat);
        $data['artikel']       = $firstArtikelModel->list_artikel($data['paging']->offset, $data['paging']->per_page, $kat);

        $data['arsip']  = $firstArtikelModel->arsip_show();
        $data['komen']  = $firstArtikelModel->komentar_show();
        $data['agenda'] = $firstArtikelModel->agenda_show();
        $data['slide']  = $firstArtikelModel->slide_show();
        $data['stat']   = $firstPendudukModel->list_data(4);
        $data['sosmed'] = $firstArtikelModel->list_sosmed();
        $data['w_gal']  = $firstGalleryModel->gallery_widget();
        $data['w_cos']  = $firstArtikelModel->cos_widget();

        $data['judul_kategori'] = $firstArtikelModel->get_kategori($kat);

        $data['data_config'] = $configModel->get_data();
        $this->load->view('layouts/main.tpl.php', $data);
    }

    public function add_comment($id = 0)
    {
        $firstArtikelModel->insert_comment($id);
        $data['data_config'] = $configModel->get_data();
        if ($id !== 775) {
            redirect("first/artikel/{$id}");
        } else {
            $_SESSION['sukses'] = 1;
            redirect('first/mandiri/1/3');
        }
    }

    public function randomap($id = 0)
    {
        $this->penduduk_model->randomap();
    }
}
