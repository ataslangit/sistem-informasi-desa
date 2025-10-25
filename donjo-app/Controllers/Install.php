<?php

use App\Libraries\Install as InstallLib;

class Install extends InstallController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('header_model');
        $this->load->model('user_model');
        $this->load->model('config_model');
    }

    /**
     * View halaman installasi.
     *
     * @return string
     */
    public function index()
    {
        return view('install/index');
    }

    /**
     * Proses installasi database
     *
     * @todo Perbaiki proses installasi
     *
     * @return string|void
     */
    public function run()
    {
        $install = new InstallLib();
        $out     = $install->run();

        if (null === $out) {
            return redirect('/');
        }

        return view('install/done', $out);
    }
}
