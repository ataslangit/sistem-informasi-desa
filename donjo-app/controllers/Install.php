<?php

class Install extends CI_Controller
{
    // menampilkan halaman install
    public function index()
    {
        if (is_installed()) {
            return redirect('/');
        }

        // jalankan proses instalasi
        // - atur database
        // - migrasi database
        // - jalankan seeder data awal
        // - jika memilih demo, jalankan seeder data demo, jika tidak lanjut ke proses selanjutnya
        // - atur user default
        // - selesai, buat file `installed`


        // buat file `installed`
        $file    = APPPATH . 'installed';
        $content = date('Y-m-d H:i:s');
        if (! file_exists($file)) {
            file_put_contents($file, $content);
        }

        return redirect('/');
    }
}
