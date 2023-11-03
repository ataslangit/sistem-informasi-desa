<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Encryption\Encryption;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use Config\Services;
use Exception;

class Install extends BaseController
{
    /**
     * Menampilkan halaman install
     *
     * @return RedirectResponse|string
     */
    public function index()
    {
        $step = $this->request->getGet('step') ?? 'intro';

        if (in_array($step, ['intro', 'migrasi', 'finish'], true)) {
            return $this->{$step}();
        }

        return redirect('install.view')->with('info', 'Ada kesalahan pada halaman yang diakses.');
    }

    /**
     * Proses instalasi / menjalankan migrasi DB
     *
     * @return RedirectResponse|string
     *
     * @throws Exception
     */
    public function submit()
    {
        $validation = Services::validation();

        if ($this->request->getPost()) {
            // make rules validation for signin
            $validation->setRules([
                'db_name'    => ['label' => 'nama database', 'rules' => 'required'],
                'db_user'    => ['label' => 'database username', 'rules' => 'required'],
                'db_pass'    => ['label' => 'database password', 'rules' => 'required'],
                'db_host'    => ['label' => 'database host', 'rules' => 'required'],
                'user_name'  => ['label' => 'nama user', 'rules' => 'required'],
                'user_pass'  => ['label' => 'katasandi', 'rules' => 'required_with[user_pass2]'],
                'user_pass2' => ['label' => 'ulangi katasandi', 'rules' => 'required_with[user_pass]'],
                'user_mail'  => ['label' => 'email', 'rules' => 'required|valid_email'],
            ]);
        }

        if (! $validation->withRequest($this->request)->run()) {
            return $this->index();
        }

        $keys = [
            'database.default.hostname' => $this->request->getPost('db_host'),
            'database.default.database' => $this->request->getPost('db_name'),
            'database.default.username' => $this->request->getPost('db_user'),
            'database.default.password' => $this->request->getPost('db_pass'),
            'encryption.key'            => 'hex2bin:' . bin2hex(Encryption::createKey(32)),
        ];

        $data_new_user = [
            'username'   => $this->request->getPost('user_name'),
            'password'   => hash_password($this->request->getPost('user_pass')),
            'email'      => $this->request->getPost('user_mail'),
            'nama'       => $this->request->getPost('user_name'),
            'id_grup'    => '1',
            'last_login' => date('Y-m-d H:i:s'),
        ];

        // buat file .env berdasarkan env
        $baseEnv = ROOTPATH . 'env';
        $envFile = ROOTPATH . '.env';

        if (! is_file($envFile)) {
            if (! is_file($baseEnv)) {
                $info = 'Tidak ditemukan file `env`.';
                log_message('error', $info);

                return redirect('install.view')->with('info', $info);
            }

            copy($baseEnv, $envFile);
        }

        $this->settingEnv($envFile, $keys);

        return redirect()->to(current_url() . '?step=migrasi')->with('data_new_user', $data_new_user);
    }

    /**
     * Proses update file .env
     *
     * @param string $envFile   Lokasi file .env
     * @param array  $keyValues Nilai baru berupa array untuk perbarui .env
     */
    protected function settingEnv(string $envFile, array $keyValues): bool
    {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES);

        // Loop melalui array dan hanya ubah nilai jika baris dimulai dengan "#" (komentar)
        foreach ($keyValues as $key => $value) {
            foreach ($lines as &$line) {
                if (preg_match('/^#?\s*' . preg_quote($key) . '\s*=\s*(.*)/', $line, $matches)) {
                    $line = "{$key} = {$value}";
                }
            }
        }

        // Simpan kembali array ke dalam file .env
        return file_put_contents($envFile, implode("\n", $lines)) !== false;
    }

    /**
     * Halaman utama install
     */
    private function intro(): string
    {
        return view('install/index');
    }

    /**
     * Halaman dan proses migrasi database
     *
     * @return RedirectResponse Redirect ke step selanjutnya
     */
    private function migrasi(): RedirectResponse
    {
        $migrate = Services::migrations();
        $migrate->latest();

        // simpan data user ke db
        $userModel = new User();

        $userModel->save(session()->get('data_new_user'));

        return redirect()->to(current_url() . '?step=finish');
    }

    /**
     * Menampilhan halaman selesai proses install
     * dan juga menambahkan file `install.sid`
     */
    private function finish(): string
    {
        $time   = new Time();
        $handle = fopen(ROOTPATH . 'install.sid', 'w+b');

        fwrite($handle, 'SID terinstall pada ' . $time->toDateTimeString());
        fclose($handle);

        return view('install/finish');
    }
}
