<?php

namespace App\Controllers;

class User_setting extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3', '4', '5'], true)) {
            return redirect()->to('login');
        }
    }

    public function index()
    {
        $id     = $_SESSION['user'];
        $header = $this->header_model->get_data();
        //echo view('header', $header);

        $header       = $this->header_model->get_data();
        $data['main'] = $this->user_model->get_user($id);

        echo view('setting', $data);
        //echo view('footer');
    }

    public function update($id = '')
    {
        $this->user_model->update_setting($id);

        return redirect()->to('main');
    }
}
