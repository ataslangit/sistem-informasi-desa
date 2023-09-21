<?php

use App\Libraries\Paging;
use App\Models\AnalisisPeriode;
use App\Models\BaseModel as Model;

class Analisis_periode_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM analisis_periode';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ',"' . $data[$i]['nama'] . '"';
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

    public function state_sql()
    {
        if (isset($_SESSION['state'])) {
            $kf = $_SESSION['state'];

            return " AND u.id_state = {$kf}";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM analisis_periode u WHERE 1';
        $sql .= $this->search_sql();
        $sql .= $this->master_sql();
        $sql .= $this->state_sql();
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
        $order_sql = match ($o) {
            1       => ' ORDER BY u.id',
            2       => ' ORDER BY u.id DESC',
            3       => ' ORDER BY u.id',
            4       => ' ORDER BY u.id DESC',
            5       => ' ORDER BY g.id',
            6       => ' ORDER BY g.id DESC',
            default => ' ORDER BY u.id',
        };

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.*,s.nama AS status FROM analisis_periode u LEFT JOIN analisis_ref_state s ON u.id_state = s.id WHERE 1 ';

        $sql .= $this->search_sql();
        $sql .= $this->master_sql();
        $sql .= $this->state_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;

            if ($data[$i]['aktif'] === 1) {
                $data[$i]['aktif'] = "<img src='" . base_url('assets/images/icon/tick.png') . "'>";
            } else {
                $data[$i]['aktif'] = '';
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function insert()
    {
        $analisisPeriodeModel = new AnalisisPeriode();
        $data                 = $_POST;
        $dp                   = $data['duplikasi'];
        unset($data['duplikasi']);

        if ($dp === 1) {
            $sqld   = 'SELECT id FROM analisis_periode WHERE id_master=? ORDER BY id DESC LIMIT 1';
            $queryd = $this->db->query($sqld, $_SESSION['analisis_master']);
            $dpd    = $queryd->row_array();
            $sblm   = $dpd['id'];
        }

        $akt               = [];
        $data['id_master'] = $_SESSION['analisis_master'];
        if ($data['aktif'] === 1) {
            $analisisPeriodeModel = new AnalisisPeriode();
            $akt['aktif']         = 2;

            $analisisPeriodeModel->update(null, $_SESSION['analisis_master'], $akt);
        }
        $outp = $analisisPeriodeModel->insert($data);

        if ($dp === 1) {
            $sqld   = 'SELECT id FROM analisis_periode WHERE id_master=? ORDER BY id DESC LIMIT 1';
            $queryd = $this->db->query($sqld, $_SESSION['analisis_master']);
            $dpd    = $queryd->row_array();
            $skrg   = $dpd['id'];

            $sql   = 'SELECT id_subjek,id_indikator,id_parameter FROM analisis_respon WHERE id_periode = ? ';
            $query = $this->db->query($sql, $sblm);
            $data  = $query->result_array();

            $i = 0;

            while ($i < (is_countable($data) ? count($data) : 0)) {
                $data[$i]['id_periode'] = $skrg;
                $i++;
            }
            $outp = $this->db->insert_batch('analisis_respon', $data);

            $this->analisis_respon_model->pre_update($skrg);
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $analisisPeriode = new AnalisisPeriode();
        $data            = $_POST;
        $akt             = [];

        $data['id_master'] = $_SESSION['analisis_master'];
        if ($data['aktif'] === 1) {
            $akt['aktif'] = 2;
            $analisisPeriode->update(null, $_SESSION['analisis_master'], $akt);
        }
        $data['id_master'] = $_SESSION['analisis_master'];
        $outp              = $analisisPeriode->update($id, null, $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM analisis_periode WHERE id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM analisis_periode WHERE id=?';
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

    public function get_analisis_periode($id = 0)
    {
        $sql   = 'SELECT * FROM analisis_periode WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function get_analisis_master()
    {
        $sql   = 'SELECT * FROM analisis_master WHERE id=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);

        return $query->row_array();
    }

    public function list_state()
    {
        $sql   = 'SELECT * FROM analisis_ref_state';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
