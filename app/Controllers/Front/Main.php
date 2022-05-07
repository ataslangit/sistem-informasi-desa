<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Artikel;

class Main extends BaseController
{
    public function index()
    {
        $artikelModel = new Artikel();

        // if exist param `pid`, then redirect to detail post
        $pid = $this->request->getGet('p');
        if ($pid && is_numeric($pid)) {
            $artikel = $artikelModel->find($pid);

            if ($artikel !== null) {
                if (! isset($artikel['slug'])) {
                    return redirect()->to(makeUrl($artikel['tgl_upload'], url_title($artikel['judul'], '-', true) . '____' . $artikel['id']));
                }

                return redirect()->to(makeUrl($artikel['tgl_upload'], $artikel['slug']));
            }

            return $this->show404();
        }

        $page  = $this->request->getGet('page');
        $limit = config('Pager')->perPage;

        $page = $offset = $page ?: 1;
        if ($page === 1) {
            $offset = 0;
        }

        $artikel   = $artikelModel->where('enabled', '1')->orderBy('tgl_upload', 'desc')->findAll($limit, $offset);
        $totalPage = $artikelModel->where('enabled', '1')->countAllResults(true);
        $pager     = \Config\Services::pager();

        $data = [
            'artikel'    => $artikel,
            'pagination' => $pager->makeLinks($page, $limit, $totalPage),
        ];

        // jika $page melebihi jumlah halaman maka tampilkan error
        if ($page > ceil($totalPage / $limit)) {
            // throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
            return $this->show404();
        }

        return $this->view->setData($data)->render('main');
    }

    public function detail(string $tanggal, string $slug)
    {
        $id = false;
        // check slug, is has 4 underscore?
        if (strpos($slug, '____') !== false) {
            // get last string with separator with 4 underscore
            $slug = explode('____', $slug);
            $id   = end($slug);
        }

        $artikelModel = new Artikel();

        // jika $id tidak sama dengan false maka cari berdasarkan id
        if ($id !== false) {
            $artikel = $artikelModel->where(['DATE(tgl_upload)' => $tanggal, 'id' => $id])->first();
        } else {
            $artikel = $artikelModel->where('DATE(tgl_upload)', $tanggal)->where('slug', $slug)->first();
        }

        if ($artikel === null) {
            return $this->show404();
        }

        $data = [
            'artikel' => $artikel,
        ];

        return $this->view->setData($data)->render('single');
    }

    public function kategori(string $slug)
    {
        // var_dump($slug);
        return $this->view->setVar('data', ['blogs' => []])->render('category');
    }
}
