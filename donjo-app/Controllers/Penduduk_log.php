<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller as BaseController;

class Penduduk_log extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            return redirect()->to('siteman');
        }

        $this->load->model('penduduk_model');
        $this->load->model('header_model');
    }

    public function clear()
    {
        session()->remove(['cari', 'filter', 'sex', 'dusun', 'rw', 'rt', 'agama', 'umur_min', 'umur_max', 'pekerjaan_id', 'status', 'pendidikan_id', 'status_penduduk']);

        $_SESSION['per_page'] = 200;
        $_SESSION['log']      = 1;

        return redirect()->to('penduduk_log');
    }

    public function index($p = 1, $o = 0)
    {
        $_SESSION['log'] = 1;
        $data['p']       = $p;
        $data['o']       = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_SESSION['sex'])) {
            $data['sex'] = $_SESSION['sex'];
        } else {
            $data['sex'] = '';
        }

        if (isset($_SESSION['dusun'])) {
            $data['dusun']   = $_SESSION['dusun'];
            $data['list_rw'] = $this->penduduk_model->list_rw($data['dusun']);

            if (isset($_SESSION['rw'])) {
                $data['rw']      = $_SESSION['rw'];
                $data['list_rt'] = $this->penduduk_model->list_rt($data['dusun'], $data['rw']);

                if (isset($_SESSION['rt'])) {
                    $data['rt'] = $_SESSION['rt'];
                } else {
                    $data['rt'] = '';
                }
            } else {
                $data['rw'] = '';
            }
        } else {
            $data['dusun'] = '';
            $data['rw']    = '';
            $data['rt']    = '';
        }
        if (isset($_SESSION['agama'])) {
            $data['agama'] = $_SESSION['agama'];
        } else {
            $data['agama'] = '';
        }
        if (isset($_SESSION['pekerjaan_id'])) {
            $data['pekerjaan_id'] = $_SESSION['pekerjaan_id'];
        } else {
            $data['pekerjaan_id'] = '';
        }
        if (isset($_SESSION['status'])) {
            $data['status'] = $_SESSION['status'];
        } else {
            $data['status'] = '';
        }
        if (isset($_SESSION['pendidikan_id'])) {
            $data['pendidikan_id'] = $_SESSION['pendidikan_id'];
        } else {
            $data['pendidikan_id'] = '';
        }
        if (isset($_SESSION['status_penduduk'])) {
            $data['status_penduduk'] = $_SESSION['status_penduduk'];
        } else {
            $data['status_penduduk'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']     = $this->penduduk_model->paging($p, $o, 1);
        $data['main']       = $this->penduduk_model->list_data($o, $data['paging']->offset, $data['paging']->per_page, 1);
        $data['keyword']    = $this->penduduk_model->autocomplete();
        $data['list_agama'] = $this->penduduk_model->list_agama();
        $data['list_dusun'] = $this->penduduk_model->list_dusun();

        $header     = $this->header_model->get_data();
        $nav['act'] = 2;

        echo view('header', $header);
        echo view('sid/nav', $nav);
        echo view('sid/kependudukan/penduduk_log', $data);
        echo view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            session()->remove('cari');
        }

        return redirect()->to('penduduk_log');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            session()->remove('filter');
        }

        return redirect()->to('penduduk_log');
    }

    public function sex()
    {
        $sex = $this->input->post('sex');
        if ($sex !== '') {
            $_SESSION['sex'] = $sex;
        } else {
            session()->remove('sex');
        }

        return redirect()->to('penduduk_log');
    }

    public function agama()
    {
        $agama = $this->input->post('agama');
        if ($agama !== '') {
            $_SESSION['agama'] = $agama;
        } else {
            session()->remove('agama');
        }

        return redirect()->to('penduduk_log');
    }

    public function dusun()
    {
        $dusun = $this->input->post('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            session()->remove('dusun');
        }

        return redirect()->to('penduduk_log');
    }

    public function rw()
    {
        $rw = $this->input->post('rw');
        if ($rw !== '') {
            $_SESSION['rw'] = $rw;
        } else {
            session()->remove('rw');
        }

        return redirect()->to('penduduk_log');
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt !== '') {
            $_SESSION['rt'] = $rt;
        } else {
            session()->remove('rt');
        }

        return redirect()->to('penduduk_log');
    }

    public function edit_status_dasar($p = 1, $o = 0, $id = 0)
    {
        $data['nik']         = $this->penduduk_model->get_penduduk($id);
        $data['form_action'] = site_url("penduduk_log/update_status_dasar/{$p}/{$o}/{$id}");
        echo view('sid/kependudukan/ajax_edit_status_dasar', $data);
    }

    public function update_status_dasar($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->update_status_dasar($id);
        redirect("penduduk_log/index/{$p}/{$o}");
    }

    public function cetak($o = 0)
    {
        $data['main'] = $this->penduduk_model->list_data($o, 0, 10000);
        echo view('sid/kependudukan/penduduk_print', $data);
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->penduduk_model->delete_all();
        redirect("penduduk_log/index/{$p}/{$o}");
    }
}
