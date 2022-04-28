<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Widget extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2',  '3'], true)) {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_widget_model');
    }

    public function index()
    {
        $data['main']        = $this->web_widget_model->get_widget();
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("web/widget/update/1/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 5;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('web/widget/facebook', $data);
        $this->load->view('footer');
    }

    public function twitter()
    {
        $data['main']        = $this->web_widget_model->get_widget();
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("web/widget/update/2/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 5;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('web/widget/twitter', $data);
        $this->load->view('footer');
    }

    public function update($tipe = '', $id = '')
    {
        $this->web_widget_model->update($id);
        if ($tipe === '1') {
            redirect('web/widget');
        } else {
            redirect('web/widget/twitter');
        }
    }
}
