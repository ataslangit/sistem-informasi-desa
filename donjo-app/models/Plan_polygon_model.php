<?php

class Plan_polygon_model extends CI_Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM polygon';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < count($data)) {
            $outp .= ',"' . $data[$i]['nama'] . '"';
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari       = $_SESSION['cari'];
            $kw         = $this->db->escape_like_str($cari);
            $kw         = '%' . $kw . '%';
            $search_sql = " AND (nama LIKE '{$kw}')";

            return $search_sql;
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf         = $_SESSION['filter'];
            $filter_sql = " AND enabled = {$kf}";

            return $filter_sql;
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $sql = 'SELECT COUNT(id) AS id FROM polygon WHERE tipe = 0 ';
        $sql .= $this->search_sql();
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
        switch ($o) {
            case 1: $order_sql = ' ORDER BY nama'; break;

            case 2: $order_sql = ' ORDER BY nama DESC'; break;

            case 3: $order_sql = ' ORDER BY enabled'; break;

            case 4: $order_sql = ' ORDER BY enabled DESC'; break;

            default:$order_sql = ' ORDER BY id';
        }
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT * FROM polygon WHERE tipe = 0 ';

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < count($data)) {
            $data[$i]['no'] = $j + 1;

            if ($data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function insert()
    {
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $outp           = $this->db->insert('polygon', $data);
            }
        } else {
            unset($data['simbol']);
            $outp = $this->db->insert('polygon', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $this->db->where('id', $id);
                $outp = $this->db->update('polygon', $data);
            }
            $_SESSION['success'] = 1;
        }

        unset($data['simbol']);
        $this->db->where('id', $id);
        $outp = $this->db->update('polygon', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM polygon WHERE id=?';
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

        if (count($id_cb)) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM polygon WHERE id=?';
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

    public function list_sub_polygon($polygon = 1)
    {
        $sql = 'SELECT * FROM polygon WHERE parrent = ? AND tipe = 2 ';

        $query = $this->db->query($sql, $polygon);
        $data  = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
        }

        return $data;
    }

    public function insert_sub_polygon($parrent = 0)
    {
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data            = $_POST;
                $data['simbol']  = $nama_file;
                $data['parrent'] = $parrent;
                $data['tipe']    = 2;
                $outp            = $this->db->insert('polygon', $data);
                if ($outp) {
                    $_SESSION['success'] = 1;
                }
            } else {
                $_SESSION['success'] = -1;
            }
        } else {
            $data = $_POST;
            unset($data['simbol']);
            $data['parrent'] = $parrent;
            $data['tipe']    = 2;
            $outp            = $this->db->insert('polygon', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_sub_polygon($id = 0)
    {
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $this->db->where('id', $id);
                $outp = $this->db->update('polygon', $data);
            }
            $_SESSION['success'] = 1;
        } else {
            unset($data['simbol']);
            $this->db->where('id', $id);
            $outp = $this->db->update('polygon', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_sub_polygon($id = '')
    {
        $sql  = 'DELETE FROM polygon WHERE id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all_sub_polygon()
    {
        $id_cb = $_POST['id_cb'];

        if (count($id_cb)) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM polygon WHERE id=?';
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

    public function polygon_lock($id = '', $val = 0)
    {
        $sql  = 'UPDATE polygon SET enabled=? WHERE id=?';
        $outp = $this->db->query($sql, [$val, $id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_polygon($id = 0)
    {
        $sql   = 'SELECT * FROM polygon WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function polygon_show()
    {
        $sql   = 'SELECT * FROM polygon WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }

    public function list_polygon_atas()
    {
        $sql = 'SELECT m.* FROM polygon m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 1';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < count($data)) {
            $data[$i]['polygon'] = "<li><a href='{$url}/" . $data[$i]['simbol'] . "'>" . $data[$i]['nama'] . '</a>';

            $sql2  = 'SELECT s.* FROM polygon s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['polygon'] = $data[$i]['polygon'] . '<ul>';
                $j                   = 0;

                while ($j < count($data2)) {
                    $data[$i]['polygon'] = $data[$i]['polygon'] . "<li><a href='{$url}/" . $data2[$j]['simbol'] . "'>" . $data2[$j]['nama'] . '</a></li>';
                    $j++;
                }
                $data[$i]['polygon'] = $data[$i]['polygon'] . '</ul>';
            }
            $data[$i]['polygon'] = $data[$i]['polygon'] . '</li>';
            $i++;
        }

        return $data;
    }

    public function list_polygon_kiri()
    {
        $sql = 'SELECT m.* FROM polygon m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 2';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < count($data)) {
            $data[$i]['polygon'] = "<li><a href='{$url}/" . $data[$i]['simbol'] . "'>" . $data[$i]['nama'] . '</a>';

            $sql2  = 'SELECT s.* FROM polygon s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['polygon'] = $data[$i]['polygon'] . '<ul>';
                $j                   = 0;

                while ($j < count($data2)) {
                    $data[$i]['polygon'] = $data[$i]['polygon'] . "<li><a href='{$url}/" . $data2[$j]['simbol'] . "'>" . $data2[$j]['nama'] . '</a></li>';
                    $j++;
                }
                $data[$i]['polygon'] = $data[$i]['polygon'] . '</ul>';
            }
            $data[$i]['polygon'] = $data[$i]['polygon'] . '</li>';
            $i++;
        }

        return $data;
    }
}
