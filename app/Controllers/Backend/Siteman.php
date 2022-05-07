<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Siteman extends BaseController
{
    /**
     * Tampilkan halaman login
     *
     * @return string
     */
    public function index()
    {
        // validation
        $validation = \Config\Services::validation();

        $data = [
            'title'      => 'Masuk',
            'validation' => $validation,
        ];

        return view('backend/siteman', $data);
    }

    /**
     * Proses login
     */
    public function auth()
    {
        // validation
        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return $this->index();
        }

        // var_dump($this->request->getPost());

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
    }
}
