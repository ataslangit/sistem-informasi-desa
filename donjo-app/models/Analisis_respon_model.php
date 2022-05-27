<?php

class Analisis_respon_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('excel');
    }

    public function autocomplete()
    {
        //$sql = "SELECT no_kk FROM tweb_keluarga
        //UNION SELECT t.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk t ON u.nik_kepala = t.id LEFT JOIN tweb_wil_clusterdesa c ON t.id_cluster = c.id //WHERE 1 ";
        $subjek = $_SESSION['subjek_tipe'];

        switch ($subjek) {
            case 1: $sql = 'SELECT nik AS no_kk FROM tweb_penduduk UNION SELECT u.nama FROM tweb_penduduk u LEFT JOIN tweb_wil_clusterdesa c ON u.id_cluster = c.id WHERE status_dasar=1 '; break;

            case 2: $sql = 'SELECT no_kk FROM tweb_keluarga UNION SELECT p.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 3: $sql = 'SELECT no_kk FROM tweb_rtm UNION SELECT p.nama FROM tweb_rtm u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 4: $sql = 'SELECT u.nama AS no_kk FROM kelompok u LEFT JOIN tweb_penduduk p ON u.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            default: return null;

        }
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < count($data)) {
            $outp .= ',"' . $data[$i]['no_kk'] . '"';
            $i++;
        }
        $outp = strtolower(substr($outp, 1));
        $outp = '[' . $outp . ']';

        return $outp;
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari       = $_SESSION['cari'];
            $kw         = $this->db->escape_like_str($cari);
            $kw         = '%' . $kw . '%';
            $search_sql = " AND (u.no_kk LIKE '{$kw}' OR p.nama LIKE '{$kw}')";
            $subjek     = $_SESSION['subjek_tipe'];

            switch ($subjek) {
                case 1: $search_sql = " AND (u.nik LIKE '{$kw}' OR u.nama LIKE '{$kw}')"; break;

                case 2: $search_sql = " AND (u.no_kk LIKE '{$kw}' OR p.nama LIKE '{$kw}')"; break;

                case 3: $search_sql = " AND ((u.no_kk LIKE '{$kw}' OR p.nama LIKE '{$kw}') OR ((SELECT COUNT(id) FROM tweb_penduduk WHERE nik LIKE '{$kw}' AND id_rtm = u.id) > 1) OR ((SELECT COUNT(id) FROM tweb_penduduk WHERE nama LIKE '{$kw}' AND id_rtm = u.id) > 1))"; break;

                case 4: $search_sql = " AND (u.nama LIKE '{$kw}' OR p.nama LIKE '{$kw}')"; break;

                default: return null;
            }

            return $search_sql;
        }
    }

    public function dusun_sql()
    {
        if (isset($_SESSION['dusun'])) {
            $kf        = $_SESSION['dusun'];
            $dusun_sql = " AND c.dusun = '{$kf}'";

            return $dusun_sql;
        }
    }

    public function rw_sql()
    {
        if (isset($_SESSION['rw'])) {
            $kf     = $_SESSION['rw'];
            $rw_sql = " AND c.rw = '{$kf}'";

            return $rw_sql;
        }
    }

    public function rt_sql()
    {
        if (isset($_SESSION['rt'])) {
            $kf     = $_SESSION['rt'];
            $rt_sql = " AND c.rt = '{$kf}'";

            return $rt_sql;
        }
    }

    public function isi_sql()
    {
        if (isset($_SESSION['isi'])) {
            $per = $this->get_aktif_periode();
            $kf  = $_SESSION['isi'];
            if ($kf === 1) {
                $isi_sql = " AND (SELECT COUNT(id_subjek) FROM analisis_respon_hasil WHERE id_subjek = u.id AND id_periode={$per} ) = 1 ";
            } else {
                $isi_sql = " AND (SELECT COUNT(id_subjek) FROM analisis_respon_hasil WHERE id_subjek = u.id AND id_periode={$per} ) = 0 ";
            }

            return $isi_sql;
        }
    }

    public function kelompok_sql($kf = 0)
    {
        return " AND id_master = {$kf} ";
    }

    public function paging($p = 1, $o = 0)
    {
        $master      = $this->get_analisis_master();
        $id_kelompok = $master['id_kelompok'];
        $subjek      = $_SESSION['subjek_tipe'];

        switch ($subjek) {
            case 1: $sql = 'SELECT COUNT(u.id) AS id FROM tweb_penduduk u LEFT JOIN tweb_wil_clusterdesa c ON u.id_cluster = c.id WHERE status_dasar=1 '; break;

            case 2: $sql = 'SELECT COUNT(u.id) AS id FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 3: $sql = 'SELECT COUNT(u.id) AS id FROM tweb_rtm u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 4: $sql = 'SELECT COUNT(u.id) AS id FROM kelompok u LEFT JOIN tweb_penduduk p ON u.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            default: return null;

        }
        //$sql = "SELECT COUNT(u.id) AS id FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1";
        if ($id_kelompok !== 0) {
            $sql .= $this->kelompok_sql($id_kelompok);
        }

        $sql .= $this->search_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= $this->isi_sql();
        $query    = $this->db->query($sql);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $this->load->library('paging');
        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;
        $this->paging->init($cfg);

        return $this->paging;
    }

    public function list_data($o = 0, $offset = 0, $limit = 500)
    {
        $per         = $this->get_aktif_periode();
        $master      = $this->get_analisis_master();
        $id_kelompok = $master['id_kelompok'];

        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.id'; break;

            case 2: $order_sql = ' ORDER BY u.id DESC'; break;

            case 3: $order_sql = ' ORDER BY u.id'; break;

            case 4: $order_sql = ' ORDER BY u.id DESC'; break;

            default:$order_sql = ' ORDER BY u.id';
        }

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $subjek = $_SESSION['subjek_tipe'];

        switch ($subjek) {
            case 1: $sql = 'SELECT u.id,u.nik AS nid,u.nama,u.sex,c.dusun,c.rw,c.rt,(SELECT id_subjek FROM analisis_respon WHERE id_subjek = u.id AND id_periode=? LIMIT 1) as cek FROM tweb_penduduk u LEFT JOIN tweb_wil_clusterdesa c ON u.id_cluster = c.id WHERE u.status_dasar = 1 '; break;

            case 2: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt,(SELECT id_subjek FROM analisis_respon WHERE id_subjek = u.id AND id_periode=? LIMIT 1) as cek FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 3: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt,(SELECT id_subjek FROM analisis_respon WHERE id_subjek = u.id AND id_periode=? LIMIT 1) as cek FROM tweb_rtm u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 4: $sql = 'SELECT u.id,u.kode AS nid,u.nama,p.sex,c.dusun,c.rw,c.rt,(SELECT id_subjek FROM analisis_respon WHERE id_subjek = u.id AND id_periode=? LIMIT 1) as cek FROM kelompok u LEFT JOIN tweb_penduduk p ON u.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1 '; break;

            default: return null;

        }
        //$sql = "SELECT u.*,p.nama,c.dusun,c.rw,c.rt,(SELECT id FROM analisis_respon WHERE id_subjek = u.id AND id_periode=? LIMIT 1) as cek FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1 ";
        if ($id_kelompok !== 0) {
            $sql .= $this->kelompok_sql($id_kelompok);
        }

        $sql .= $this->search_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= $this->isi_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql, $per);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < count($data)) {
            $data[$i]['no'] = $j + 1;

            //$this->update_hasil($data[$i]['id']);

            if ($data[$i]['cek']) {
                $data[$i]['set'] = "<img src='" . base_url() . "assets/images/icon/ok.png'>";
            } else {
                $data[$i]['set'] = "<img src='" . base_url() . "assets/images/icon/nok.png'>";
            }

            $data[$i]['jk'] = '-';
            if ($data[$i]['sex'] === 1) {
                $data[$i]['jk'] = 'L';
            } else {
                $data[$i]['jk'] = 'P';
            }

            $data[$i]['alamat'] = $data[$i]['dusun'] . ' RW-' . $data[$i]['rw'] . ' RT-' . $data[$i]['rt'];
            $i++;
            $j++;
        }

        return $data;
    }

    public function update_kuisioner($id = 0, $per = 0)
    {
        $outp = false;
        if ($per === 0) {
            $per       = $this->get_aktif_periode();
            $id_master = $_SESSION['analisis_master'];
        } else {
            $sql       = 'SELECT id_master FROM analisis_periode WHERE id = ?';
            $query     = $this->db->query($sql, $per);
            $id_master = $query->row_array();
            $id_master = $id_master['id_master'];
        }
        $ia = 0;
        $it = 0;
        $ir = 0;
        $ic = 0;

        if (isset($_POST['rb'])) {
            $id_rbx = $_POST['rb'];

            foreach ($id_rbx as $id_px) {
                if ($id_px !== '') {
                    $ir = 1;
                }
            }
        }
        if (isset($_POST['cb'])) {
            $id_rby = $_POST['cb'];

            foreach ($id_rby as $id_py) {
                if ($id_py !== '') {
                    $ic = 1;
                }
            }
        }
        if (isset($_POST['ia'])) {
            $id_iax = $_POST['ia'];

            foreach ($id_iax as $id_px) {
                if ($id_px !== '') {
                    $ia = 1;
                }
            }
        }
        if (isset($_POST['it'])) {
            $id_iay = $_POST['it'];

            foreach ($id_iay as $id_py) {
                if ($id_py !== '') {
                    $it = 1;
                }
            }
        }

        //CEK ada input
        if ($ir !== 0 || $ic !== 0 || $ia !== 0 || $it !== 0) {
            $sql = 'DELETE FROM analisis_respon WHERE id_subjek = ? AND id_periode=?';
            $this->db->query($sql, [$id, $per]);

            if (isset($_POST['rb'])) {
                $id_rb = $_POST['rb'];

                foreach ($id_rb as $id_p) {
                    $p = preg_split('/\\./', $id_p);

                    $data['id_subjek']    = $id;
                    $data['id_periode']   = $per;
                    $data['id_indikator'] = $p[0];
                    $data['id_parameter'] = $p[1];
                    $outp                 = $this->db->insert('analisis_respon', $data);
                }
            }
            if (isset($_POST['cb'])) {
                $id_cb = $_POST['cb'];
                if ($id_cb) {
                    foreach ($id_cb as $id_p) {
                        $p = preg_split('/\\./', $id_p);

                        $data['id_subjek']    = $id;
                        $data['id_periode']   = $per;
                        $data['id_indikator'] = $p[0];
                        $data['id_parameter'] = $p[1];
                        $outp                 = $this->db->insert('analisis_respon', $data);
                    }
                }
            }

            if (isset($_POST['ia'])) {
                $id_ia = $_POST['ia'];

                foreach ($id_ia as $id_p) {
                    if ($id_p !== '') {
                        unset($data);
                        $indikator = key($id_ia);

                        $sql   = 'SELECT * FROM analisis_parameter u WHERE jawaban = ? AND id_indikator = ?';
                        $query = $this->db->query($sql, [$id_p, $indikator]);
                        $dx    = $query->row_array();
                        if (! $dx) {
                            $data['id_indikator'] = $indikator;
                            $data['jawaban']      = $id_p;
                            $this->db->insert('analisis_parameter', $data);
                            unset($data);

                            $sql   = 'SELECT * FROM analisis_parameter u WHERE jawaban = ? AND id_indikator = ?';
                            $query = $this->db->query($sql, [$id_p, $indikator]);
                            $dx    = $query->row_array();

                            $data['id_parameter'] = $dx['id'];
                            $data['id_indikator'] = $indikator;
                            $data['id_subjek']    = $id;
                            $data['id_periode']   = $per;
                            $outp                 = $this->db->insert('analisis_respon', $data);
                        } else {
                            unset($data);
                            $data['id_indikator'] = $indikator;
                            $data['id_parameter'] = $dx['id'];
                            $data['id_subjek']    = $id;
                            $data['id_periode']   = $per;
                            $outp                 = $this->db->insert('analisis_respon', $data);
                        }
                    }
                    next($id_ia);
                }
            }
            if (isset($_POST['it'])) {
                $id_it = $_POST['it'];

                foreach ($id_it as $id_p) {
                    if ($id_p !== '') {
                        unset($data);
                        $indikator = key($id_it);

                        $sql   = 'SELECT * FROM analisis_parameter u WHERE jawaban = ? AND id_indikator = ?';
                        $query = $this->db->query($sql, [$id_p, $indikator]);
                        $dx    = $query->row_array();
                        if (! $dx) {
                            $data['id_indikator'] = $indikator;
                            $data['jawaban']      = $id_p;
                            $this->db->insert('analisis_parameter', $data);
                            unset($data);

                            $sql   = 'SELECT * FROM analisis_parameter u WHERE jawaban = ? AND id_indikator = ?';
                            $query = $this->db->query($sql, [$id_p, $indikator]);
                            $dx    = $query->row_array();

                            $data2['id_parameter'] = $dx['id'];
                            $data2['id_indikator'] = $indikator;
                            $data2['id_subjek']    = $id;
                            $data2['id_periode']   = $per;
                            $outp                  = $this->db->insert('analisis_respon', $data2);
                        } else {
                            unset($data);
                            $data['id_indikator'] = $indikator;
                            $data['id_parameter'] = $dx['id'];

                            $data['id_subjek']  = $id;
                            $data['id_periode'] = $per;
                            $outp               = $this->db->insert('analisis_respon', $data);
                        }
                    }
                    next($id_it);
                }
            }

            $sql   = 'SELECT SUM(i.bobot * nilai) as jml FROM analisis_respon r LEFT JOIN analisis_indikator i ON r.id_indikator = i.id LEFT JOIN analisis_parameter z ON r.id_parameter = z.id WHERE r.id_subjek = ? AND i.act_analisis=1 AND r.id_periode=?';
            $query = $this->db->query($sql, [$id, $per]);
            $dx    = $query->row_array();

            $upx['id_master']  = $id_master;
            $upx['akumulasi']  = 0 + $dx['jml'];
            $upx['id_subjek']  = $id;
            $upx['id_periode'] = $per;

            $sql = 'DELETE FROM analisis_respon_hasil WHERE id_subjek = ? AND id_periode=?';
            $this->db->query($sql, [$id, $per]);
            $outp = $this->db->insert('analisis_respon_hasil', $upx);
        }
        if (isset($_FILES['pengesahan'])) {
            $lokasi_file = $_FILES['pengesahan']['tmp_name'];
            $tipe_file   = $_FILES['pengesahan']['type'];
            if (! empty($lokasi_file)) {
                if ($tipe_file !== 'image/jpeg' && $tipe_file !== 'image/pjpeg') {
                    $_SESSION['sukses'] = -1;
                } else {
                    $nama_file = $_SESSION['analisis_master'] . '_' . $per . '_' . $id . '_' . mt_rand(10000, 99999) . '.jpg';
                    UploadPengesahan($nama_file);
                    $bukti['pengesahan'] = $nama_file;
                    $bukti['id_master']  = $id_master;
                    $bukti['id_subjek']  = $id;
                    $bukti['id_periode'] = $per;

                    $outp = $this->db->insert('analisis_respon_bukti', $bukti);
                }
            }
        }
        if ($outp) {
            $_SESSION['sukses'] = 1;
        } else {
            $_SESSION['sukses'] = -1;
        }
    }

    public function list_jawab2($id = 0, $in = 0, $per = 0)
    {
        if (isset($_SESSION['delik'])) {
            $sql   = 'SELECT s.id as id_parameter,s.jawaban,s.kode_jawaban FROM analisis_parameter s WHERE id_indikator = ? ORDER BY s.kode_jawaban ASC ';
            $query = $this->db->query($sql, $in);
        } else {
            $sql   = 'SELECT s.id as id_parameter,s.jawaban,s.kode_jawaban,(SELECT count(id_subjek) FROM analisis_respon WHERE id_parameter = s.id AND id_subjek = ? AND id_periode=?) as cek FROM analisis_parameter s WHERE id_indikator = ? ORDER BY s.kode_jawaban ASC ';
            $query = $this->db->query($sql, [$id, $per, $in]);
        }

        $data = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;
            if (isset($_SESSION['delik'])) {
                $data[$i]['cek'] = 0;
            }
            $i++;
        }

        return $data;
    }

    public function list_jawab3($id = 0, $in = 0, $per = 0)
    {
        $sql   = 'SELECT s.id as id_parameter,s.jawaban FROM analisis_respon r LEFT JOIN analisis_parameter s ON r.id_parameter = s.id WHERE r.id_indikator = ? AND r.id_subjek = ? AND r.id_periode=?';
        $query = $this->db->query($sql, [$in, $id, $per]);

        return $query->row_array();
    }

    public function list_indikator($id = 0)
    {
        $per = $this->get_aktif_periode();

        $sql   = 'SELECT u.id,u.id_kategori,u.nomor,u.id_tipe,u.pertanyaan,k.kategori FROM analisis_indikator u LEFT JOIN analisis_kategori_indikator k ON u.id_kategori = k.id WHERE u.id_master = ? ORDER BY u.id_kategori,u.nomor ASC';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['id_tipe'] === 1 || $data[$i]['id_tipe'] === 2) {
                $data[$i]['parameter_respon'] = $this->list_jawab2($id, $data[$i]['id'], $per);
            } else {
                if (isset($_SESSION['delik'])) {
                    $data[$i]['parameter_respon'] = '';
                } else {
                    $data[$i]['parameter_respon'] = $this->list_jawab3($id, $data[$i]['id'], $per);
                }
            }
            $i++;
        }

        return $data;
    }

    //CHILD-----------------------

    public function list_jawab4($id = 0, $in = 0, $per = 0)
    {
        if (isset($_SESSION['delik'])) {
            $sql   = 'SELECT s.id as id_parameter,s.jawaban,s.kode_jawaban FROM analisis_parameter s WHERE id_indikator = ? ';
            $query = $this->db->query($sql, $in);
        } else {
            $sql   = 'SELECT s.id as id_parameter,s.jawaban,s.kode_jawaban,(SELECT count(id_subjek) FROM analisis_respon WHERE id_parameter = s.id AND id_subjek = ? AND id_periode=?) as cek FROM analisis_parameter s WHERE id_indikator = ? ';
            $query = $this->db->query($sql, [$id, $per, $in]);
        }

        $data = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;
            if (isset($_SESSION['delik'])) {
                $data[$i]['cek'] = 0;
            }
            $i++;
        }

        return $data;
    }

    public function list_jawab5($id = 0, $in = 0, $per = 0)
    {
        $sql   = 'SELECT s.id as id_parameter,s.jawaban FROM analisis_respon r LEFT JOIN analisis_parameter s ON r.id_parameter = s.id WHERE r.id_indikator = ? AND r.id_subjek = ? AND r.id_periode=?';
        $query = $this->db->query($sql, [$in, $id, $per]);

        return $query->row_array();
    }

    public function list_indikator_child($id = 0)
    {
        $sql      = 'SELECT id_child FROM analisis_master WHERE id = ? ';
        $query    = $this->db->query($sql, $_SESSION['analisis_master']);
        $id_child = $query->row_array();
        $id_child = $id_child['id_child'];

        $sql   = 'SELECT id FROM analisis_periode WHERE id_master = ? AND aktif = 1';
        $query = $this->db->query($sql, $id_child);
        $per   = $query->row_array();
        $per   = $per['id'];

        $sql = 'SELECT * FROM analisis_indikator u WHERE id_master = ? ';
        $sql .= ' ORDER BY nomor';
        $query = $this->db->query($sql, $id_child);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['id_tipe'] === 1 || $data[$i]['id_tipe'] === 2) {
                $data[$i]['parameter_respon'] = $this->list_jawab4($id, $data[$i]['id'], $per);
            } else {
                if (isset($_SESSION['delik'])) {
                    $data[$i]['parameter_respon'] = '';
                } else {
                    $data[$i]['parameter_respon'] = $this->list_jawab5($id, $data[$i]['id'], $per);
                }
            }
            $i++;
        }

        return $data;
    }

    public function get_periode_child()
    {
        $sql      = 'SELECT id_child FROM analisis_master WHERE id = ? ';
        $query    = $this->db->query($sql, $_SESSION['analisis_master']);
        $id_child = $query->row_array();
        $id_child = $id_child['id_child'];

        $sql   = 'SELECT id FROM analisis_periode WHERE id_master = ? AND aktif = 1';
        $query = $this->db->query($sql, $id_child);
        $per   = $query->row_array();
        $per   = $per['id'];

        return $per;
    }
    //---------------------------

    public function list_bukti($id = 0)
    {
        $per = $this->get_aktif_periode();
        $sql = 'SELECT pengesahan FROM analisis_respon_bukti WHERE id_subjek = ? AND id_master = ? AND id_periode = ? ';
        $sql .= ' ORDER BY tgl_update DESC';
        $query = $this->db->query($sql, [$id, $_SESSION['analisis_master'], $per]);
        $data  = $query->result_array();

        return $data;
    }

    public function get_subjek($id = 0)
    {
        $subjek = $_SESSION['subjek_tipe'];

        switch ($subjek) {
            case 1: $sql = 'SELECT u.id,u.nik AS nid,u.nama,u.sex,c.dusun,c.rw,c.rt FROM tweb_penduduk u LEFT JOIN tweb_wil_clusterdesa c ON u.id_cluster = c.id WHERE u.id = ? '; break;

            case 2: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE u.id = ? '; break;

            case 3: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt FROM tweb_rtm u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE u.id = ? '; break;

            case 4: $sql = 'SELECT u.id,u.kode AS nid,u.nama,p.sex,c.dusun,c.rw,c.rt FROM kelompok u LEFT JOIN tweb_penduduk p ON u.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE u.id = ? '; break;

            default: return null;

        }
        //$sql = "SELECT u.*,p.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id WHERE u.id=?";
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function list_anggota($id = 0)
    {
        $subjek = $_SESSION['subjek_tipe'];
        if ($subjek === 2 || $subjek === 3) {
            switch ($subjek) {
                case 2: $sql = 'SELECT u.* FROM tweb_penduduk u WHERE u.id_kk = ? ORDER BY kk_level'; break;

                case 3: $sql = 'SELECT u.* FROM tweb_penduduk u WHERE u.id_rtm = ? ORDER BY rtm_level'; break;

                default: return null;
            }
            //$sql = "SELECT u.*,p.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id WHERE u.id=?";
            $query = $this->db->query($sql, $id);

            return $query->result_array();
        }

        return null;
    }

    public function aturan_unduh()
    {
        $subjek    = $_SESSION['subjek_tipe'];
        $order_sql = ' ORDER BY u.nomor ASC';
        $sql       = 'SELECT u.*,t.tipe AS tipe_indikator,k.kategori AS kategori FROM analisis_indikator u LEFT JOIN analisis_tipe_indikator t ON u.id_tipe = t.id LEFT JOIN analisis_kategori_indikator k ON u.id_kategori = k.id WHERE u.id_master = ? ';
        $sql .= $order_sql;

        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->result_array();

        $per = $this->get_aktif_periode();
        $i   = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['id_tipe'] === 1 || $data[$i]['id_tipe'] === 2) {
                $sql2            = 'SELECT i.id,i.kode_jawaban,i.jawaban FROM analisis_parameter i WHERE i.id_indikator = ? ORDER BY i.kode_jawaban ASC ';
                $query2          = $this->db->query($sql2, $data[$i]['id']);
                $respon2         = $query2->result_array();
                $data[$i]['par'] = $respon2;
            } else {
                $data[$i]['par'] = null;
            }
            if ($data[$i]['act_analisis'] === 1) {
                $data[$i]['act_analisis'] = 'Ya';
            } else {
                $data[$i]['act_analisis'] = 'Tidak';
            }

            $i++;
        }

        return $data;
    }

    public function data_unduh($p = 0, $o = 0)
    {
        $per         = $this->get_aktif_periode();
        $master      = $this->get_analisis_master();
        $id_kelompok = $master['id_kelompok'];

        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.id'; break;

            case 2: $order_sql = ' ORDER BY u.id DESC'; break;

            case 3: $order_sql = ' ORDER BY u.id'; break;

            case 4: $order_sql = ' ORDER BY u.id DESC'; break;

            default:$order_sql = ' ORDER BY u.id';
        }

        $sql       = 'SELECT * FROM analisis_indikator WHERE id_master = ? ORDER BY nomor';
        $query     = $this->db->query($sql, $_SESSION['analisis_master']);
        $indikator = $query->result_array();

        $subjek = $_SESSION['subjek_tipe'];

        switch ($subjek) {
            case 1: $sql = 'SELECT u.id,u.nik AS nid,u.nama,u.sex,c.dusun,c.rw,c.rt FROM tweb_penduduk u LEFT JOIN tweb_wil_clusterdesa c ON u.id_cluster = c.id WHERE 1 '; break;

            case 2: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1 '; break;

            case 3: $sql = 'SELECT u.id,u.no_kk AS nid,p.nama,p.sex,c.dusun,c.rw,c.rt FROM tweb_rtm u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1'; break;

            case 4: $sql = 'SELECT u.id,u.kode AS nid,u.nama,p.sex,c.dusun,c.rw,c.rt FROM kelompok u LEFT JOIN tweb_penduduk p ON u.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id WHERE 1 '; break;

            default: return null; break;

        }
        if ($id_kelompok !== 0) {
            $sql .= $this->kelompok_sql($id_kelompok);
        }

        $sql .= $this->search_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= $this->isi_sql();
        $sql .= $order_sql;

        $query = $this->db->query($sql, $per);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;

            if ($p === 1) {
                //$j=0;
                //while($j<count($indikator)){

                $sql2 = 'SELECT kode_jawaban,asign,jawaban,r.id_indikator,r.id_parameter AS korek FROM analisis_respon r LEFT JOIN analisis_parameter p ON p.id = r.id_parameter WHERE r.id_periode = ? AND r.id_subjek = ? ORDER BY r.id_indikator';

                //$sql2 	= "SELECT kode_jawaban WHERE r.id_periode = ? AND r.id_subjek = ? ORDER BY i.nomor ";

                $query2          = $this->db->query($sql2, [$per, $data[$i]['id']]);
                $par             = $query2->result_array();
                $data[$i]['par'] = $par;

            //	$j++;
                //}
            } else {
                $data[$i]['par'] = null;
            }

            $data[$i]['jk'] = '-';
            if ($data[$i]['sex'] === 1) {
                $data[$i]['jk'] = 'L';
            } else {
                $data[$i]['jk'] = 'P';
            }

            $i++;
        }

        return $data;
    }

    public function indikator_data_unduh()
    {
        $master = $this->get_analisis_master();

        $order_sql = ' ORDER BY u.nomor';

        $sql = 'SELECT u.* FROM analisis_indikator u WHERE u.id_master = ? ';
        $sql .= $order_sql;
        $query = $this->db->query($sql, $master);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no']  = $i + 1;
            $data[$i]['par'] = null;

            $sql2            = 'SELECT id_parameter FROM analisis_respon WHERE id_indikator = ? AND asign = 1 ';
            $query2          = $this->db->query($sql2, $data[$i]['id']);
            $par             = $query2->result_array();
            $data[$i]['par'] = $par;

            $i++;
        }

        return $data;
    }

    public function indikator_unduh($p = 0)
    {
        $master = $this->get_analisis_master();

        $order_sql = ' ORDER BY u.nomor';

        $sql = 'SELECT u.* FROM analisis_indikator u WHERE u.id_master = ? ';
        $sql .= $order_sql;
        $query = $this->db->query($sql, $master);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no']  = $i + 1;
            $data[$i]['par'] = null;

            if ($p === 1) {
                $sql2            = 'SELECT * FROM analisis_parameter WHERE id_indikator = ? AND asign = 1 ';
                $query2          = $this->db->query($sql2, $data[$i]['id']);
                $par             = $query2->result_array();
                $data[$i]['par'] = $par;
            }

            $i++;
        }

        return $data;
    }

    public function pre_update($pr = 0)
    {
        if ($pr === 0) {
            $per = $this->get_aktif_periode();
        } else {
            $per = $pr;
        }

        $sql   = 'SELECT DISTINCT(id_subjek) AS id FROM analisis_respon WHERE id_periode = ? ';
        $query = $this->db->query($sql, $per);
        $data  = $query->result_array();

        $sql = 'DELETE FROM analisis_respon_hasil WHERE id_subjek = 0';
        $this->db->query($sql);

        $sql = 'DELETE FROM analisis_respon WHERE id_subjek = 0';
        $this->db->query($sql);

        $sql = 'DELETE FROM analisis_respon_hasil WHERE id_periode = ?';
        $this->db->query($sql, $per);

        $i = 0;

        while ($i < count($data)) {
            //$this->update_hasil($data[$i]['id']);

            $sql   = 'SELECT SUM(i.bobot * nilai) as jml FROM analisis_respon r LEFT JOIN analisis_indikator i ON r.id_indikator = i.id LEFT JOIN analisis_parameter z ON r.id_parameter = z.id WHERE r.id_subjek = ? AND i.act_analisis=1 AND r.id_periode=?';
            $query = $this->db->query($sql, [$data[$i]['id'], $per]);
            $dx    = $query->row_array();

            $upx[$i]['id_master']  = $_SESSION['analisis_master'];
            $upx[$i]['akumulasi']  = 0 + $dx['jml'];
            $upx[$i]['id_subjek']  = $data[$i]['id'];
            $upx[$i]['id_periode'] = $per;

            $i++;
        }
        if (@$upx) {
            $this->db->insert_batch('analisis_respon_hasil', $upx);
        }
    }

    public function update_hasil($id = 0)
    {
        $per = $this->get_aktif_periode();

        $sql   = 'SELECT SUM(i.bobot * nilai) as jml FROM analisis_respon r LEFT JOIN analisis_indikator i ON r.id_indikator = i.id LEFT JOIN analisis_parameter z ON r.id_parameter = z.id WHERE r.id_subjek = ? AND i.act_analisis=1 AND r.id_periode=?';
        $query = $this->db->query($sql, [$id, $per]);
        $dx    = $query->row_array();

        $upx['id_master']  = $_SESSION['analisis_master'];
        $upx['akumulasi']  = 0 + $dx['jml'];
        $upx['id_subjek']  = $id;
        $upx['id_periode'] = $per;

        $sql = 'DELETE FROM analisis_respon_hasil WHERE id_subjek = ? AND id_periode=?';
        $this->db->query($sql, [$id, $per]);

        $this->db->insert('analisis_respon_hasil', $upx);
    }

    public function import_respon($op = 0)
    {
        $per = $this->get_aktif_periode();

        $subjek = $_SESSION['subjek_tipe'];
        $mas    = $_SESSION['analisis_master'];
        $key    = ($per + 3) * ($mas + 7) * ($subjek * 3);
        $key    = 'AN' . $key;

        $sql       = 'SELECT * FROM analisis_indikator WHERE id_master=? ORDER BY id ASC';
        $query     = $this->db->query($sql, $_SESSION['analisis_master']);
        $indikator = $query->result_array();
        $jml       = count($indikator);

        $data  = new Spreadsheet_Excel_Reader($_FILES['respon']['tmp_name']);
        $s     = 0;
        $baris = $data->rowcount($s);
        $kolom = $data->colcount($s);

        $ketemu = 0;

        for ($b = 1; $b <= $baris; $b++) {
            //echo "<tr>";
            for ($k = 1; $k <= $kolom; $k++) {
                $isi = $data->val($b, $k, $s);
                //echo "<td>$b : $k ($isi)";

                // ketemu njuk stop
                if ($isi === $key) {
                    $br = $b + 1;
                    $kl = $k + 1;

                    $b      = $baris + 1;
                    $k      = $kolom + 1;
                    $ketemu = 1;
                    //echo "<- KETEMU";
                }
            }
        }

        if ($ketemu === 1) {
            $dels = '';
            $true = 0;

            for ($i = $br; $i <= $baris; $i++) {
                $id_subjek = $data->val($i, $kl - 1, $s);

                $j = $kl;

                foreach ($indikator as $indi) {
                    $isi = $data->val($i, $j, $s);
                    if ($isi !== '') {
                        $true = 1;
                    }

                    $j++;
                }
                if ($true === 1) {
                    $dels .= $id_subjek . ',';
                    $true = 0;
                }
            }

            $dels .= '9999999';
            //cek ada row

            //echo $dels;
            $sql = 'DELETE FROM analisis_respon WHERE id_subjek IN(?) AND id_periode=?';
            $this->db->query($sql, [$dels, $per]);
            $dels = '';

            $n = 0;

            for ($i = $br; $i <= $baris; $i++) {
                $id_subjek = $data->val($i, $kl - 1, $s);
                if (strlen($id_subjek) > 14 && $subjek === 1) {
                    $sqls      = 'SELECT id FROM tweb_penduduk WHERE nik = ?;';
                    $querys    = $this->db->query($sqls, [$id_subjek]);
                    $isbj      = $querys->row_array();
                    $id_subjek = $isbj['id'];
                }

                $j   = $kl + $op;
                $all = '';

                foreach ($indikator as $indi) {
                    $isi = $data->val($i, $j, $s);
                    if ($isi !== '') {
                        if ($indi['id_tipe'] === 1) {
                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ?;';
                            $query = $this->db->query($sql, [$indi['id'], $isi]);
                            $param = $query->row_array();

                            if ($param) {
                                $in_param = $param['id'];
                            } else {
                                if ($isi === '') {
                                    $in_param = 0;
                                } else {
                                    $in_param = -1;
                                }
                            }

                            $respon[$n]['id_parameter'] = $in_param;
                            $respon[$n]['id_indikator'] = $indi['id'];
                            $respon[$n]['id_subjek']    = $id_subjek;
                            $respon[$n]['id_periode']   = $per;
                            $n++;
                        } elseif ($indi['id_tipe'] === 2) {
                            $id_isi = explode(',', $isi);

                            //if(count($id_isi) > 1){
                            //foreach($id_isi AS $ids){
                            //echo "<br>".count($id_isi)." -> ";
                            for ($q = 0; $q < (count($id_isi)); $q++) {
                                //echo $id_isi[$q]." ";
                                $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ? ;';
                                $query = $this->db->query($sql, [$indi['id'], $id_isi[$q]]);
                                $param = $query->row_array();

                                if ($param['id'] !== '') {
                                    $in_param                   = $param['id'];
                                    $respon[$n]['id_parameter'] = $in_param;
                                    $respon[$n]['id_indikator'] = $indi['id'];
                                    $respon[$n]['id_subjek']    = $id_subjek;
                                    $respon[$n]['id_periode']   = $per;
                                    $n++;
                                }
                            }
                            //}
                        } else {
                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                            $query = $this->db->query($sql, [$indi['id'], $isi]);
                            $param = $query->row_array();

                            // apakah sdh ada jawaban yg sama
                            if ($param) {
                                $in_param = $param['id'];
                            } else {
                                $parameter['jawaban']      = $isi;
                                $parameter['id_indikator'] = $indi['id'];
                                $parameter['asign']        = 0;

                                $this->db->insert('analisis_parameter', $parameter);

                                $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                                $query = $this->db->query($sql, [$indi['id'], $isi]);
                                $param = $query->row_array();
                                //if($param){
                                $in_param = $param['id'];
                                //}else{
                                //$in_param	= $id_param;
                        //	}
                            }

                            $respon[$n]['id_parameter'] = $in_param;
                            $respon[$n]['id_indikator'] = $indi['id'];
                            $respon[$n]['id_subjek']    = $id_subjek;
                            $respon[$n]['id_periode']   = $per;
                            $n++;
                        }
                    }

                    $j++;
                }
            }
            if ($n > 0) {
                $outp = $this->db->insert_batch('analisis_respon', $respon);
            } else {
                $outp = false;
            }
        }

        $this->pre_update();

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
    //------------------

    public function satu_jiwa($op = 0)
    {
        $_SESSION['subjek_tipe']     = 1;
        $_SESSION['analisis_master'] = 2;
        ini_set('max_execution_time', 1600);
        ini_set('memory_limit', '2048M');

        $per = $this->get_aktif_periode();

        $subjek    = $_SESSION['subjek_tipe'];
        $mas       = $_SESSION['analisis_master'];
        $sql       = 'SELECT * FROM analisis_indikator WHERE id_master=? ORDER BY id ASC';
        $query     = $this->db->query($sql, $_SESSION['analisis_master']);
        $indikator = $query->result_array();

        $sql   = 'SELECT * FROM a_jiwa WHERE 1';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $sql = 'DELETE FROM analisis_respon WHERE id_periode=?';
        $this->db->query($sql, [$per]);

        $n = 0;
        //foreach($tdata AS $data){
        $di = 0;

        while ($di < count($data)) {
            $id_subjek = $data[$di]['nik'];
            if (strlen($id_subjek) > 14 && $subjek === 1) {
                $sqls      = 'SELECT id FROM tweb_penduduk WHERE nik = ?;';
                $querys    = $this->db->query($sqls, [$id_subjek]);
                $isbj      = $querys->row_array();
                $id_subjek = $isbj['id'];
            }

            $j   = 1;
            $all = '';

            foreach ($indikator as $indi) {
                $k   = 'j' . $j;
                $isi = $data[$di][$k];
                //echo $isi."<br>";
                if ($isi !== '') {
                    if ($indi['id_tipe'] === 1) {
                        $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ?;';
                        $query = $this->db->query($sql, [$indi['id'], $isi]);
                        $param = $query->row_array();

                        if ($param) {
                            $in_param = $param['id'];
                        } else {
                            if ($isi === '') {
                                $in_param = 0;
                            } else {
                                $in_param = -1;
                            }
                        }

                        $respon[$n]['id_parameter'] = $in_param;
                        $respon[$n]['id_indikator'] = $indi['id'];
                        $respon[$n]['id_subjek']    = $id_subjek;
                        $respon[$n]['id_periode']   = $per;
                        $n++;
                    } elseif ($indi['id_tipe'] === 2) {
                        $id_isi = explode(',', $isi);

                        //if(count($id_isi) > 1){
                        //foreach($id_isi AS $ids){
                        //echo "<br>".count($id_isi)." -> ";
                        for ($q = 0; $q < (count($id_isi)); $q++) {
                            //echo $id_isi[$q]." ";
                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ? ;';
                            $query = $this->db->query($sql, [$indi['id'], $id_isi[$q]]);
                            $param = $query->row_array();

                            if ($param['id'] !== '') {
                                $in_param                   = $param['id'];
                                $respon[$n]['id_parameter'] = $in_param;
                                $respon[$n]['id_indikator'] = $indi['id'];
                                $respon[$n]['id_subjek']    = $id_subjek;
                                $respon[$n]['id_periode']   = $per;
                                $n++;
                            }
                        }
                        //}
                    } else {
                        $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                        $query = $this->db->query($sql, [$indi['id'], $isi]);
                        $param = $query->row_array();

                        // apakah sdh ada jawaban yg sama
                        if ($param) {
                            $in_param = $param['id'];
                        } else {
                            $parameter['jawaban']      = $isi;
                            $parameter['id_indikator'] = $indi['id'];
                            $parameter['asign']        = 0;

                            $this->db->insert('analisis_parameter', $parameter);

                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                            $query = $this->db->query($sql, [$indi['id'], $isi]);
                            $param = $query->row_array();
                            //if($param){
                            $in_param = $param['id'];
                            //}else{
                                //$in_param	= $id_param;
                        //	}
                        }

                        $respon[$n]['id_parameter'] = $in_param;
                        $respon[$n]['id_indikator'] = $indi['id'];
                        $respon[$n]['id_subjek']    = $id_subjek;
                        $respon[$n]['id_periode']   = $per;
                        $n++;
                    }
                }

                $j++;
            }
            $di++;
        }
        if ($n > 0) {
            $outp = $this->db->insert_batch('analisis_respon', $respon);
        } else {
            $outp = false;
        }

        $this->pre_update();

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function dua_dunia($op = 0)
    {
        $_SESSION['analisis_master'] = 1;
        $_SESSION['subjek_tipe']     = 3;
        ini_set('max_execution_time', 1600);
        ini_set('memory_limit', '2048M');

        $per = $this->get_aktif_periode();

        $subjek    = $_SESSION['subjek_tipe'];
        $mas       = $_SESSION['analisis_master'];
        $sql       = 'SELECT * FROM analisis_indikator WHERE id_master=? ORDER BY id ASC';
        $query     = $this->db->query($sql, $_SESSION['analisis_master']);
        $indikator = $query->result_array();

        $sql   = 'SELECT * FROM a_rts WHERE 1';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $sql = 'DELETE FROM analisis_respon WHERE id_periode=?';
        $this->db->query($sql, [$per]);

        $n = 0;
        //foreach($tdata AS $data){
        $di = 0;

        while ($di < count($data)) {
            $dat       = $data[$di];
            $id_subjek = $data[$di]['id_rts'];

            $j   = 1;
            $all = '';

            foreach ($indikator as $indi) {
                //$k = "'".$j."'";
                $isi = $dat[$j];
                //echo $isi."<br>";
                if ($isi !== '') {
                    if ($indi['id_tipe'] === 1) {
                        $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ?;';
                        $query = $this->db->query($sql, [$indi['id'], $isi]);
                        $param = $query->row_array();

                        if ($param) {
                            $in_param = $param['id'];
                        } else {
                            if ($isi === '') {
                                $in_param = 0;
                            } else {
                                $in_param = -1;
                            }
                        }

                        $respon[$n]['id_parameter'] = $in_param;
                        $respon[$n]['id_indikator'] = $indi['id'];
                        $respon[$n]['id_subjek']    = $id_subjek;
                        $respon[$n]['id_periode']   = $per;
                        $n++;
                    } elseif ($indi['id_tipe'] === 2) {
                        $id_isi = explode(',', $isi);

                        //if(count($id_isi) > 1){
                        //foreach($id_isi AS $ids){
                        //echo "<br>".count($id_isi)." -> ";
                        for ($q = 0; $q < (count($id_isi)); $q++) {
                            //echo $id_isi[$q]." ";
                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND kode_jawaban = ? ;';
                            $query = $this->db->query($sql, [$indi['id'], $id_isi[$q]]);
                            $param = $query->row_array();

                            if ($param['id'] !== '') {
                                $in_param                   = $param['id'];
                                $respon[$n]['id_parameter'] = $in_param;
                                $respon[$n]['id_indikator'] = $indi['id'];
                                $respon[$n]['id_subjek']    = $id_subjek;
                                $respon[$n]['id_periode']   = $per;
                                $n++;
                            }
                        }
                        //}
                    } else {
                        $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                        $query = $this->db->query($sql, [$indi['id'], $isi]);
                        $param = $query->row_array();

                        // apakah sdh ada jawaban yg sama
                        if ($param) {
                            $in_param = $param['id'];
                        } else {
                            $parameter['jawaban']      = $isi;
                            $parameter['id_indikator'] = $indi['id'];
                            $parameter['asign']        = 0;

                            $this->db->insert('analisis_parameter', $parameter);

                            $sql   = 'SELECT id FROM analisis_parameter WHERE id_indikator = ? AND jawaban = ?;';
                            $query = $this->db->query($sql, [$indi['id'], $isi]);
                            $param = $query->row_array();
                            //if($param){
                            $in_param = $param['id'];
                            //}else{
                                //$in_param	= $id_param;
                        //	}
                        }

                        $respon[$n]['id_parameter'] = $in_param;
                        $respon[$n]['id_indikator'] = $indi['id'];
                        $respon[$n]['id_subjek']    = $id_subjek;
                        $respon[$n]['id_periode']   = $per;
                        $n++;
                    }
                }

                $j++;
            }
            $di++;
        }
        if ($n > 0) {
            $outp = $this->db->insert_batch('analisis_respon', $respon);
        } else {
            $outp = false;
        }

        $this->pre_update();

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    //-----------------
    public function get_aktif_periode()
    {
        $sql   = 'SELECT * FROM analisis_periode WHERE aktif=1 AND id_master=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->row_array();

        return $data['id'];
    }

    public function get_analisis_master()
    {
        $sql   = 'SELECT * FROM analisis_master WHERE id=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);

        return $query->row_array();
    }

    public function get_periode()
    {
        $sql   = 'SELECT * FROM analisis_periode WHERE aktif=1 AND id_master=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->row_array();

        return $data['nama'];
    }

    public function list_dusun()
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' ";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function list_rw($dusun = '')
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND dusun = ? AND rw <> '0'";
        $query = $this->db->query($sql, $dusun);

        return $query->result_array();
    }

    public function list_rt($dusun = '', $rw = '')
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rw = ? AND dusun = ? AND rt <> '0'";
        $query = $this->db->query($sql, [$rw, $dusun]);

        return $query->result_array();
    }
}
