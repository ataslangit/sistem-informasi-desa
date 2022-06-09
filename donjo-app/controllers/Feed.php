<?php

class Feed extends CI_Controller
{
    public function index()
    {
        $header              = $this->header_model->get_data();
        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        $this->load->view('feed', $data);
    }
}
