<?php

namespace App\Controllers;

class Install extends BaseController
{
    public function index()
    {
        $step = $this->request->getGet('step');

        if ($step === null || $step === '' || ! is_numeric($step)) {
            return redirect()->to('install?step=0');
        }

        return view('public/install', compact('step'));
    }

    public function mulai()
    {
        // code...
    }
}
