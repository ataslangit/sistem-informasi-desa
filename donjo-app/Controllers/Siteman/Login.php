<?php

namespace App\Controllers\Siteman;

use App\Models\User;
use Config\Services;
use Kenjis\CI3Compatible\Core\CI_Controller;

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('config_model');
    }

    /**
     * Menampilkan halaman login
     */
    public function index(): string
    {
        $data = [
            'title' => 'Masuk',
            'desa'  => $this->config_model->get_data(),
        ];

        return view('siteman/login', $data);
    }

    /**
     * Proses autentikasi ke halaman siteman
     */
    public function submit()
    {
        $validation = Services::validation();

        $validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $userModel = new User();
            $username  = $this->request->getPost('username');
            $password  = $this->request->getPost('password');

            $cari = $userModel->select('id,password,id_grup,session')->where('username', $username)->first();

            if ($cari !== null && hash_password($password) === $cari->password) {
                $userModel->save([
                    'session' => hash_password(time() . $password),
                ]);

                session()->set([
                    'logged_in'    => true,
                    'user_id'      => $cari->id,
                    'user_id_grup' => $cari->id_grup,
                    'user_name'    => $cari->username,
                    'user_email'   => $cari->email,
                ]);

                return redirect('login.view')->with('success', 'Halo, selamat datang kembali');
            }
        }

        return redirect('login.view')->withInput()->with('error', 'Silakan coba kembali.');
    }
}
