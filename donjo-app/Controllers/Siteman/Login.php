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

        $this->load->model('user_model');
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

                // Redirect to the login view with a success message
                return redirect('login.view')->with('success', 'Welcome back!');
            }
        }

        // If validation fails or login fails, redirect back to the login view with an error message and input data preserved
        return redirect('login.view')->withInput()->with('error', 'Email and/or password not correct');
    }

    public function auth()
    {
        $this->user_model->siteman();

        return redirect()->to('main');
    }

    public function login()
    {
        $this->user_model->logout();

        return redirect()->to('siteman');
    }
}
