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

            $cari = $userModel->select('id,password,id_grup,session')->where('username', $username)->findAll();

            dd($cari);

            // Try to find a user based on the submitted email address
            $find = $userModel->where('email', $this->request->getPost('email'))->first();

            // Check if user exists and if the submitted password matches the hashed password in the database
            if ($find !== null && password_verify($this->request->getPost('password'), $find->password)) {
                // Set session data for the user
                session()->set([
                    'logged_in'  => true,
                    'user_id'    => $find->id,
                    'user_email' => $find->email,
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
