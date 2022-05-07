<?php

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (! is_installed()) {
            return redirect('install');
        }
    }
}

class Public_Controller extends MY_Controller
{
    public $data;
    public $isSegment = 'home';
    public $theme     = 'default';

    public function __construct()
    {
        parent::__construct();

        $this->data = [
            'title' => 'SID',
        ];
    }

    /**
     * Menentukan tipe halaman
     * bernilai 'home' jika $url = ''
     * bernilai 'single' jika $url berformat '/tahun/bulan/tanggal/slug-post'
     * bernilai 'category' jika $url berformat '/kategori/slug-kategori'
     * bernilai 'page' jika $url berformat '/slug-page'
     */
    private function pageType(): string
    {
        // $url = current_url();
        $url = uri_string();
        $url = trim($url);

        if ($url === '') {
            return 'home';
        }

        // apakah $url berformat 'kategori/slug-kategori'
        if (preg_match('(^kategori\/([-_a-zA-Z0-9]+))', $url) === 1) {
            return 'category';
        }

        // apakah $url berformat 'tahun/bulan/tanggal/slug-post'
        if (preg_match('((\d{4})\/(\d{2})\/(\d{2})\/\w+)', $url) === 1) {
            return 'single';
        }

        return 'page';
    }

    // send $data to view
    public function view($data = [])
    {
        // jika folder $theme ditemukan pada THEMEPATH
        if (is_dir(THEMEPATH . $this->theme)) {
            $this->data = array_merge($this->data, $data);
            echo $this->load->view_theme($this->theme, $this->pageType(), $data);
        }
    }

    function include($file)
    {
        echo $this->load->view_theme($this->theme, $file);
    }
}
