<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Feed extends CI_Controller
{
    public function index()
    {
        $header              = $this->header_model->get_data();
        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        view('feed', $data);
    }
}
