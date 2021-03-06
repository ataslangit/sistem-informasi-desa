<?php

class User_setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3', '4', '5'], true)) {
            redirect('login');
        }
    }

    public function index()
    {
        $id     = $_SESSION['user'];
        $header = $this->header_model->get_data();
        //$this->load->view('header', $header);

        $header       = $this->header_model->get_data();
        $data['main'] = $this->user_model->get_user($id);

        $this->load->view('setting', $data);
        //$this->load->view('footer');
    }

    public function update($id = '')
    {
        $this->user_model->update_setting($id);
        redirect('main');
    }
}
