<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Pengurus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('pamong_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== 1 && $grup !== 2) {
            redirect('siteman');
        }
        $this->load->model('header_model');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('pengurus');
    }

    public function index()
    {
        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        $data['main']    = $this->pamong_model->list_data();
        $data['keyword'] = $this->pamong_model->autocomplete();
        $nav['act']      = 1;
        $header          = $this->header_model->get_data();

        $this->load->view('header', $header);

        $this->load->view('home/nav', $nav);
        $this->load->view('home/pengurus', $data);
        $this->load->view('footer');
    }

    public function form($id = '')
    {
        if ($id) {
            $data['pamong']      = $this->pamong_model->get_data($id);
            $data['form_action'] = site_url("pengurus/update/{$id}");
        } else {
            $data['pamong']      = null;
            $data['form_action'] = site_url('pengurus/insert');
        }

        $header = $this->header_model->get_data();

        $this->load->view('header', $header);

        $nav['act'] = 1;
        $this->load->view('home/nav', $nav);
        $this->load->view('home/pengurus_form', $data);
        $this->load->view('footer');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('pengurus');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('pengurus');
    }

    public function insert()
    {
        $this->pamong_model->insert();
        redirect('pengurus');
    }

    public function update($id = '')
    {
        $this->pamong_model->update($id);
        redirect('pengurus');
    }

    public function delete($id = '')
    {
        $this->pamong_model->delete($id);
        redirect('pengurus');
    }

    public function delete_all()
    {
        $this->pamong_model->delete_all();
        redirect('pengurus');
    }
}
