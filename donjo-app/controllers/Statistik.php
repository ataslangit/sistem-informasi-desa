<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Statistik extends BaseController
{
    public function __construct()
    {
        $_SESSION['filter'] = 77;
        unset($_SESSION['log']);
        $_SESSION['status_dasar'] = 1;
        unset($_SESSION['cari'], $_SESSION['duplikat'], $_SESSION['sex'], $_SESSION['warganegara'], $_SESSION['cacat'], $_SESSION['menahun'], $_SESSION['cacatx'], $_SESSION['menahunx'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['hubungan'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_id'], $_SESSION['pendidikan_sedang_id'], $_SESSION['pendidikan_kk_id'], $_SESSION['umurx'], $_SESSION['status_penduduk'], $_SESSION['judul_statistik'], $_SESSION['hamil']);

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }
        $_SESSION['per_page'] = 500;
    }

    public function index($lap = 0, $o = 0)
    {
        $data['main'] = $this->laporan_penduduk_model->list_data($lap, $o);
        $data['lap']  = $lap;
        $data['o']    = $o;

        $data['stat'] = match ($lap) {
            0       => 'Pendidikan dalam KK',
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status',
            7       => 'Golongan Darah',
            9       => 'Cacat',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            13      => 'Umur (Detail)',
            15      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

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

        $data['stat'] = match ($lap) {
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status Kependudukan',
            7       => 'Golongan Darah',
            9       => 'Difabilitas (Cacat)',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            0       => 'Pendidikan dalam KK',
            13      => 'Umur (Detail)',
            15      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

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

        $data['stat'] = match ($lap) {
            0       => 'Pendidikan Telah Ditempuh',
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status',
            7       => 'Golongan Darah',
            9       => 'Cacat',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            12      => 'Pendidikan dalam KK',
            13      => 'Umur (Detail)',
            15      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

        $nav['act'] = 0;
        $header     = $this->header_model->get_data();

        view('header', $header);
        view('statistik/nav', $nav);
        view('statistik/penduduk_pie', $data);
        view('footer');
    }

    public function cetak($lap = 0)
    {
        $configModel = new Config();

        $data['lap'] = $lap;

        $data['stat'] = match ($lap) {
            0       => 'Pendidikan Telah Ditempuh',
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status',
            7       => 'Golongan Darah',
            9       => 'Cacat',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            12      => 'Pendidikan dalam KK',
            13      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

        $data['config'] = $configModel->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);

        view('statistik/penduduk_print', $data);
    }

    public function excel($lap = 0)
    {
        $configModel = new Config();

        $data['lap'] = $lap;

        $data['stat'] = match ($lap) {
            0       => 'Pendidikan Telah Ditempuh',
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status',
            7       => 'Golongan Darah',
            9       => 'Cacat',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            12      => 'Pendidikan dalam KK',
            13      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

        $data['config'] = $configModel->get_data();
        $data['main']   = $this->laporan_penduduk_model->list_data($lap);

        view('statistik/penduduk_excel', $data);
    }

    public function warga($lap = '', $data = '')
    {
        $configModel = new Config();

        $data['lap'] = $lap;

        $data['stat'] = match ($lap) {
            0       => 'Pendidikan Telah Ditempuh',
            1       => 'Pekerjaan',
            2       => 'Status Perkawinan',
            3       => 'Agama',
            4       => 'Jenis Kelamin',
            5       => 'Warga Negara',
            6       => 'Status',
            7       => 'Golongan Darah',
            9       => 'Cacat',
            10      => 'Sakit Menahun',
            11      => 'Jamkesmas',
            12      => 'Pendidikan dalam KK',
            13      => 'Umur',
            14      => 'Pendidikan Sedang Ditempuh',
            21      => 'Klasifikasi Sosial',
            22      => 'Penerima Raskin',
            23      => 'Penerima BLT',
            24      => 'Penerima BOS',
            25      => 'Penerima PKH',
            26      => 'Penerima Jampersal',
            27      => 'Penerima Bedah Rumah',
            default => 'Pendidikan',
        };

        $data['config'] = $configModel->get_data();
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
        // view('statistik/menu');
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
