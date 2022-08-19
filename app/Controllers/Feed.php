<?php

namespace App\Controllers;

class Feed extends BaseController
{
    public function index()
    {
        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        $this->load->view('feed', $data);
    }
}
