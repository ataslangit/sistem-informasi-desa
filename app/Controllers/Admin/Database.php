<?php

namespace App\Controllers;

class Database extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->dbforge();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1'], true)) {
            redirect('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('export');
    }

    public function index()
    {
        $nav['act'] = 1;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('nav', $nav);
        echo view('export/exp');
        echo view('footer');
    }

    public function import()
    {
        $nav['act']           = 2;
        $data['form_action']  = site_url('admin/database/import_dasar');
        $data['form_action3'] = site_url('admin/database/ppls_individu');
        $header               = $this->header_model->get_data();
        echo view('header', $header);
        echo view('nav', $nav);
        echo view('import/imp', $data);
        echo view('footer');
    }

    public function siak()
    {
        $nav['act']          = 6;
        $data['form_action'] = site_url('admin/database/import_siak');
        $header              = $this->header_model->get_data();
        echo view('header', $header);
        echo view('nav', $nav);
        echo view('import/siak', $data);
        echo view('footer');
    }

    public function import_ppls()
    {
        $nav['act']           = 4;
        $data['form_action3'] = site_url('admin/database/ppls_individu');
        $data['form_action2'] = site_url('admin/database/ppls_rumahtangga');
        //$data['form_action'] = site_url("database/ppls_kuisioner");
        $header = $this->header_model->get_data();
        echo view('header', $header);
        echo view('nav', $nav);
        echo view('import/ppls', $data);
        echo view('footer');
    }

    public function backup()
    {
        $nav['act']          = 3;
        $data['form_action'] = site_url('admin/database/restore');
        $header              = $this->header_model->get_data();
        echo view('header', $header);
        echo view('nav', $nav);
        echo view('database/backup', $data);
        echo view('footer');
    }

    public function export_dasar()
    {
        $this->export_model->export_dasar();
    }

    public function export_akp()
    {
        $this->export_model->export_akp();
    }

    public function import2()
    {
        $nav['act']           = 2;
        $data['form_action']  = site_url('admin/database/import_dasar');
        $data['form_action2'] = site_url('admin/database/import_akp');
        $header               = $this->header_model->get_data();
        echo view('header', $header);
        echo view('export/nav', $nav);
        echo view('export/imp', $data);
        echo view('footer');
    }

    public function pre_migrate()
    {
        $nav['act'] = 3;
        $header     = $this->header_model->get_data();
        echo view('header', $header);
        echo view('export/nav', $nav);
        echo view('export/mig');
        echo view('footer');
    }

    public function migrate()
    {
        $this->dbforge->drop_table('tweb_dusun_x');
        $this->dbforge->drop_table('tweb_rw_x');
        $this->dbforge->drop_table('tweb_rt_x');
        $this->dbforge->drop_table('tweb_keluarga_x');
        $this->dbforge->drop_table('tweb_keluarga_x_pindah');
        $this->dbforge->drop_table('tweb_penduduk_x');
        $this->dbforge->drop_table('tweb_penduduk_x_pindah');
    }

    public function import_dasar()
    {
        $this->import_model->import_excel();
        redirect('admin/database/import/1');
    }

    public function ppls_kuisioner()
    {
        $this->import_model->ppls_kuisioner();
        redirect('admin/database/import_ppls/1');
    }

    public function ppls_individu()
    {
        $this->import_model->pbdt_individu();
        // redirect('admin/database/import_ppls');
    }

    public function ppls_rumahtangga()
    {
        $this->import_model->pbdt_rumahtangga();
        redirect('admin/database/import_ppls/1');
    }

    public function import_siak()
    {
        $data['siak']     = $this->import_model->import_siak();
        $_SESSION['SIAK'] = $data['siak'];
        redirect('admin/database/import/3');
    }

    public function import_akp()
    {
        $this->import_model->import_akp();
        redirect('admin/database/import');
    }

    public function jos()
    {
        $this->export_model->analisis();
        redirect('admin/database/import');
    }

    public function jos2()
    {
        $this->export_model->analisis2();
        redirect('admin/database/import');
    }

    public function exec_backup()
    {
        echo view('database/export');
        //	redirect('database/backup');
    }

    public function restore()
    {
        $this->export_model->restore();
        //	redirect('database/backup');
    }

    public function ces()
    {
        $this->export_model->lombok();
        redirect('admin/database/import');
    }

    public function surat()
    {
        $this->export_model->gawe_surat();
        // redirect('admin/database/import');
    }

    public function export_excel()
    {
        $data['main'] = $this->export_model->export_excel();
        echo view('export/penduduk_excel', $data);
    }

    public function export_csv()
    {
        $data['main'] = $this->export_model->export_excel();
        echo view('export/penduduk_csv', $data);
    }
}
