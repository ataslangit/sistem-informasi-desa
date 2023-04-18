<?php

namespace App\Controllers;

use App\Models\Config_model;
use App\Models\User_model;
use CodeIgniter\I18n\Time;

class Siteman extends BaseController
{
    /**
     * Menampilkan halaman view login siteman
     */
    public function index(): string
    {
        $configModel = new Config_model();
        $header      = [
            'desa' => $configModel->get_data(),
        ];

        return view('siteman', $header);
    }

    /**
     * Memproses login dari halaman view siteman
     */
    public function auth(): \CodeIgniter\HTTP\RedirectResponse
    {
        $userModel = new User_model();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $message  = 'Login Gagal. Username atau Password yang Anda masukkan salah!';

        $row = $userModel->select('id,password,session,id_grup')
            ->where('username', $username)->first();

        if ($row !== null) {
            if (hash_password($password) === $row['password']) {
                $sesi = hash_password(time() . $password);

                session()->set([
                    'loggedIn' => true,
                    'sesi'     => $sesi,
                    'userId'   => $row['id'],
                    'grup'     => $row['id_grup'],
                    'timeout'  => time() + 3600,
                ]);

                // update tabel user
                $userModel->update($row['id'], [
                    'session'    => $sesi,
                    'last_login' => Time::now()->toDateTimeString(),
                ]);

                $message = 'Login Berhasil.';
            } else {
                session()->set([
                    'loggedIn' => false,
                ]);
            }
        } else {
            session()->set([
                'loggedIn' => false,
            ]);
        }

        return redirect()->back()->with('alert', $message);
    }
}
