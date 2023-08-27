<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Feed extends BaseController
{
    public function index()
    {
        $configModel = new Config();

        $data['data_config'] = $configModel->get_data();
        $data['feeds']       = $this->feed_model->list_feeds();

        view('feed', $data);
    }
}
