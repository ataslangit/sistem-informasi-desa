<?php

namespace App\Controllers\Siteman;

use App\Models\User;
use CodeIgniter\HTTP\RedirectResponse;
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
     *
     * @return RedirectResponse|string
     */
    public function submit()
    {
        if (! $this->request->is('post')) {
            return $this->index();
        }

        $rules = [
            'username' => ['label' => 'Username', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
        ];

        if (! $this->validate($rules)) {
            return $this->index();
        }

        $userModel = new User();
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');

        $cari = $userModel->select('id,password,username,id_grup,session')->where('username', $username)->first();

        if ($cari !== null && hash_password($password) === $cari->password) {
            $sess = hash_password(time() . $password);
            $userModel->save([
                'id'      => $cari->id,
                'session' => $sess,
            ]);

            session()->set([
                'siteman'   => 1,
                'user'      => $cari->id,
                'grup'      => $cari->id_grup,
                'user_name' => $cari->username,
                // 'user_email' => $cari->email,
                'sesi'     => $sess,
                'per_page' => 10,
            ]);

            // TODO: ganti url target redirect menggunakan nama route
            return redirect()->to('hom_desa')->with('success', 'Halo, selamat datang kembali');
        }

        return redirect('login.view')->withInput()->with('error', 'Silakan coba kembali.');
    }
}
