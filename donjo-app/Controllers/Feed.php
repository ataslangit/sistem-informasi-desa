<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Feed extends BaseController
{
    public function index()
    {
        $config = new Config();

        $data['data_config'] = $config->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();

        view('feed', $data);
    }
}
