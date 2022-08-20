<?php

namespace App\Controllers;

class Laporan_rentan extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3'], true)) {
            return redirect()->to('siteman');
        }

        $_SESSION['success']  = 0;
        $_SESSION['per_page'] = 20;
        $_SESSION['cari']     = '';
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt']);

        return redirect()->to('laporan_rentan');
    }

    public function index()
    {
        if (isset($_SESSION['dusun'])) {
            $data['dusun'] = $_SESSION['dusun'];
        } else {
            $data['dusun'] = '';
        }

        $data['list_dusun'] = $this->laporan_bulanan_model->list_dusun();
        $data['config']     = $this->laporan_bulanan_model->configku();

        $data['main'] = $this->laporan_bulanan_model->list_data();

        $nav['act'] = 2;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('statistik/nav', $nav);
        echo view('laporan/kelompok', $data);
        echo view('footer');
    }

    public function cetak()
    {
        $data['config'] = $this->laporan_bulanan_model->configku();
        $data['main']   = $this->laporan_bulanan_model->list_data();
        echo view('laporan/kelompok_print', $data);
    }

    public function excel()
    {
        $data['config'] = $this->laporan_bulanan_model->configku();
        $data['main']   = $this->laporan_bulanan_model->list_data();
        echo view('laporan/kelompok_excel', $data);
    }

    public function dusun()
    {
        $dusun = $this->request->getPost('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            unset($_SESSION['dusun']);
        }

        return redirect()->to('laporan_rentan');
    }
}