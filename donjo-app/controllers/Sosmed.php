<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Sosmed extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== 1 && $grup !== 2 && $grup !== 3) {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_sosmed_model');
    }

    public function index()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(1);
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url('sosmed/update/1');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('sosmed/facebook', $data);
        $this->load->view('footer');
    }

    public function twitter()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(2);
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("sosmed/update/2/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('sosmed/twitter', $data);
        $this->load->view('footer');
    }

    public function instagram()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(5);
        $data['form_action'] = site_url('sosmed/update/5');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('sosmed/google', $data);
        $this->load->view('footer');
    }

    public function google()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(3);
        $data['form_action'] = site_url('sosmed/update/3');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('sosmed/instagram', $data);
        $this->load->view('footer');
    }

    public function youtube()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(4);
        $data['form_action'] = site_url('sosmed/update/4');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('sosmed/youtube', $data);
        $this->load->view('footer');
    }

    public function update($id = '')
    {
        $this->web_sosmed_model->update($id);
        if ($id === '1') {
            redirect('sosmed');
        } elseif ($id === '2') {
            redirect('sosmed/twitter');
        } elseif ($id === '3') {
            redirect('sosmed/google');
        } elseif ($id === '4') {
            redirect('sosmed/youtube');
        } else {
            redirect('sosmed/instagram');
        }
    }
}
