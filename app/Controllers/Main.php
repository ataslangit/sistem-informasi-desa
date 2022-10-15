<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Main extends BaseController
{
    /**
     * Tampil halaman depan
     *
     * @return string
     */
    public function index()
    {
        $artikelModel = new ArtikelModel();

        $data = [
            'artikel' => $artikelModel->ambilPos()->orderBy('tgl_upload desc')->paginate(5),
            'pager'   => $artikelModel->pager,
        ];

        return view('frontend/main', $data);
    }

    /**
     * Tampil halaman detail artikel
     *
     * @return string
     */
    public function detail_artikel(string $slug)
    {
        if (empty($slug)) {
            log_message('error', '$slug is required');

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan');
        }

        $artikelModel = new ArtikelModel();
        // ambil ID artikel, pada versi lama, $slug merupakan ID artikel
        // jika contoh : /first/artikel/33-panduan-pelayanan-satu-pintu-desa-bumi-pertiwi
        // maka ID artikel adalah 33, dash ( - ) setelahnya tidak digunakan

        // pisahkan angka pada $slug
        preg_match_all('/\\d+/', $slug, $angka);
        $idArtikel = $angka[0] !== [] ? $angka[0][0] : 0;

        if (! $artikel = $artikelModel->ambilPos()->find($idArtikel)) {
            log_message('error', 'Artikel not found');

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        $data = [
            'artikel' => $artikel,
        ];

        return view('frontend/artikel_detail', $data);
    }

    public function initial()
    {
        echo view('install');
    }

    public function install()
    {
        $out = $this->config_model->initial();
        echo view('init', $out);
    }

    public function init($out = null)
    {
        echo view('init', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = $this->header_model->get_config();
        echo view('siteman', $header);
    }
}
