<?php

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
}
