<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Statistik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $_SESSION['filter'] = 77;
        unset($_SESSION['log']);
        $_SESSION['status_dasar'] = 1;
        unset($_SESSION['cari'], $_SESSION['duplikat'], $_SESSION['sex'], $_SESSION['warganegara'], $_SESSION['cacat'], $_SESSION['menahun'], $_SESSION['cacatx'], $_SESSION['menahunx'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['hubungan'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_id'], $_SESSION['pendidikan_sedang_id'], $_SESSION['pendidikan_kk_id'], $_SESSION['umurx'], $_SESSION['status_penduduk'], $_SESSION['judul_statistik'], $_SESSION['hamil']);

        $this->load->model('config_model');
        $this->load->model('laporan_penduduk_model');
        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
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
            case 0: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Cacat'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 13: $data['stat'] = 'Umur (Detail)'; break;

            case 15: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        view('header', $header);
        view('statistik/nav', $nav);
        view('statistik/penduduk', $data);
        view('footer');
    }

    public function clear()
    {
        unset($_SESSION['log'], $_SESSION['cari'], $_SESSION['filter'], $_SESSION['sex'], $_SESSION['warganegara'], $_SESSION['cacat'], $_SESSION['menahun'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_id'], $_SESSION['status_penduduk']);

        redirect('statistik');
    }

    public function graph($lap = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap);
        $data['lap']  = $lap;

        switch ($lap) {
            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status Kependudukan'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Difabilitas (Cacat)'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 0: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 13: $data['stat'] = 'Umur (Detail)'; break;

            case 15: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        view('header', $header);
        view('statistik/nav', $nav);
        view('statistik/penduduk_graph', $data);
        view('footer');
    }

    public function pie($lap = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap);
        $data['lap']  = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh'; break;

            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Cacat'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 12: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 13: $data['stat'] = 'Umur (Detail)'; break;

            case 15: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();
        view('header', $header);
        view('statistik/nav', $nav);
        view('statistik/penduduk_pie', $data);
        view('footer');
    }

    public function cetak($lap = 0)
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh'; break;

            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Cacat'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 12: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 13: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);
        view('statistik/penduduk_print', $data);
    }

    public function excel($lap = 0)
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh'; break;

            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Cacat'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 12: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 13: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);
        view('statistik/penduduk_excel', $data);
    }

    public function warga($lap = '', $data = '')
    {
        $data['lap'] = $lap;

        switch ($lap) {
            case 0: $data['stat'] = 'Pendidikan Telah Ditempuh'; break;

            case 1: $data['stat'] = 'Pekerjaan'; break;

            case 2: $data['stat'] = 'Status Perkawinan'; break;

            case 3: $data['stat'] = 'Agama'; break;

            case 4: $data['stat'] = 'Jenis Kelamin'; break;

            case 5: $data['stat'] = 'Warga Negara'; break;

            case 6: $data['stat'] = 'Status'; break;

            case 7: $data['stat'] = 'Golongan Darah'; break;

            case 9: $data['stat'] = 'Cacat'; break;

            case 10: $data['stat'] = 'Sakit Menahun'; break;

            case 11: $data['stat'] = 'Jamkesmas'; break;

            case 12: $data['stat'] = 'Pendidikan dalam KK'; break;

            case 13: $data['stat'] = 'Umur'; break;

            case 14: $data['stat'] = 'Pendidikan Sedang Ditempuh'; break;

            case 21: $data['stat'] = 'Klasifikasi Sosial'; break;

            case 22: $data['stat'] = 'Penerima Raskin'; break;

            case 23: $data['stat'] = 'Penerima BLT'; break;

            case 24: $data['stat'] = 'Penerima BOS'; break;

            case 25: $data['stat'] = 'Penerima PKH'; break;

            case 26: $data['stat'] = 'Penerima Jampersal'; break;

            case 27: $data['stat'] = 'Penerima Bedah Rumah'; break;

            default:$data['stat'] = 'Pendidikan';
        }

        $data['config'] = $this->config_model->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);

        $_SESSION['per_page'] = 100;
        $_SESSION['data']     = $data;
        redirect('sid_penduduk/index/');
    }

    public function rentang_umur()
    {
        $data['lap']  = 13;
        $data['main'] = $this->laporan_penduduk_model->list_data_rentang();
        $header       = $this->header_model->get_data();
        $menu['act']  = '2';

        view('header', $header);
        //view('statistik/menu');
        view('statistik/nav', $menu);
        view('statistik/rentang_umur', $data);
        view('footer');
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
        view('statistik/ajax_rentang_form', $data);
    }

    public function rentang_insert()
    {
        $data['insert'] = $this->laporan_penduduk_model->insert_rentang();
        redirect('statistik/rentang_umur');
    }

    public function rentang_update($id = 0)
    {
        $this->laporan_penduduk_model->update_rentang($id);
        redirect('statistik/rentang_umur');
    }

    public function rentang_delete($id = 0)
    {
        $this->laporan_penduduk_model->delete_rentang($id);
        redirect('statistik/rentang_umur');
    }

    public function delete_all_rentang()
    {
        $this->laporan_penduduk_model->delete_all_rentang();
        redirect('statistik/rentang_umur');
    }
}
