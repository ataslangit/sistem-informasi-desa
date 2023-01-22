<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller as BaseController;

class Statistik extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $_SESSION['filter'] = 77;
        session()->remove('log');
        $_SESSION['status_dasar'] = 1;
        session()->remove(['cari', 'duplikat', 'sex', 'warganegara', 'cacat', 'menahun', 'cacatx', 'menahunx', 'golongan_darah', 'dusun', 'rw', 'rt', 'hubungan', 'agama', 'umur_min', 'umur_max', 'pekerjaan_id', 'status', 'pendidikan_id', 'pendidikan_sedang_id', 'pendidikan_kk_id', 'umurx', 'status_penduduk', 'judul_statistik', 'hamil']);

        $this->load->model('config_model');
        $this->load->model('laporan_penduduk_model');
        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            return redirect()->to('siteman');
        }
        $this->load->model('header_model');
        $_SESSION['per_page'] = 500;
    }

    public function index($lap = 0, $o = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap, $o);
        $data['lap']  = $lap;
        $data['o']    = $o;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Cacat';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 13: $data['stat'] = 'Umur (Detail)';
                break;

            case 15: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('statistik/nav', $nav);
        echo view('statistik/penduduk', $data);
        echo view('footer');
    }

    public function clear()
    {
        session()->remove(['log', 'cari', 'filter', 'sex', 'warganegara', 'cacat', 'menahun', 'golongan_darah', 'dusun', 'rw', 'rt', 'agama', 'umur_min', 'umur_max', 'pekerjaan_id', 'status', 'pendidikan_id', 'status_penduduk']);

        return redirect()->to('statistik');
    }

    public function graph($lap = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap);
        $data['lap']  = $lap;

        switch ($lap) {
            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status Kependudukan';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Difabilitas (Cacat)';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 0: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 13: $data['stat'] = 'Umur (Detail)';
                break;

            case 15: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('statistik/nav', $nav);
        echo view('statistik/penduduk_graph', $data);
        echo view('footer');
    }

    public function pie($lap = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap);
        $data['lap']  = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh';
                break;

            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Cacat';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 12: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 13: $data['stat'] = 'Umur (Detail)';
                break;

            case 15: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('statistik/nav', $nav);
        echo view('statistik/penduduk_pie', $data);
        echo view('footer');
    }

    public function cetak($lap = 0)
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh';
                break;

            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Cacat';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 12: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 13: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);
        echo view('statistik/penduduk_print', $data);
    }

    public function excel($lap = 0)
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh';
                break;

            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Cacat';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 12: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 13: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);
        echo view('statistik/penduduk_excel', $data);
    }

    public function warga($lap = '', $data = '')
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh';
                break;

            case 1: $data['stat'] = 'Pekerjaan';
                break;

            case 2: $data['stat'] = 'Status Perkawinan';
                break;

            case 3: $data['stat'] = 'Agama';
                break;

            case 4: $data['stat'] = 'Jenis Kelamin';
                break;

            case 5: $data['stat'] = 'Warga Negara';
                break;

            case 6: $data['stat'] = 'Status';
                break;

            case 7: $data['stat'] = 'Golongan Darah';
                break;

            case 9: $data['stat'] = 'Cacat';
                break;

            case 10: $data['stat'] = 'Sakit Menahun';
                break;

            case 11: $data['stat'] = 'Jamkesmas';
                break;

            case 12: $data['stat'] = 'Pendidikan dalam KK';
                break;

            case 13: $data['stat'] = 'Umur';
                break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh';
                break;

            case 21: $data['stat'] = 'Klasifikasi Sosial';
                break;

            case 22: $data['stat'] = 'Penerima Raskin';
                break;

            case 23: $data['stat'] = 'Penerima BLT';
                break;

            case 24: $data['stat'] = 'Penerima BOS';
                break;

            case 25: $data['stat'] = 'Penerima PKH';
                break;

            case 26: $data['stat'] = 'Penerima Jampersal';
                break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah';
                break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);

        $_SESSION['per_page'] = 100;
        $_SESSION['data']     = $data;

        return redirect()->to('sid_penduduk/index/');
    }

    public function rentang_umur()
    {
        $data['lap']  = 13;
        $data['main'] = $this->laporan_penduduk_model->list_data_rentang();
        $header       = $this->header_model->get_data();
        $menu['act']  = '2';

        echo view('header', $header);
        // echo view('statistik/menu');
        echo view('statistik/nav', $menu);
        echo view('statistik/rentang_umur', $data);
        echo view('footer');
    }

    public function form_rentang($id = 0)
    {
        if ($id === 0) {
            $data['form_action']       = site_url('statistik/rentang_insert');
            $data['rentang']           = $this->laporan_penduduk_model->get_rentang_terakhir();
            $data['rentang']['nama']   = '';
            $data['rentang']['sampai'] = '';
        } else {
            $data['form_action'] = site_url("statistik/rentang_update/{$id}");
            $data['rentang']     = $this->laporan_penduduk_model->get_rentang($id);
        }
        echo view('statistik/ajax_rentang_form', $data);
    }

    public function rentang_insert()
    {
        $data['insert'] = $this->laporan_penduduk_model->insert_rentang();

        return redirect()->to('statistik/rentang_umur');
    }

    public function rentang_update($id = 0)
    {
        $this->laporan_penduduk_model->update_rentang($id);

        return redirect()->to('statistik/rentang_umur');
    }

    public function rentang_delete($id = 0)
    {
        $this->laporan_penduduk_model->delete_rentang($id);

        return redirect()->to('statistik/rentang_umur');
    }

    public function delete_all_rentang()
    {
        $this->laporan_penduduk_model->delete_all_rentang();

        return redirect()->to('statistik/rentang_umur');
    }
}
