<?php

class Main extends CI_Controller
{
    public function index()
    {
        if (isset($_SESSION['siteman'])) {
            $this->load->model('user_model');
            $grup = $this->user_model->sesi_grup($_SESSION['sesi']);

            switch ($grup) {
                case '1':
                case '2':
                    redirect('hom_desa');
                    break;

                case '3':
                case '4':
                    redirect('web');
                    break;

                default:
                    if (isset($_SESSION['siteman'])) {
                        redirect('siteman');
                    } else {
                        redirect('first');
                    }
                    break;
            }
        } else {
            redirect('first');
        }
    }
}
