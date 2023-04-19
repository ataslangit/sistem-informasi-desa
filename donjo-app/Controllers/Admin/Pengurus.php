<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pamong;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;

class Pengurus extends BaseController
{
    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('pengurus');
    }

    /**
     * Menampilkan halaman pengurus (daftar pengurus)
     */
    public function index(): string
    {
        $pamongDesaModel = new Pamong();
        $filter          = $this->request->getGet('filter') ?? '0';
        $cari            = $data['cari'] = $this->request->getGet('cari') ?? '';

        $data['main']    = $pamongDesaModel->status((int) $filter)->search($cari)->findAll();
        $data['keyword'] = $pamongDesaModel->autocomplete();
        $data['filter']  = str_replace('0', '', $filter);

        return view('admin/pengurus/index', $data);
    }

    /**
     * Menampilkan halaman tambah pengurus (form)
     */
    public function create(): string
    {
        return view('admin/pengurus/create');
    }

    /**
     * Memproses simpan ke database
     */
    public function submit(): RedirectResponse
    {
        $validation = \Config\Services::validation();

        if ($this->request->getPost()) {
            $validation->setRules([
                'pamong_nama'   => ['label' => 'nama', 'rules' => 'required|alpha_numeric_space|max_length[100]'],
                'pamong_nik'    => ['label' => 'NIK', 'rules' => 'required|is_natural|max_length[20]'],
                'pamong_nip'    => ['label' => 'NIP', 'rules' => 'required|is_natural|max_length[20]'],
                'pamong_status' => ['label' => 'status', 'rules' => 'required|in_list[1,2]'],
                'jabatan'       => ['label' => 'jabatan', 'rules' => 'required|max_length[50]'],
            ]);
        }

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $pamongDesaModel = new Pamong();

        $pamongDesaModel->save([
            'pamong_nama'          => $this->request->getPost('pamong_nama'),
            'pamong_nik'           => $this->request->getPost('pamong_nik'),
            'pamong_nip'           => $this->request->getPost('pamong_nip'),
            'pamong_status'        => $this->request->getPost('pamong_status'),
            'jabatan'              => $this->request->getPost('jabatan'),
            'pamong_tgl_terdaftar' => Time::now()->toDateTimeString(),
        ]);

        return redirect('admin.pengurus.index');
    }

    /**
     * Menampilkan halaman edit pengurus (form)
     */
    public function edit(int $id): string
    {
        $pamongDesaModel = new Pamong();
        $data['pamong']  = $pamongDesaModel->find($id);

        return view('admin/pengurus/edit', $data);
    }

    /**
     * Proses update data ke database
     */
    public function update(): RedirectResponse
    {
        $validation = \Config\Services::validation();

        if ($this->request->getPost()) {
            $validation->setRules([
                'pamong_id'     => ['label' => 'pamong ID', 'rules' => 'required|integer'],
                'pamong_nama'   => ['label' => 'Nama', 'rules' => 'required|alpha_numeric_space|max_length[100]'],
                'pamong_nik'    => ['label' => 'NIK', 'rules' => 'required|is_natural|max_length[20]'],
                'pamong_nip'    => ['label' => 'NIP', 'rules' => 'required|is_natural|max_length[20]'],
                'pamong_status' => ['label' => 'status', 'rules' => 'required|in_list[1,2]'],
                'jabatan'       => ['label' => 'jabatan', 'rules' => 'required|max_length[50]'],
            ]);
        }

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $pamongDesaModel = new Pamong();

        $pamongDesaModel->save([
            'pamong_id'     => $this->request->getPost('pamong_id'),
            'pamong_nama'   => $this->request->getPost('pamong_nama'),
            'pamong_nik'    => $this->request->getPost('pamong_nik'),
            'pamong_nip'    => $this->request->getPost('pamong_nip'),
            'pamong_status' => $this->request->getPost('pamong_status'),
            'jabatan'       => $this->request->getPost('jabatan'),
        ]);

        return redirect('admin.pengurus.index');
    }

    /**
     * Proses hapus data pamong
     */
    public function delete(int $id): RedirectResponse
    {
        $pamongDesaModel = new Pamong();

        $pamongDesaModel->delete($id);

        return redirect('admin.pengurus.index');
    }

    /**
     * Proses hapus semua data pamong (yang terseleksi)
     */
    public function delete_all(): RedirectResponse
    {
        $pamongDesaModel = new Pamong();
        $ids             = $this->request->getPost('id_cb');

        $pamongDesaModel->delete($ids);

        return redirect('admin.pengurus.index');
    }
}
