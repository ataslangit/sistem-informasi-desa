<?php

use Kenjis\CI3Compatible\Core\CI_Model;

class First_menu_m extends CI_Model
{
    public function list_menu_atas()
    {
        $query = $this->db->where([
            'parrent' => 1,
            'enabled' => 1,
            'tipe'    => 1,
        ])->order_by('id', 'asc')
            ->get('menu');

        $data = $query->result_array();

        $i = 0;

        while ($i < count($data)) {
            $data[$i]['menu'] = '<li><a href="' . site_url('first/' . $data[$i]['link']) . '">' . $data[$i]['nama'] . '</a>';

            $sql2 = 'SELECT s.* FROM menu s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';

            $query = $this->db->where([
                'parrent' => $data[$i]['id'],
                'enabled' => 1,
                'tipe'    => '3',
            ])->get('menu');
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['menu'] .= '<ul>';
                $j = 0;

                while ($j < count($data2)) {
                    $data[$i]['menu'] = $data[$i]['menu'] . '<li><a href="' . site_url('first/' . $data2[$j]['link']) . '">' . $data2[$j]['nama'] . '</a></li>';

                    $j++;
                }
                $data[$i]['menu'] .= '</ul>';
            }
            $data[$i]['menu'] .= '</li>';
            $i++;
        }

        return $data;
    }

    public function list_menu_kiri()
    {
        $query = $this->db->
        select('*, kategori as nama')->
        where([
            'parrent'     => 0,
            'enabled'     => 1,
            'kategori !=' => 'teks_berjalan',
        ])->order_by('id')->get('kategori');

        $data = $query->result_array();
        $i    = 0;

        while ($i < count($data)) {
            $data[$i]['menu'] = '<li><a href="' . site_url('first/kategori/' . $data[$i]['id']) . '">' . $data[$i]['nama'] . '</a>';

            $query = $this->db->select('*, kategori as nama')->
            where([
                'parrent' => $data[$i]['id'],
                'enabled' => 1,
            ])->get('kategori');

            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['menu'] .= '<ul>';
                $j = 0;

                while ($j < count($data2)) {
                    $data[$i]['menu'] = $data[$i]['menu'] . '<li><a href="' . site_url('first/kategori/' . $data2[$j]['id']) . '">' . $data2[$j]['nama'] . '</a></li>';
                    $j++;
                }
                $data[$i]['menu'] .= '</ul>';
            }
            $data[$i]['menu'] .= '</li>';
            $i++;
        }

        return $data;
    }
}
