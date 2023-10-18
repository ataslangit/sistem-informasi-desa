<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Feed extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('header_model');
        $this->load->model('feed_model');
        $this->load->model('config_model');
    }

    public function index()
    {
        $header              = $this->header_model->get_data();
        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        view('feed', $data);
    }
}
