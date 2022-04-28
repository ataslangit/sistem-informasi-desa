<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Apis extends CI_Model
{
    public function view($page = 'indeks')
    {
        if (! file_exists(APPPATH . '/views/apis/' . $page . '.php')) {
            echo $page;
        }
    }
}
