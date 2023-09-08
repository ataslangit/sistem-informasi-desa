<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Laporan_penduduk_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT dusun_nama FROM tweb_wil_dusun';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['dusun_nama'] . "'";
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND u.nama LIKE '{$kw}'";
        }
    }

    public function paging($lap = 0, $o = 0)
    {
        $paging = new Paging();

        $sql = match ($lap) {
            0       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 ',
            1       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_pekerjaan u WHERE 1 ',
            2       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_kawin u WHERE 1 ',
            3       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_agama u WHERE 1 ',
            4       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_sex u WHERE 1 ',
            5       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_warganegara u WHERE 1 ',
            6       => 'SELECT COUNT(id) AS id FROM tweb_penduduk_status u WHERE 1 ',
            7       => 'SELECT COUNT(id) AS id FROM tweb_golongan_darah u WHERE 1 ',
            9       => 'SELECT COUNT(id) AS id FROM tweb_cacat u WHERE 1 ',
            10      => 'SELECT COUNT(id) AS id FROM tweb_sakit_menahun u WHERE 1 ',
            11      => 'SELECT COUNT(id) AS id FROM tweb_penduduk_sex u WHERE 1 ',
            12      => 'SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan_kk u WHERE 1 ',
            13      => 'SELECT COUNT(id) AS id FROM tweb_penduduk_umur u WHERE status = 1 ',
            15      => 'SELECT COUNT(id) AS id FROM tweb_penduduk_umur u WHERE status is null ',
            14      => "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE left(nama,5)<> 'TAMAT' ",
            21      => "SELECT COUNT(id) AS id FROM klasifikasi_analisis_keluarga u WHERE jenis='1' ",
            22      => 'SELECT COUNT(id) AS id FROM ref_raskin u WHERE 1 ',
            23      => 'SELECT COUNT(id) AS id FROM ref_blt u WHERE 1 ',
            24      => 'SELECT COUNT(id) AS id FROM ref_bos u WHERE 1 ',
            25      => 'SELECT COUNT(id) AS id FROM ref_pkh u WHERE 1 ',
            26      => 'SELECT COUNT(id) AS id FROM ref_jampersal u WHERE 1 ',
            27      => 'SELECT COUNT(id) AS id FROM ref_bedah_rumah u WHERE 1 ',
            default => 'SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 ',
        };

        $query    = $this->db->query($sql);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $cfg['page']     = $o;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function list_data($lap = 0, $o = 0)
    {
        $order_sql = match ($o) {
            1       => ' ORDER BY u.id',
            2       => ' ORDER BY u.id DESC',
            3       => ' ORDER BY laki',
            4       => ' ORDER BY laki DESC',
            5       => ' ORDER BY jumlah',
            6       => ' ORDER BY jumlah DESC',
            7       => ' ORDER BY perempuan',
            8       => ' ORDER BY perempuan DESC',
            default => '',
        };

        $sql = match ($lap) {
            0       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_pendidikan_kk u WHERE 1',
            1       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_pekerjaan u WHERE 1 ',
            2       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_kawin u WHERE 1',
            3       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_agama u WHERE 1',
            4       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = u.id AND sex=1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = 2 AND sex=u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_sex u WHERE 1',
            5       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex=1 AND status_dasar=1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_warganegara u WHERE 1',
            6       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id AND sex=1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_status u WHERE u.id <> 77 ',
            7       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id AND sex=1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_golongan_darah u WHERE 1',
            9       => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_id = u.id AND sex=1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_cacat u WHERE 1',
            10      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id AND sex=1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_sakit_menahun u WHERE 1',
            11      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM ref_jamkesmas u WHERE 1',
            12      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_id = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_pendidikan u WHERE 1 ',
            13      => "SELECT u.*, concat( dari, ' - ', sampai) as nama, (SELECT COUNT(id) FROM tweb_penduduk WHERE (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=u.dari AND (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=u.sampai AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah, (SELECT COUNT(id) FROM tweb_penduduk WHERE (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=u.dari AND (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=u.sampai AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki, (SELECT COUNT(id) FROM tweb_penduduk WHERE (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=u.dari AND (DATE_FORMAT( FROM_DAYS( TO_DAYS( NOW( ) ) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=u.sampai AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_umur u WHERE status=1 ",
            14      => "SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id AND status_dasar = 1 AND (status = 1 OR status = 2)) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id AND sex = 1 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id AND sex = 2 AND status_dasar = 1 AND (status = 1 OR status = 2)) AS perempuan FROM tweb_penduduk_pendidikan u WHERE left(nama,5)<> 'TAMAT'",
            15      => "SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai AND sex=1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai AND sex=2) AS perempuan FROM tweb_penduduk_umur u WHERE status is NULL ",
            21      => "SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE kelas_sosial = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM klasifikasi_analisis_keluarga u WHERE jenis='1'",
            22      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE raskin = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_raskin u WHERE 1 ',
            23      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE id_blt = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_blt u WHERE 1 ',
            24      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE id_bos = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_bos u WHERE 1 ',
            25      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE id_pkh = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_pkh u WHERE 1 ',
            26      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE id_jampersal = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_jampersal u WHERE 1 ',
            27      => 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE id_bedah_rumah = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_bedah_rumah u WHERE 1 ',
            default => 'SELECT u.* FROM tweb_penduduk_pendidikan u WHERE 1 ',
        };

        $sql .= $order_sql;
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        if ($lap <= 20) {
            $sql3 = 'SELECT (SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.status_dasar=1 AND (status = 1 OR status = 2)) AS jumlah,
			(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.sex = 1 and status_dasar=1 AND (status = 1 OR status = 2)) AS laki,
			(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.sex = 2 and status_dasar=1 AND (status = 1 OR status = 2)) AS perempuan';
        } else {
            $sql3 = 'SELECT (SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS jumlah,
			(SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS laki,
			(SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS perempuan';
        }

        $query3 = $this->db->query($sql3);
        $bel    = $query3->row_array();

        $total['jumlah']    = 0;
        $bel['no']          = '';
        $bel['id']          = '0';
        $bel['nama']        = 'TOTAL';
        $total['laki']      = 0;
        $total['perempuan'] = 0;
        $i                  = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;

            $total['jumlah'] += $data[$i]['jumlah'];
            $total['laki'] += $data[$i]['laki'];
            $total['perempuan'] += $data[$i]['perempuan'];

            $i++;
        }

        // BELEUM MENGISI
        $data[$i]['no']        = '';
        $data[$i]['id']        = 777;
        $data[$i]['nama']      = 'BELUM MENGISI';
        $data[$i]['jumlah']    = $bel['jumlah'] - $total['jumlah'];
        $data[$i]['perempuan'] = $bel['perempuan'] - $total['perempuan'];
        $data[$i]['laki']      = $bel['laki'] - $total['laki'];

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['persen'] = $data[$i]['jumlah'] / $bel['jumlah'] * 100;
            $data[$i]['persen'] = number_format((float) $data[$i]['persen'], 2, '.', '');
            $data[$i]['persen'] = $data[$i]['persen'] . '%';

            $data[$i]['persen1'] = $data[$i]['laki'] / $bel['jumlah'] * 100;
            $data[$i]['persen1'] = number_format((float) $data[$i]['persen1'], 2, '.', '');
            $data[$i]['persen1'] = $data[$i]['persen1'] . '%';

            $data[$i]['persen2'] = $data[$i]['perempuan'] / $bel['jumlah'] * 100;
            $data[$i]['persen2'] = number_format((float) $data[$i]['persen2'], 2, '.', '');
            $data[$i]['persen2'] = $data[$i]['persen2'] . '%';

            $i++;
        }

        $bel['persen'] = '100%';

        $bel['persen1'] = $bel['laki'] / $bel['jumlah'] * 100;
        $bel['persen1'] = number_format((float) $bel['persen1'], 2, '.', '');
        $bel['persen1'] = $bel['persen1'] . '%';

        $bel['persen2'] = $bel['perempuan'] / $bel['jumlah'] * 100;
        $bel['persen2'] = number_format((float) $bel['persen2'], 2, '.', '');
        $bel['persen2'] = $bel['persen2'] . '%';

        $data['total'] = $bel;

        return $data;
    }

    public function list_data_rentang()
    {
        $sql   = 'SELECT * FROM tweb_penduduk_umur WHERE status=1 order by dari ';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function get_rentang($id = 0)
    {
        $sql   = "SELECT * FROM tweb_penduduk_umur WHERE id= {$id} ";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function get_rentang_terakhir()
    {
        $sql   = "SELECT (case when max(sampai) is null then '0' else (max(sampai)+1) end) as dari FROM tweb_penduduk_umur WHERE status=1 ";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function insert_rentang()
    {
        $data           = $_POST;
        $data['status'] = 1;
        $outp           = $this->db->insert('tweb_penduduk_umur', $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_rentang($id = 0)
    {
        $data = $_POST;
        $sql  = "UPDATE tweb_penduduk_umur SET nama='{$data['nama']}', dari='{$data['dari']}', sampai='{$data['sampai']}' WHERE id='{$id}' ";
        $outp = $this->db->query($sql);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_rentang($id = 0)
    {
        $sql  = "DELETE FROM tweb_penduduk_umur WHERE id='{$id}' ";
        $outp = $this->db->query($sql);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all_rentang()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM tweb_penduduk_umur WHERE id=?';
                $outp = $this->db->query($sql, [$id]);
            }
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
