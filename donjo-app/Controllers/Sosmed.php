<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Sosmed extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            return redirect()->to('siteman');
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

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('sosmed/facebook', $data);
        echo view('footer');
    }

    public function twitter()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(2);
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("sosmed/update/2/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('sosmed/twitter', $data);
        echo view('footer');
    }

    public function instagram()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(5);
        $data['form_action'] = site_url('sosmed/update/5');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('sosmed/google', $data);
        echo view('footer');
    }

    public function google()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(3);
        $data['form_action'] = site_url('sosmed/update/3');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('sosmed/instagram', $data);
        echo view('footer');
    }

    public function youtube()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(4);
        $data['form_action'] = site_url('sosmed/update/4');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('sosmed/youtube', $data);
        echo view('footer');
    }

    public function update($id = '')
    {
        $this->web_sosmed_model->update($id);
        if ($id === '1') {
            return redirect()->to('sosmed');
        }
        if ($id === '2') {
            return redirect()->to('sosmed/twitter');
        }
        if ($id === '3') {
            return redirect()->to('sosmed/google');
        }
        if ($id === '4') {
            return redirect()->to('sosmed/youtube');
        }

        return redirect()->to('sosmed/instagram');
    }
}
