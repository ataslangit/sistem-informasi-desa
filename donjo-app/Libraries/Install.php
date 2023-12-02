<?php

namespace App\Libraries;

class Install
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Cek sudah install atau belum
     *
     * @return bool True jika sudah install
     */
    public function cek(): bool
    {
        $db    = $this->CI->db->dbprefix . $this->CI->db->database;
        $sql   = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA=? AND TABLE_NAME <> 'impor'";
        $query = $this->CI->db->query($sql, $db);
        $data  = $query->result_array();

        return ! (count($data) !== 77);
    }

    /**
     * Proses install database
     *
     * @return array|null Null jika sudah pernah install, string berupa password untuk admin
     */
    public function run()
    {
        $this->CI->load->model('config_model');

        if (! $this->cek()) {
            $filename = '../sid.install';
            $templine = '';
            $lines    = file($filename);

            foreach ($lines as $line) {
                if (substr($line, 0, 2) === '--' || $line === '') {
                    continue;
                }
                $templine .= $line;
                if (substr(trim($line), -1, 1) === ';') {
                    $this->CI->db->query($templine);
                    $templine = '';
                }
            }
            $passwd      = generator();
            $out['pass'] = $passwd;
            $idsid       = hash_password($passwd);

            $skrg   = date('Y-m-d H:i:s');
            $macid  = $this->sysinfo();
            $ids    = "user:admin\r\npass:" . $passwd . "\r\nidr:" . $idsid . "\r\nids:" . $macid;
            $handle = fopen('../install.sid', 'w+b');
            fwrite($handle, $ids);
            fclose($handle);

            $reg['regid'] = $idsid;
            $reg['macid'] = $macid;
            $this->CI->db->where('id', '1');
            $this->CI->db->update('config', $reg);

            $sql = "INSERT INTO user VALUES (1,'admin','{$idsid}',1,'admin@localhost','{$skrg}',1,'Administrator','ADMIN','0123456789','','{$idsid}');";
            $this->CI->db->query($sql);

            $this->CI->config_model->initsurat();
            $this->CI->config_model->gawe_surat();

            return $out;
        }

        return null;
    }

    /**
     * Mengambil data informasi terkait PC yang digunakan
     * bisa berasal dari Product ID, System Model atau BIOS Version
     *
     * TODO: cek kegunaan fungsi sebenarnya untuk apa
     */
    public function sysinfo(): string
    {
        exec('systeminfo', $data);

        $value = '';

        foreach ($data as $item) {
            if (strpos($item, 'Product ID') !== false) {
                $exploded = explode(':', $item);
                if (count($exploded) > 1) {
                    $value = trim($exploded[1]);
                    break;
                }
            } elseif (strpos($item, 'System Model') !== false) {
                $exploded = explode(':', $item);
                if (count($exploded) > 1) {
                    $value = trim($exploded[1]);
                    break;
                }
            } elseif (strpos($item, 'BIOS Version') !== false) {
                $exploded = explode(':', $item);
                if (count($exploded) > 1) {
                    $value = trim($exploded[1]);
                    break;
                }
            }
        }

        return $value;
    }
}
