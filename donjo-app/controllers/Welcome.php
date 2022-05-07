<?php

class Welcome extends Public_Controller
{
    // menampilkan halaman utama situs
    public function index()
    {
        return $this->view('layouts/main.tpl.php', []);
    }

    public function detail(string $tanggal, string $slug)
    {
        return $this->view('layouts/main.tpl.php', []);
    }

    public function kategori(string $slug)
    {
        return $this->view('layouts/main.tpl.php', []);
    }
}
