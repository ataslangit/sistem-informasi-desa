<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Mandiri_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nik FROM tweb_penduduk_mandiri';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['nik'] . "'";
            $i++;
        }
        $outp = substr($outp, 1);

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND (u.nik LIKE '{$kw}' OR n.nama LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['nik'])) {
            $kf = $_SESSION['nik'];
            if ($kf === '0') {
                return '';
            }

            return " AND n.id = '" . $kf . "'";
        }
    }

    public function filterku_sql($nik = 0)
    {
        $kf = $nik;
        if ($kf === 0) {
            return '';
        }

        return " AND u.id_pend = '" . $kf . "'";
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM tweb_penduduk_mandiri u
			LEFT JOIN tweb_penduduk n ON u.nik = n.nik
			WHERE 1';
        $sql .= $this->search_sql();
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
            1       => ' ORDER BY u.last_login',
            2       => ' ORDER BY u.last_login DESC',
            default => ' ORDER BY u.tanggal_buat',
        };

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.*,n.nama AS nama, n.nik AS nik
			FROM tweb_penduduk_mandiri u
			LEFT JOIN tweb_penduduk n ON u.nik = n.nik
			WHERE 1 ';

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
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

    public function generate_pin($pin = '')
    {
        if ($pin === '') {
            $pin = random_int(100000, 999999);
            $pin = strrev($pin);
        }

        return $pin;
    }

    public function insert()
    {
        if ($_POST['nik'] === '') {
            redirect('mandiri');
        }

        $sql = 'DELETE FROM tweb_penduduk_mandiri WHERE nik=?';
        $this->db->query($sql, [$_POST['nik']]);

        $rpin        = $this->generate_pin($_POST['pin']);
        $hash_pin    = hash_pin($rpin);
        $data['pin'] = $hash_pin;
        $data['nik'] = $_POST['nik'];

        $this->db->insert('tweb_penduduk_mandiri', $data);

        if ($_POST['pin'] !== '') {
            return $_POST['pin'];
        }

        return $rpin;
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM tweb_penduduk_mandiri WHERE id=?';
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
                $sql  = 'DELETE FROM tweb_penduduk_mandiri WHERE id=?';
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

    public function list_penduduk()
    {
        $sql   = "SELECT nik AS id,nik,nama FROM tweb_penduduk WHERE status = 1 AND nik<>'' ";
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['alamat'] = 'Alamat :' . $data[$i]['nama'];
            $i++;
        }

        return $data;
    }

    public function update_setting($id = 0)
    {
        $password   = md5($this->input->post('pass_lama'));
        $pass_baru  = $this->input->post('pass_baru');
        $pass_baru1 = $this->input->post('pass_baru1');
        $nama       = $this->input->post('nama');

        $sql   = 'SELECT password,id_grup,session FROM user WHERE id=?';
        $query = $this->db->query($sql, [$id]);
        $row   = $query->row();

        if ($password === $row->password) {
            if ($pass_baru === $pass_baru1) {
                $pass_baru = md5($pass_baru);
                $sql       = 'UPDATE user SET password=?,nama=? WHERE id=?';
                $outp      = $this->db->query($sql, [$pass_baru, $nama, $id]);
            }
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function list_grup()
    {
        $sql   = 'SELECT * FROM user_grup';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
