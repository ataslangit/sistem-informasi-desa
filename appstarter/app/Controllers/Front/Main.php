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
                return redirect()->to(makeUrl($artikel['tgl_upload'], $artikel['id']));
            }
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
            $this->response->setStatusCode(404);

            return $this->view->setData(['title' => 'Error 404! Data tidak ditemukan.'])->render('404');
        }

        return $this->view->setData($data)->render('main');
    }

    public function detail(string $tanggal, string $slug)
    {
        // var_dump($tanggal, $slug);
        return $this->view->setVar('data', ['blogs' => []])->render('single');
    }

    public function kategori(string $slug)
    {
        // var_dump($slug);
        return $this->view->setVar('data', ['blogs' => []])->render('category');
    }
}
