<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Penduduk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2') {
            redirect('siteman');
        }

        $this->load->model('config_model');
        $this->load->model('header_model');
        $this->load->model('penduduk_model');
    }

    public function clear()
    {
        unset($_SESSION['log']);
        $_SESSION['status_dasar'] = 1;
        unset($_SESSION['judul_statistik'], $_SESSION['judul_statistik_cetak'], $_SESSION['cari'], $_SESSION['duplikat'], $_SESSION['filter'], $_SESSION['sex'], $_SESSION['warganegara'], $_SESSION['cacat'], $_SESSION['menahun'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['hubungan'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['pendidikan_sedang_id'], $_SESSION['pendidikan_kk_id'], $_SESSION['status_penduduk'], $_SESSION['hamil'], $_SESSION['status'], $_SESSION['umurx'], $_SESSION['cacatx'], $_SESSION['menahunx']);

        $_SESSION['per_page'] = 50;
        redirect('penduduk');
    }

    public function index($p = 1, $o = 0)
    {
        unset($_SESSION['log']);
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['judul_statistik'])) {
            $data['judul_statistik'] = $_SESSION['judul_statistik'];
        } else {
            $data['judul_statistik'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_SESSION['status_dasar'])) {
            $data['status_dasar'] = $_SESSION['status_dasar'];
        } else {
            $data['status_dasar'] = '1';
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

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['grup']       = $this->user_model->sesi_grup($_SESSION['sesi']);
        $data['paging']     = $this->penduduk_model->paging($p, $o);
        $data['main']       = $this->penduduk_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']    = $this->penduduk_model->autocomplete();
        $data['list_agama'] = $this->penduduk_model->list_agama();
        $data['list_dusun'] = $this->penduduk_model->list_dusun();

        $header     = $this->header_model->get_data();
        $nav['act'] = 2;

        $data['info'] = $this->penduduk_model->get_filter();

        view('header', $header);
        view('sid/nav', $nav);
        view('sid/kependudukan/penduduk', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_POST['dusun'])) {
            $data['dus_sel'] = $_POST['dusun'];
        } else {
            $data['dus_sel'] = '';
        }

        if (isset($_POST['rw'])) {
            $data['rw_sel'] = $_POST['rw'];
        } else {
            $data['rw_sel'] = '';
        }

        if (isset($_POST['rt'])) {
            $data['rt_sel'] = $_POST['rt'];
        } else {
            $data['rt_sel'] = '';
        }

        if ($id) {
            $data['penduduk']     = $this->penduduk_model->get_penduduk($id);
            $data['form_action']  = site_url("penduduk/update/{$p}/{$o}/{$id}");
            $data['list_dokumen'] = $this->penduduk_model->list_dokumen($id);
        } else {
            $data['penduduk']     = null;
            $data['form_action']  = site_url('penduduk/insert');
            $data['list_dokumen'] = null;
        }

        $header                    = $this->header_model->get_data();
        $data['dusun']             = $this->penduduk_model->list_dusun();
        $data['rw']                = $this->penduduk_model->list_rw($data['dus_sel']);
        $data['rt']                = $this->penduduk_model->list_rt($data['dus_sel'], $data['rw_sel']);
        $data['agama']             = $this->penduduk_model->list_agama();
        $data['pendidikan_sedang'] = $this->penduduk_model->list_pendidikan_sedang();
        $data['pendidikan_kk']     = $this->penduduk_model->list_pendidikan_kk();
        $data['pekerjaan']         = $this->penduduk_model->list_pekerjaan();
        $data['warganegara']       = $this->penduduk_model->list_warganegara();
        $data['hubungan']          = $this->penduduk_model->list_hubungan();
        $data['kawin']             = $this->penduduk_model->list_status_kawin();
        $data['golongan_darah']    = $this->penduduk_model->list_golongan_darah();
        $data['cacat']             = $this->penduduk_model->list_cacat();
        $data['sakit_menahun']     = $this->penduduk_model->list_sakit_menahun();

        view('header', $header);
        $nav['act'] = 2;
        view('sid/nav', $nav);
        view('sid/kependudukan/penduduk_form', $data);
        view('footer');
    }

    public function detail($p = 1, $o = 0, $id = '')
    {
        $data['p']             = $p;
        $data['o']             = $o;
        $data['list_dokumen']  = $this->penduduk_model->list_dokumen($id);
        $data['list_kelompok'] = $this->penduduk_model->list_kelompok($id);
        $data['penduduk']      = $this->penduduk_model->get_penduduk($id);
        $header                = $this->header_model->get_data();

        view('header', $header);
        $nav['act'] = 2;
        view('sid/nav', $nav);
        view('sid/kependudukan/penduduk_detail', $data);
        view('footer');
    }

    public function dokumen($id = '')
    {
        $data['list_dokumen'] = $this->penduduk_model->list_dokumen($id);
        $data['penduduk']     = $this->penduduk_model->get_penduduk($id);
        $header               = $this->header_model->get_data();

        view('header', $header);
        $nav['act'] = 2;
        view('sid/nav', $nav);
        view('sid/kependudukan/penduduk_dokumen', $data);
        view('footer');
    }

    public function dokumen_form($id = 0)
    {
        $data['penduduk']    = $this->penduduk_model->get_penduduk($id);
        $data['form_action'] = site_url('penduduk/dokumen_insert');
        view('sid/kependudukan/dokumen_form', $data);
    }

    public function dokumen_list($id = 0)
    {
        $data['list_dokumen'] = $this->penduduk_model->list_dokumen($id);
        $data['penduduk']     = $this->penduduk_model->get_penduduk($id);
        view('sid/kependudukan/dokumen_ajax', $data);
    }

    public function dokumen_insert()
    {
        $this->penduduk_model->dokumen_insert();
        $id = $_POST['id_pend'];
        redirect("penduduk/dokumen/{$id}");
    }

    public function delete_dokumen($id_pend = 0, $id = '')
    {
        $this->penduduk_model->delete_dokumen($id);
        redirect("penduduk/dokumen/{$id_pend}");
    }

    public function delete_all_dokumen($id_pend = 0)
    {
        $this->penduduk_model->delete_all_dokumen();
        redirect("penduduk/dokumen/{$id_pend}");
    }

    public function cetak_biodata($id = '')
    {
        $data['desa']     = $this->header_model->get_data();
        $data['penduduk'] = $this->penduduk_model->get_penduduk($id);
        view('sid/kependudukan/cetak_biodata', $data);
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('penduduk');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('penduduk');
    }

    public function duplikat()
    {
        $_SESSION['duplikat'] = 1;
        redirect('penduduk');
    }

    public function status_dasar()
    {
        $status_dasar = $this->input->post('status_dasar');
        if ($status_dasar !== '') {
            $_SESSION['status_dasar'] = $status_dasar;
        } else {
            unset($_SESSION['status_dasar']);
        }
        redirect('penduduk');
    }

    public function sex()
    {
        $sex = $this->input->post('sex');
        if ($sex !== '') {
            $_SESSION['sex'] = $sex;
        } else {
            unset($_SESSION['sex']);
        }
        redirect('penduduk');
    }

    public function agama()
    {
        $agama = $this->input->post('agama');
        if ($agama !== '') {
            $_SESSION['agama'] = $agama;
        } else {
            unset($_SESSION['agama']);
        }
        redirect('penduduk');
    }

    public function warganegara()
    {
        $warganegara = $this->input->post('warganegara');
        if ($warganegara !== '') {
            $_SESSION['warganegara'] = $warganegara;
        } else {
            unset($_SESSION['warganegara']);
        }
        redirect('penduduk');
    }

    public function dusun()
    {
        unset($_SESSION['rw'], $_SESSION['rt']);

        $dusun = $this->input->post('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            unset($_SESSION['dusun']);
        }
        redirect('penduduk');
    }

    public function rw()
    {
        unset($_SESSION['rt']);
        $rw = $this->input->post('rw');
        if ($rw !== '') {
            $_SESSION['rw'] = $rw;
        } else {
            unset($_SESSION['rw']);
        }
        redirect('penduduk');
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt !== '') {
            $_SESSION['rt'] = $rt;
        } else {
            unset($_SESSION['rt']);
        }
        redirect('penduduk');
    }

    public function insert()
    {
        $data = $this->penduduk_model->dn();

        $i    = 0;
        $dp   = 0;
        $link = site_url() . 'penduduk/form';

        while ($i < count($data)) {
            if ($_POST['nik'] === $data[$i]['nik']) {
                $dp = 1;
                $nk = $data[$i]['nik'];
            }

            $i++;
        }
        if ($dp === 1) {
            echo "<h3>TERJADI KESALAHAN</h3><br><h4>Data Tidak Tersimpan</h><br>
			Sudah terdapat Penduduk dengan nomor NIK {$nk}, Silahkan periksa kembali dan ulangi proses memasukkan data.</br>
			Klik disini untuk <a href='{$link}'> Kembali</a>";
        } else {
            $this->penduduk_model->insert();
            redirect('penduduk');
        }
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->update($id);
        redirect("penduduk/index/{$p}/{$o}");
    }

    public function delete_confirm($p = 1, $o = 0, $id = '')
    {
        $data['form_action'] = site_url("penduduk/index/{$p}/{$o}/{$id}");
        view('sid/kependudukan/ajax_delete', $data);
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->delete($id);
        redirect("penduduk/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->penduduk_model->delete_all();
        redirect("penduduk/index/{$p}/{$o}");
    }

    public function ajax_adv_search()
    {
        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['judul_statistik'])) {
            $data['judul_statistik'] = $_SESSION['judul_statistik'];
        } else {
            $data['judul_statistik'] = '';
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

        if (isset($_SESSION['hubungan'])) {
            $data['hubungan'] = $_SESSION['hubungan'];
        } else {
            $data['hubungan'] = '';
        }

        if (isset($_SESSION['umur_min'])) {
            $data['umur_min'] = $_SESSION['umur_min'];
        } else {
            $data['umur_min'] = '';
        }

        if (isset($_SESSION['umur_max'])) {
            $data['umur_max'] = $_SESSION['umur_max'];
        } else {
            $data['umur_max'] = '';
        }

        if (isset($_SESSION['agama'])) {
            $data['agama'] = $_SESSION['agama'];
        } else {
            $data['agama'] = '';
        }

        if (isset($_SESSION['tahun'])) {
            $data['tahun'] = $_SESSION['tahun'];
        } else {
            $data['tahun'] = date('Y');
        }

        if (isset($_SESSION['cacat'])) {
            $data['cacat'] = $_SESSION['cacat'];
        } else {
            $data['cacat'] = '';
        }

        if (isset($_SESSION['golongan_darah'])) {
            $data['golongan_darah'] = $_SESSION['golongan_darah'];
        } else {
            $data['golongan_darah'] = '';
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

        if (isset($_SESSION['pendidikan_sedang_id'])) {
            $data['pendidikan_sedang_id'] = $_SESSION['pendidikan_sedang_id'];
        } else {
            $data['pendidikan_sedang_id'] = '';
        }

        if (isset($_SESSION['pendidikan_kk_id'])) {
            $data['pendidikan_kk_id'] = $_SESSION['pendidikan_kk_id'];
        } else {
            $data['pendidikan_kk_id'] = '';
        }

        if (isset($_SESSION['status_penduduk'])) {
            $data['status_penduduk'] = $_SESSION['status_penduduk'];
        } else {
            $data['status_penduduk'] = '';
        }

        $data['list_agama']          = $this->penduduk_model->list_agama();
        $data['list_cacat']          = $this->penduduk_model->list_cacat();
        $data['list_golongan_darah'] = $this->penduduk_model->list_golongan_darah();
        $data['list_hubungan']       = $this->penduduk_model->list_hubungan();
        $data['pendidikan']          = $this->penduduk_model->list_pendidikan();
        $data['pendidikan_kk']       = $this->penduduk_model->list_pendidikan_kk();
        $data['pekerjaan']           = $this->penduduk_model->list_pekerjaan();
        $data['form_action']         = site_url('penduduk/adv_search_proses');
        view('sid/kependudukan/ajax_adv_search_form', $data);
    }

    public function adv_search_proses()
    {
        $adv_search = $_POST;
        $i          = 0;

        while ($i++ < count($adv_search)) {
            $col[$i] = key($adv_search);
            next($adv_search);
        }
        $i = 0;

        while ($i++ < count($col)) {
            if ($adv_search[$col[$i]] === '') {
                unset($adv_search[$col[$i]], $_SESSION[$col[$i]]);
            } else {
                $_SESSION[$col[$i]] = $adv_search[$col[$i]];
            }
        }
        //print_r($adv_search);
        redirect('penduduk');
    }

    public function ajax_penduduk_pindah($id = 0)
    {
        $data['dusun'] = $this->penduduk_model->list_dusun();

        $data['form_action'] = site_url("penduduk/pindah_proses/{$id}");
        view('sid/kependudukan/ajax_pindah_form', $data);
    }

    public function ajax_penduduk_pindah_rw($dusun = '')
    {
        $dusun = str_replace('_', ' ', $dusun);
        $rw    = $this->penduduk_model->list_rw($dusun);

        $dusun = str_replace(' ', '_', $dusun);
        echo "<td>RW</td>
		<td><select name='rw' onchange=RWSel('" . $dusun . "',this.value)>
		<option value=''>Pilih RW</option>";

        foreach ($rw as $data) {
            echo '<option>' . $data['rw'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function ajax_penduduk_pindah_rt($dusun = '', $rw = '')
    {
        $dusun = str_replace('_', ' ', $dusun);
        $rt    = $this->penduduk_model->list_rt($dusun, $rw);
        $dusun = str_replace(' ', '_', $dusun);
        echo "<td>RT</td>
		<td><select name='id_cluster'>
		<option value=''>Pilih RT</option>";

        foreach ($rt as $data) {
            echo '<option value=' . $data['id'] . '>' . $data['rt'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function ajax_penduduk_cari_rw($dusun = '')
    {
        $rw = $this->penduduk_model->list_rw($dusun);

        echo "<td>RW</td>
		<td><select name='rw' onchange=RWSel('" . $dusun . "',this.value)>
		<option value=''>Pilih RW&nbsp;</option>";

        foreach ($rw as $data) {
            echo '<option>' . $data['rw'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function ajax_penduduk_cari_rt($dusun = '', $rw = '')
    {
        $rt = $this->penduduk_model->list_rt($dusun, $rw);
        echo "<td>RT</td>
		<td><select name='rt'>
		<option value=''>Pilih RT&nbsp;</option>";

        foreach ($rt as $data) {
            echo '<option value=' . $data['rt'] . '>' . $data['rt'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function pindah_proses($id = 0)
    {
        $id_cluster = $_POST['id_cluster'];
        $this->penduduk_model->pindah_proses($id, $id_cluster);
        redirect('penduduk');
    }

    public function ajax_penduduk_maps($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        $data['penduduk'] = $this->penduduk_model->get_penduduk_map($id);
        $data['desa']     = $this->config_model->get_data();

        $data['form_action'] = site_url("penduduk/update_maps/{$p}/{$o}/{$id}");

        view('sid/kependudukan/maps', $data);
    }

    public function update_maps($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->update_position($id);
        redirect("penduduk/form/{$p}/{$o}/{$id}");
    }

    public function wilayah_sel($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        $data['form_action'] = site_url('penduduk');

        view('sid/kependudukan/maps', $data);
    }

    public function edit_status_dasar($p = 1, $o = 0, $id = 0)
    {
        $data['nik']         = $this->penduduk_model->get_penduduk($id);
        $data['form_action'] = site_url("penduduk/update_status_dasar/{$p}/{$o}/{$id}");
        view('sid/kependudukan/ajax_edit_status_dasar', $data);
    }

    public function update_status_dasar($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->update_status_dasar($id);
        redirect("penduduk/index/{$p}/{$o}");
    }

    public function cetak($o = 0)
    {
        $data['info'] = $this->penduduk_model->get_filter();
        $data['main'] = $this->penduduk_model->list_data($o, 0, 10000);
        view('sid/kependudukan/penduduk_print', $data);
    }

    public function excel($o = 0)
    {
        $data['info'] = $this->penduduk_model->get_filter();
        $data['main'] = $this->penduduk_model->list_data($o, 0, 10000);
        view('sid/kependudukan/penduduk_excel', $data);
    }

    public function statistik($tipe = '', $nomor = '', $sex = '')
    {
        $_SESSION['per_page'] = 50;
        unset($_SESSION['log'], $_SESSION['cari'], $_SESSION['warganegara'], $_SESSION['cacat'], $_SESSION['menahun'], $_SESSION['golongan_darah'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_sedang_id'], $_SESSION['pendidikan_kk_id'], $_SESSION['status_penduduk'], $_SESSION['umurx']);

        if ($sex === 0) {
            unset($_SESSION['sex']);
        } else {
            $_SESSION['sex'] = $sex;
        }

        if ($nomor !== 0) {
            switch ($tipe) {
            case 0: $_SESSION['pendidikan_kk_id'] = $nomor; $pre = 'PENDIDIKAN DALAM KK : '; break;

            case 1: $_SESSION['pekerjaan_id'] = $nomor; $pre = 'PEKERJAAN : '; break;

            case 2: $_SESSION['status'] = $nomor; $pre = 'STATUS PERKAWINAN : '; break;

            case 3: $_SESSION['agama'] = $nomor; $pre = 'AGAMA : '; break;

            case 4: $_SESSION['sex'] = $nomor; $pre = 'JENIS KELAMIN : '; break;

            case 5: $_SESSION['warganegara'] = $nomor; $pre = 'WARGANEGARA : '; break;

            case 6: $_SESSION['status_penduduk'] = $nomor; $pre = 'STATUS PENDUDUK : '; break;

            case 7: $_SESSION['golongan_darah'] = $nomor; $pre = 'GOLONGAN DARAH : '; break;

            case 9: $_SESSION['cacat'] = $nomor; $pre = 'CACAT : '; break;

            case 10: $_SESSION['menahun'] = $nomor; $pre = 'SAKIT MENAHUN : '; break;

            case 11: $_SESSION['jamkesmas'] = $nomor; $pre = 'JAMKESMAS : '; break;

            case 13: $_SESSION['umurx'] = $nomor; $pre = 'UMUR '; break;

            case 14: $_SESSION['pendidikan_sedang_id'] = $nomor; $pre = 'PENDIDIKAN SEDANG DITEMPUH : '; break;
        }
            $judul = $this->penduduk_model->get_judul_statistik($tipe, $nomor);
            if ($judul['nama']) {
                $_SESSION['judul_statistik']       = 'TABEL DATA KEPENDUDUKAN MENURUT ' . $pre . $judul['nama'];
                $_SESSION['judul_statistik_cetak'] = 'TABEL DATA KEPENDUDUKAN MENURUT ' . $pre . $judul['nama'];
            } else {
                unset($_SESSION['judul_statistik']);
            }

            redirect('penduduk');
        } else {
            redirect('penduduk');
        }
    }

    public function lap_statistik($id_cluster = 0, $tipe = 0, $nomor = 0)
    {
        unset($_SESSION['sex'], $_SESSION['cacatx'], $_SESSION['menahun'], $_SESSION['menahunx'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['hamil'], $_SESSION['status']);

        $cluster = $this->penduduk_model->get_cluster($id_cluster);

        switch ($tipe) {
            case 1:
                $_SESSION['sex']   = '1';
                $_SESSION['dusun'] = $cluster['dusun'];
                $_SESSION['rw']    = $cluster['rw'];
                $_SESSION['rt']    = $cluster['rt'];
                $pre               = 'JENIS KELAMIN LAKI-LAKI  ';
                break;

            case 2:
                $_SESSION['sex']   = '2';
                $_SESSION['dusun'] = $cluster['dusun'];
                $_SESSION['rw']    = $cluster['rw'];
                $_SESSION['rt']    = $cluster['rt'];
                $pre               = 'JENIS KELAMIN PEREMPUAN ';
                break;

            case 3:
                $_SESSION['umur_min'] = '0';
                $_SESSION['umur_max'] = '0';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR <1 ';
                break;

            case 4:
                $_SESSION['umur_min'] = '1';
                $_SESSION['umur_max'] = '5';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR 1-5 ';
                break;

            case 5:
                $_SESSION['umur_min'] = '6';
                $_SESSION['umur_max'] = '12';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR 6-12 ';
                break;

            case 6:
                $_SESSION['umur_min'] = '13';
                $_SESSION['umur_max'] = '15';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR 13-16 ';
                break;

            case 7:
                $_SESSION['umur_min'] = '16';
                $_SESSION['umur_max'] = '18';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR 16-18 ';
                break;

            case 8:
                $_SESSION['umur_min'] = '61';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'BERUMUR >60';
                break;

            case 9:
                $_SESSION['cacatx'] = '7';
                $_SESSION['dusun']  = $cluster['dusun'];
                $_SESSION['rw']     = $cluster['rw'];
                $_SESSION['rt']     = $cluster['rt'];
                $pre                = 'CACAT ';
                break;

            case 10:
                $_SESSION['menahunx'] = '14';
                $_SESSION['sex']      = '1';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'SAKIT MENAHUN LAKI-LAKI ';
                break;

            case 11:
                $_SESSION['menahunx'] = '14';
                $_SESSION['sex']      = '2';
                $_SESSION['dusun']    = $cluster['dusun'];
                $_SESSION['rw']       = $cluster['rw'];
                $_SESSION['rt']       = $cluster['rt'];
                $pre                  = 'SAKIT MENAHUN PEREMPUAN ';
                break;

            case 12:
                $_SESSION['hamil'] = '1';
                $_SESSION['dusun'] = $cluster['dusun'];
                $_SESSION['rw']    = $cluster['rw'];
                $_SESSION['rt']    = $cluster['rt'];
                $pre               = 'HAMIL ';
                break;
        }

        if ($pre) {
            $_SESSION['judul_statistik'] = $pre;
        } else {
            unset($_SESSION['judul_statistik']);
        }
        redirect('penduduk');
    }

    public function coba2($id = 0)
    {
        $this->penduduk_model->coba2();
    }
}
