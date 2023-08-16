<?php

use App\Controllers\BaseController;

class Widget extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }
    }

    public function index()
    {
        $data['main']        = $this->web_widget_model->get_widget();
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("web/widget/update/1/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 5;

        view('header', $header);
        view('web/nav', $nav);
        view('web/widget/facebook', $data);
        view('footer');
    }

    public function twitter()
    {
        $data['main']        = $this->web_widget_model->get_widget();
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("web/widget/update/2/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 5;

        view('header', $header);
        view('web/nav', $nav);
        view('web/widget/twitter', $data);
        view('footer');
    }

    public function update($tipe = '', $id = '')
    {
        $this->web_widget_model->update($id);
        if ($tipe === '1') {
            redirect('web/widget');
        } else {
            redirect('web/widget/twitter');
        }
    }
}
