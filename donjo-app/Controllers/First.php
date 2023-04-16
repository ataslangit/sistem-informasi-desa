<?php

namespace App\Controllers;

use App\Models\Artikel;
use App\Models\Config_model;
use App\Models\GambarGallery;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Penduduk;

class First extends BaseController
{
    /**
     * Menampilkan halaman utama
     */
    public function index(): string
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        $data['desa']          = $data['data_config'] = $configModel->first();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();
        $data['headline']      = $artikelModel->get_headline();
        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();

        $data['artikel'] = $artikelModel->select('artikel.*,user.nama as owner,kategori.kategori as kategori')->joinUser()->joinKategori()->artikelShow()->orderBy('artikel.tgl_upload DESC')->paginate(5);
        $data['paging']  = $artikelModel->pager;

        $data['arsip']  = $artikelModel->arsip_show();
        $data['komen']  = $artikelModel->komentar_show();
        $data['agenda'] = $artikelModel->agenda_show();
        $data['slide']  = $artikelModel->slide_show();

        $data['stat']   = $pendudukModel->list_data(4);
        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['w_gal']  = $gambarGelleryModel->gallery_widget();
        $data['w_cos']  = $artikelModel->cos_widget();

        return view('layouts/main.tpl.php', $data);
    }

    /**
     * Menampilkan detail artikel
     */
    public function artikel(string $id): string
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        $id = explode('-', $id);
        $id = $id[0];

        $data['desa']           = $data['data_config'] = $configModel->first();
        $data['teks_berjalan']  = $artikelModel->get_teks_berjalan();
        $data['menu_atas']      = $menuModel->list_menu_atas();
        $data['menu_kiri']      = $menuModel->list_menu_kiri();
        $data['komentar']       = $artikelModel->list_komentar($id);
        $data['sosmed']         = $artikelModel->list_sosmed();
        $data['single_artikel'] = $artikelModel->get_artikel($id);
        $data['arsip']          = $artikelModel->arsip_show();
        $data['komen']          = $artikelModel->komentar_show();
        $data['agenda']         = $artikelModel->agenda_show();
        $data['slide']          = $artikelModel->slide_show();
        $data['stat']           = $pendudukModel->list_data(5);
        $data['w_gal']          = $gambarGelleryModel->gallery_widget();
        $data['w_cos']          = $artikelModel->cos_widget();

        return view('layouts/artikel.tpl.php', $data);
    }

    /**
     * Menampilkan halaman kategori
     */
    public function kategori(int $kat): string
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();
        $kategoriModel      = new Kategori();

        $data['desa']      = $data['data_config'] = $configModel->first();
        $data['menu_atas'] = $menuModel->list_menu_atas();
        $data['menu_kiri'] = $menuModel->list_menu_kiri();
        $data['headline']  = null;

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();

        $data['artikel'] = $artikelModel->select('artikel.*,user.nama as owner,kategori.kategori as kategori')->joinUser()->joinKategori()->listArtikel($kat)->orderBy('artikel.tgl_upload DESC')->paginate(5);
        $data['paging']  = $artikelModel->pager;

        $data['arsip']  = $artikelModel->arsip_show();
        $data['komen']  = $artikelModel->komentar_show();
        $data['agenda'] = $artikelModel->agenda_show();
        $data['slide']  = $artikelModel->slide_show();
        $data['stat']   = $pendudukModel->list_data(4);
        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['w_gal']  = $gambarGelleryModel->gallery_widget();
        $data['w_cos']  = $artikelModel->cos_widget();

        $data['judul_kategori'] = $kategoriModel->find($kat)['kategori'];

        return view('layouts/main.tpl.php', $data);
    }

    /**
     * Menampilkan halaman album gallery
     */
    public function gallery(): string
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        $data['desa'] = $data['data_config'] = $configModel->first();

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();

        $data['menu_atas'] = $menuModel->list_menu_atas();
        $data['menu_kiri'] = $menuModel->list_menu_kiri();
        $data['arsip']     = $artikelModel->arsip_show();
        $data['komen']     = $artikelModel->komentar_show();
        $data['agenda']    = $artikelModel->agenda_show();
        $data['slide']     = $artikelModel->slide_show();
        $data['sosmed']    = $artikelModel->list_sosmed();

        $data['gallery'] = $gambarGelleryModel->where(['enabled' => '1', 'tipe' => '0'])->paginate(12);
        $data['paging']  = $gambarGelleryModel->pager;

        $data['stat']  = $pendudukModel->list_data(6);
        $data['w_gal'] = $gambarGelleryModel->gallery_widget();
        $data['w_cos'] = $artikelModel->cos_widget();

        return view('layouts/gallery.tpl.php', $data);
    }

    /**
     * Menampilkan isi album gallery
     */
    public function sub_gallery(int $gal = 0): string
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        $data['gal']  = $gal;
        $data['desa'] = $configModel->first();

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();

        $data['gallery'] = $gambarGelleryModel->subGalleryShow($gal)->paginate(50);
        $data['paging']  = $gambarGelleryModel->pager;

        $data['parrent'] = $gambarGelleryModel->get_parrent($gal);
        $data['arsip']   = $artikelModel->arsip_show();
        $data['komen']   = $artikelModel->komentar_show();
        $data['agenda']  = $artikelModel->agenda_show();
        $data['slide']   = $artikelModel->slide_show();
        $data['sosmed']  = $artikelModel->list_sosmed();

        $data['stat']        = $pendudukModel->list_data(4);
        $data['w_gal']       = $gambarGelleryModel->gallery_widget();
        $data['w_cos']       = $artikelModel->cos_widget();
        $data['data_config'] = $configModel->first();
        $data['mode']        = 1;

        return view('layouts/sub_gallery.tpl.php', $data);
    }

    public function auth()
    {
        if ($_SESSION['mandiri_wait'] !== 1) {
            $this->first_m->siteman();
        }
        if ($_SESSION['mandiri'] === 1) {
            redirect('first/mandiri/1/1');
        } else {
            redirect('first');
        }
    }

    public function mobile($user = '', $pass = '')
    {
        return $this->first_m->m_siteman();
    }

    public function logout()
    {
        $this->first_m->logout();
        redirect('first');
    }

    public function ganti()
    {
        $this->first_m->ganti();
        redirect('first');
    }

    public function cetak_biodata($id = '')
    {
        $data['desa']     = $this->header_model->get_data();
        $data['penduduk'] = $this->penduduk_model->get_penduduk($id);
        view('sid/kependudukan/cetak_biodata', $data);
    }

    public function mandiri($p = 1, $m = 0)
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        if ($_SESSION['mandiri'] !== 1) {
            redirect('first');
        } else {
            $data['p']             = $p;
            $data['desa']          = $configModel->first();
            $data['menu_atas']     = $menuModel->list_menu_atas();
            $data['menu_kiri']     = $menuModel->list_menu_kiri();
            $data['headline']      = $artikelModel->get_headline();
            $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();

            // $data['paging']  = $artikelModel->paging($p);
            // $data['artikel'] = $artikelModel->artikel_show(0,$data['paging']->offset,$data['paging']->per_page);

            $data['penduduk'] = $this->penduduk_model->get_penduduk($_SESSION['id']);
            $data['arsip']    = $artikelModel->arsip_show();
            $data['komen']    = $artikelModel->komentar_show();
            $data['agenda']   = $artikelModel->agenda_show();
            $data['slide']    = $artikelModel->slide_show();

            $data['stat']        = $pendudukModel->list_data(4);
            $data['sosmed']      = $artikelModel->list_sosmed();
            $data['w_gal']       = $gambarGelleryModel->gallery_widget();
            $data['w_cos']       = $artikelModel->cos_widget();
            $data['data_config'] = $configModel->first();

            $data['list_dokumen']  = $this->penduduk_model->list_dokumen($_SESSION['id']);
            $data['list_kelompok'] = $this->penduduk_model->list_kelompok($_SESSION['id']);

            // if($m == 2)
            $data['surat_keluar'] = $this->surat_keluar_model->list_data_surat($_SESSION['id']);

            // $data['menu_surat2'] = $this->surat_model->list_surat2();
            $data['m'] = $m;
            view('layouts/mandiri.php', $data);
        }
    }

    public function arsip($p = 1)
    {
        $configModel        = new Config_model();
        $menuModel          = new Menu();
        $artikelModel       = new Artikel();
        $pendudukModel      = new Penduduk();
        $gambarGelleryModel = new GambarGallery();

        $data['p']      = $p;
        $data['paging'] = $artikelModel->paging_arsip($p);

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['desa']          = $configModel->first();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();
        $data['sosmed']        = $artikelModel->list_sosmed();
        $data['farsip']        = $artikelModel->full_arsip($data['paging']->offset, $data['paging']->per_page);
        $data['arsip']         = $artikelModel->arsip_show();
        $data['komen']         = $artikelModel->komentar_show();
        $data['agenda']        = $artikelModel->agenda_show();
        $data['slide']         = $artikelModel->slide_show();
        $data['stat']          = $pendudukModel->list_data(5);
        $data['w_gal']         = $gambarGelleryModel->gallery_widget();
        $data['w_cos']         = $artikelModel->cos_widget();
        $data['data_config']   = $configModel->first();

        view('layouts/arsip.tpl.php', $data);
    }

    public function statistik($stat = '', $tipe = 0)
    {
        $configModel   = new Config_model();
        $menuModel     = new Menu();
        $artikelModel  = new Artikel();
        $pendudukModel = new Penduduk();

        switch ($stat) {
            case 'pendidikan-dalam-kk':$data['heading'] = 'Pendidikan';
                break;

            case 'pekerjaan':$data['heading'] = 'Pekerjaan';
                break;

            case 'status-perkawinan':$data['heading'] = 'Status Perkawinan';
                break;

            case 'agama':$data['heading'] = 'Agama';
                break;

            case 'jenis-kelamin':$data['heading'] = 'Jenis Kelamin';
                break;

            case 'golongan-darah':$data['heading'] = 'Golongan Darah';
                break;

            case 'kelompok-umur':$data['heading'] = 'Kelompok Umur';
                break;

            case 'warga-negara':$data['heading'] = 'Warga Negara';
                break;

            case 'wilayah':redirect('first/wilayah');
                break;

            case 'pendidikan-ditempuh':$data['heading'] = 'Pendidikan Sedang Ditempuh';
                break;

            default:$data['heading'] = '';
                redirect('first');
                break;
        }

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['slide']         = $artikelModel->slide_show();
        $data['desa']          = $configModel->first();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();
        $data['stat']          = $pendudukModel->list_data($stat);
        $data['tipe']          = $tipe;

        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['arsip']  = $artikelModel->arsip_show();
        $data['w_cos']  = $artikelModel->cos_widget();

        $data['data_config'] = $configModel->first();
        $data['st']          = $stat;

        view('layouts/stat.tpl.php', $data);
    }

    public function data_analisis($stat = '', $sb = 0, $per = 0)
    {
        $configModel   = new Config_model();
        $menuModel     = new Menu();
        $artikelModel  = new Artikel();
        $pendudukModel = new Penduduk();

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['slide']         = $artikelModel->slide_show();
        $data['desa']          = $configModel->first();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();

        if ($stat === '') {
            $data['list_indikator'] = $pendudukModel->list_indikator();
            $data['list_jawab']     = null;
            $data['indikator']      = null;
        } else {
            $data['list_indikator'] = '';
            $data['list_jawab']     = $pendudukModel->list_jawab($stat, $sb, $per);
            $data['indikator']      = $pendudukModel->get_indikator($stat);
        }
        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['arsip']  = $artikelModel->arsip_show();
        $data['w_cos']  = $artikelModel->cos_widget();

        $data['data_config'] = $configModel->first();

        view('layouts/analisis.tpl.php', $data);
    }

    public function wilayah()
    {
        $configModel   = new Config_model();
        $menuModel     = new Menu();
        $artikelModel  = new Artikel();
        $pendudukModel = new Penduduk();

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['main']          = $pendudukModel->wilayah();
        $data['heading']       = 'Populasi Per Wilayah';
        $data['desa']          = $configModel->first();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();

        $data['slide']  = $artikelModel->slide_show();
        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['arsip']  = $artikelModel->arsip_show();
        $data['w_cos']  = $artikelModel->cos_widget();

        $data['tipe'] = 3;

        $data['total']       = $pendudukModel->total();
        $data['st']          = 1;
        $data['data_config'] = $configModel->first();
        view('layouts/stat.tpl.php', $data);
    }

    public function statistik_k($tipex = 0)
    {
        $configModel   = new Config_model();
        $menuModel     = new Menu();
        $artikelModel  = new Artikel();
        $pendudukModel = new Penduduk();

        $data['tipe']  = 2;
        $data['tipex'] = $tipex;

        $data['desa'] = $configModel->first();

        $data['teks_berjalan'] = $artikelModel->get_teks_berjalan();
        $data['menu_atas']     = $menuModel->list_menu_atas();
        $data['menu_kiri']     = $menuModel->list_menu_kiri();

        $data['slide']  = $artikelModel->slide_show();
        $data['sosmed'] = $artikelModel->list_sosmed();
        $data['arsip']  = $artikelModel->arsip_show();
        $data['w_cos']  = $artikelModel->cos_widget();
        $data['stat']   = $pendudukModel->list_data(4);

        $data['main']        = $this->first_keluarga_m->list_raskin($tipex);
        $data['data_config'] = $configModel->first();
        view('layouts/stat.tpl.php', $data);
    }

    public function agenda($stat = 0)
    {
        $configModel   = new Config_model();
        $menuModel     = new Menu();
        $artikelModel  = new Artikel();
        $pendudukModel = new Penduduk();

        $data['desa']        = $configModel->first();
        $data['menu_atas']   = $menuModel->list_menu_atas();
        $data['menu_kiri']   = $menuModel->list_menu_kiri();
        $data['artikel']     = $artikelModel->agenda_show();
        $data['arsip']       = $artikelModel->arsip_show();
        $data['komen']       = $artikelModel->komentar_show();
        $data['agenda']      = $artikelModel->agenda_show();
        $data['sosmed']      = $artikelModel->list_sosmed();
        $data['stat']        = $pendudukModel->list_data(4);
        $data['data_config'] = $configModel->first();

        view('layouts/main.tpl.php', $data);
    }

    public function add_comment($id = 0)
    {
        $configModel  = new Config_model();
        $artikelModel = new Artikel();

        $artikelModel->insert_comment($id);
        $data['data_config'] = $configModel->first();
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
