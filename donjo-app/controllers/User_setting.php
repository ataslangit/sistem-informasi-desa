<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class User_setting extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== (1 || 2 || 3 || 4 || 5)) {
            redirect('login');
        }
        $this->load->model('header_model');
    }

    public function index()
    {
        $id     = $_SESSION['user'];
        $header = $this->header_model->get_data();
        // view('header', $header);

        $header       = $this->header_model->get_data();
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
