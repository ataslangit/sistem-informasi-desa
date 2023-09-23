<?php

use App\Controllers\BaseController;

class User_setting extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== (1 || 2 || 3 || 4 || 5)) {
            redirect('login');
        }
    }

    public function index()
    {
        $id = $_SESSION['user'];
        $this->header_model->get_data();
        $this->header_model->get_data();
        $data['main'] = $this->user_model->get_user($id);

        view('setting', $data);
        // view('footer');
    }

    public function update($id = '')
    {
        $this->user_model->update_setting($id);
        redirect('main');
    }
}
