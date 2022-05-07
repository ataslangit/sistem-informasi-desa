<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Siteman extends BaseController
{
    /**
     * Tampilkan halaman login
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title' => 'Masuk',
        ];

        return view('backend/siteman', $data);
    }
}
