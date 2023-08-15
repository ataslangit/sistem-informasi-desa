<?php

use App\Controllers\BaseController;

class Feed extends BaseController
{
    public function index()
    {
        $header              = $this->header_model->get_data();
        $data['data_config'] = $this->config_model->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();
        view('feed', $data);
    }
}
