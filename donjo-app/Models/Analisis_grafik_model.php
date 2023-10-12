<?php

use App\Libraries\Paging;
use App\Models\AnalisisPeriode;
use App\Models\BaseModel as Model;

class Analisis_grafik_model extends Model
{
    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND (u.pertanyaan LIKE '{$kw}' OR u.pertanyaan LIKE '{$kw}')";
        }
    }

    public function master_sql()
    {
        if (isset($_SESSION['analisis_master'])) {
            $kf = $_SESSION['analisis_master'];

            return " AND u.id_master = {$kf}";
        }
    }

    public function dusun_sql()
    {
        if (isset($_SESSION['dusun'])) {
            $kf = $_SESSION['dusun'];

            return " AND c.dusun = '{$kf}'";
        }
    }

    public function rw_sql()
    {
        if (isset($_SESSION['rw'])) {
            $kf = $_SESSION['rw'];

            return " AND c.rw = '{$kf}'";
        }
    }

    public function rt_sql()
    {
        if (isset($_SESSION['rt'])) {
            $kf = $_SESSION['rt'];

            return " AND c.rt = '{$kf}'";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM analisis_klasifikasi u WHERE 1';
        $sql .= $this->search_sql();
        $sql .= $this->master_sql();
        $query    = $this->db->query($sql);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function list_data($o = 0, $offset = 0, $limit = 500)
    {
        $per     = $this->get_aktif_periode();
        $pembagi = $this->get_analisis_master();
        $pembagi = $pembagi['pembagi'] + 0;

        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.minval';
                break;

            case 2: $order_sql = ' ORDER BY u.minval DESC';
                break;

            case 3: $order_sql = ' ORDER BY u.minval';
                break;

            case 4: $order_sql = ' ORDER BY u.minval DESC';
                break;

            case 5: $order_sql = ' ORDER BY g.minval';
                break;

            case 6: $order_sql = ' ORDER BY g.minval DESC';
                break;

            default:$order_sql = ' ORDER BY u.minval';
        }

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = "SELECT u.*,(SELECT COUNT(id) FROM analisis_respon_hasil WHERE akumulasi/{$pembagi} >= u.minval AND akumulasi/{$pembagi} < u.maxval AND id_periode=?) as jumlah FROM analisis_klasifikasi u WHERE 1 ";

        $sql .= $this->search_sql();
        $sql .= $this->master_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql, $per);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;

            $i++;
            $j++;
        }

        return $data;
    }

    public function list_data2($o = 0, $offset = 0, $limit = 500)
    {
        $this->get_aktif_periode();
        $pembagi = $this->get_analisis_master();
        $pembagi = $pembagi['pembagi'] + 0;

        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.minval';
                break;

            case 2: $order_sql = ' ORDER BY u.minval DESC';
                break;

            case 3: $order_sql = ' ORDER BY u.minval';
                break;

            case 4: $order_sql = ' ORDER BY u.minval DESC';
                break;

            case 5: $order_sql = ' ORDER BY g.minval';
                break;

            case 6: $order_sql = ' ORDER BY g.minval DESC';
                break;

            default:$order_sql = ' ORDER BY u.minval';
        }

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.* FROM analisis_klasifikasi u WHERE 1 ';

        $sql .= $this->search_sql();
        $sql .= $this->master_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;

            $sql                = "SELECT COUNT(id) as jml FROM analisis_respon_hasil WHERE akumulasi/{$pembagi} > ? AND akumulasi/{$pembagi} <=? group by id_periode order by id_periode";
            $query              = $this->db->query($sql, [$data[$i]['minval'], $data[$i]['maxval']]);
            $data[$i]['jumlah'] = $query->result_array();

            $i++;
            $j++;
        }

        return $data;
    }

    public function get_analisis_master()
    {
        $sql   = 'SELECT * FROM analisis_master WHERE id=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);

        return $query->row_array();
    }

    public function get_subjek($id = 0)
    {
        $sql   = 'SELECT u.*,p.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id WHERE u.id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function get_aktif_periode()
    {
        $analisisPeriode = new AnalisisPeriode();

        return $analisisPeriode->get_aktif_periode();
    }
}
