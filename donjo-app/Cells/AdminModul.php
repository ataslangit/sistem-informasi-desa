<?php

namespace App\Cells;

use App\Models\SettingModul;
use CodeIgniter\View\Cells\Cell;

class AdminModul extends Cell
{
    public function nav()
    {
        $grup       = session()->get('grup');
        $modalModul = new SettingModul();

        $moduls = $modalModul
            ->where(['aktif' => '1', 'level >=' => $grup])
            ->findAll();

        return $this->view('admin_modul_cell', compact('moduls'));
    }
}
