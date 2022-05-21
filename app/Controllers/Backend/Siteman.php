<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\User_model;

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

        // lolos validasi
        $userModel = new User_model();
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');

        $logged = $userModel->logged($username, $password);

        if ($logged) {
            // login berhasil
            return redirect()->to('/siteman')->with('message', 'Selamat datang kembali.');
        }
    }
}
