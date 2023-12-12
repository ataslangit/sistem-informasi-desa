<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Feed extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Artikel');
        $this->load->model('config_model');
    }

    /**
     * Menampilkan feed
     *
     * @return string
     */
    public function index()
    {
        $artikelModel = new Artikel();

        $dataArtikel = $artikelModel->setAlias('a')->find()
            ->select('a.*, u.nama AS owner, k.kategori')
            ->join('user AS u', 'a.id_user = u.id')
            ->join('kategori AS k', 'a.id_kategori = k.id')
            ->where(['a.enabled' => '1', 'a.judul <>' => ''])
            ->order_by('a.id', 'DESC')
            ->get()
            ->result_array();

        $isiFeed = [];

        foreach ($dataArtikel as $data) {
            $isiFeed[$data['id']]['no']       = $data['id'];
            $isiFeed[$data['id']]['tgl']      = $data['tgl_upload'];
            $isiFeed[$data['id']]['judul']    = $data['judul'];
            $isiFeed[$data['id']]['feed_url'] = site_url('feed/');
            $isiFeed[$data['id']]['url']      = site_url('first/artikel/' . $data['id'] . '/');
            $str_isi                          = fixTag($data['isi']);
            if (strlen($str_isi) > 300) {
                $isiFeed[$data['id']]['isi'] = substr($str_isi, 0, strpos($str_isi, ' ', 260)) . '...';
            } else {
                $isiFeed[$data['id']]['isi'] = $str_isi;
            }

            $isiFeed[$data['id']]['author']   = $data['owner'];
            $isiFeed[$data['id']]['kategori'] = $data['kategori'];
        }

        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        echo view('feed', $data);
    }
}
