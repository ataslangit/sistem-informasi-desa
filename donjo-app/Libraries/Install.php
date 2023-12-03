<?php

namespace App\Libraries;

class Install
{
    /**
     * Cek sudah install atau belum
     * Dianggap sudah install jika ada 'install.sid'
     *
     * @return bool True jika sudah install
     */
    public function cek(): bool
    {
        return is_file(ROOTPATH . 'install.sid');
    }

    /**
     * Proses install database
     *
     * @return array|null Null jika sudah pernah install, string berupa password untuk admin
     */
    public function run()
    {
        if (! $this->cek()) {
            $filename = '../sid.install';
            $templine = '';
            $lines    = file($filename);

            foreach ($lines as $line) {
                if (str_starts_with($line, '--')) {
                    continue;
                }
                if ($line === '') {
                    continue;
                }
                $templine .= $line;
                if (substr(trim($line), -1, 1) === ';') {
                    $this->CI->db->query($templine);
                    $templine = '';
                }
            }
            $passwd      = random_string('alnum', 7);
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
