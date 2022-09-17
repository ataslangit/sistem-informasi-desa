<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User_model;

class Siteman extends BaseController
{
    /**
     * Menampilkan halaman login untuk pengurus website
     */
    public function index(): string
    {
        return view('admin/siteman', []);
    }

    public function check()
    {
        $validation = \Config\Services::validation();

        if ($this->request->getPost()) {
            $validation->setRules([
                'username' => ['label' => 'nama pengguna', 'rules' => 'required'],
                'password' => ['label' => 'kata sandi', 'rules' => 'required'],
            ]);
        }

        if (! $validation->withRequest($this->request)->run()) {
            return $this->index();
        }

        $userModel = new User_model();

        $cek_masuk = $userModel->masuk($this->request->getPost('username'), $this->request->getPost('password'));

        if (! $cek_masuk) {
            return $this->index();
        }

        return redirect()->to('siteman');
    }

    /**
     * Fungsi Logout
     */
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        // hapus session
        session()->remove(['id', 'username', 'sesi']);
        session()->set('masuk', false);

        return redirect()->to('siteman');
    }
}
