<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Surat_master_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM tweb_surat_format';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['nama'] . "'";
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

            return " AND nama LIKE '{$kw}'";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM tweb_surat_format u WHERE 1';
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
            1       => ' ORDER BY u.nomor',
            2       => ' ORDER BY u.nomor DESC',
            3       => ' ORDER BY u.pertanyaan',
            4       => ' ORDER BY u.pertanyaan DESC',
            5       => ' ORDER BY u.id_kategori',
            6       => ' ORDER BY u.id_kategori DESC',
            default => ' ORDER BY u.id',
        };

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.* FROM tweb_surat_format u WHERE 1 ';

        $sql .= $this->search_sql();
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

    public function insert()
    {
        $data = $_POST;

        $data['url_surat'] = str_replace(' ', '_', $data['nama']);
        $data['url_surat'] = strtolower($data['url_surat']);
        $data['url_surat'] = 'surat_' . $data['url_surat'];
        $outp              = $this->db->insert('tweb_surat_format', $data);

        $mypath = 'surat\\' . $data['url_surat'] . '\\';
        $path   = '' . str_replace('\\', '/', $mypath) . '/';

        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $raw      = 'surat\\raw\\';
        $raw_path = '' . str_replace('\\', '/', $raw);
        $file     = $raw_path . 'template.rtf';
        $handle   = fopen($file, 'rb');

        $buffer = stream_get_contents($handle);
        // $handle = fopen($path.$data['url_surat'],'w+');

        $berkas = $path . $data['url_surat'] . '.rtf';
        $handle = fopen($berkas, 'w+b');
        fwrite($handle, $buffer);
        fclose($handle);

        $mypath    = 'donjo-app\\views\\surat\\form\\';
        $path_form = '' . str_replace('\\', '/', $mypath) . '/';

        $raw      = 'surat\\raw\\';
        $raw_path = '' . str_replace('\\', '/', $raw);
        $file     = $raw_path . 'form.raw';
        $handle   = fopen($file, 'rb');

        $buffer = stream_get_contents($handle);
        // $handle = fopen($path_form.$data['url_surat'],'w+');

        $berkas = $path_form . $data['url_surat'] . '.php';
        $handle = fopen($berkas, 'w+b');
        $buffer = str_replace('[nama_surat]', "Surat {$data['nama']}", $buffer);
        fwrite($handle, $buffer);
        fclose($handle);

        $mypath    = 'donjo-app\\views\\surat\\print\\';
        $path_form = '' . str_replace('\\', '/', $mypath) . '/';

        $raw      = 'surat\\raw\\';
        $raw_path = '' . str_replace('\\', '/', $raw);
        $file     = $raw_path . 'print.raw';
        $handle   = fopen($file, 'rb');

        $buffer = stream_get_contents($handle);
        // $handle = fopen($path_form.$data['url_surat'],'w+');

        $berkas     = $path_form . 'print_' . $data['url_surat'] . '.php';
        $handle     = fopen($berkas, 'w+b');
        $nama_surat = strtoupper($data['nama']);
        $buffer     = str_replace('[nama_surat]', "SURAT {$nama_surat}", $buffer);
        fwrite($handle, $buffer);
        fclose($handle);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data = $_POST;
        $this->db->where('id', $id);
        $outp = $this->db->update('tweb_surat_format', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function upload($url = '')
    {
        $name = $_FILES['foto']['name'];
        $name = substr($name, strlen($name) - 4, 4);

        if ($name !== '.rtf') {
            $_SESSION['success'] = -1;
        } else {
            $vdir_upload = "surat/{$url}/{$url}.rtf";
            unlink($vdir_upload);
            move_uploaded_file($_FILES['foto']['tmp_name'], $vdir_upload);
            $_SESSION['success'] = 1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM tweb_surat_format WHERE id=?';
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
                $sql  = 'DELETE FROM tweb_surat_format WHERE id=?';
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

    public function list_atribut($id = 0)
    {
        $sql   = 'SELECT * FROM tweb_surat_atribut WHERE id_surat = ?';
        $query = $this->db->query($sql, $id);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;

            $i++;
        }

        return $data;
    }

    public function get_surat_format($id = 0)
    {
        $sql   = 'SELECT * FROM tweb_surat_format WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function get_tweb_surat_atribut($id = '')
    {
        $sql   = 'SELECT * FROM tweb_surat_atribut WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function favorit($id = 0, $k = 0)
    {
        if ($k === 1) {
            $sql = 'UPDATE tweb_surat_format SET favorit = 0 WHERE id=?';
        } else {
            $sql = 'UPDATE tweb_surat_format SET favorit = 1 WHERE id=?';
        }

        $outp = $this->db->query($sql, $id);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function lock($id = 0, $k = 0)
    {
        if ($k === 1) {
            $sql = 'UPDATE tweb_surat_format SET kunci = 0 WHERE id=?';
        } else {
            $sql = 'UPDATE tweb_surat_format SET kunci = 1 WHERE id=?';
        }

        $outp = $this->db->query($sql, $id);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
