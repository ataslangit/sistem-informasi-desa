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

        // ambil data artikel
        $artikel = $artikelModel->where('enabled', '1')->findAll();

        return $this->view->setData(['artikel' => $artikel])->render('main');
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
