<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Gallery extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== 1 && $grup !== 2 && $grup !== 3 && $grup !== 4) {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_gallery_model');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('gallery');
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->web_gallery_model->paging($p, $o);
        $data['main']    = $this->web_gallery_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->web_gallery_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 3;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('gallery/table', $data);
        $this->load->view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['gallery']     = $this->web_gallery_model->get_gallery($id);
            $data['form_action'] = site_url("gallery/update/{$id}/{$p}/{$o}");
        } else {
            $data['gallery']     = null;
            $data['form_action'] = site_url('gallery/insert');
        }

        $header = $this->header_model->get_data();

        $nav['act'] = 3;
        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('gallery/form', $data);
        $this->load->view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('gallery');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('gallery');
    }

    public function insert()
    {
        $this->web_gallery_model->insert();
        redirect('gallery');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_gallery_model->update($id);
        redirect("gallery/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_gallery_model->delete($id);
        redirect("gallery/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_gallery_model->delete_all();
        redirect("gallery/index/{$p}/{$o}");
    }

    public function gallery_lock($id = '')
    {
        $this->web_gallery_model->gallery_lock($id, 1);
        redirect("gallery/index/{$p}/{$o}");
    }

    public function gallery_unlock($id = '')
    {
        $this->web_gallery_model->gallery_lock($id, 2);
        redirect("gallery/index/{$p}/{$o}");
    }

    public function sub_gallery($gal = 0, $p = 1)
    {
        $data['p'] = 1;
        $data['o'] = 0;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging'] = $this->web_gallery_model->paging2($gal, $p);

        $data['sub_gallery'] = $this->web_gallery_model->list_sub_gallery($gal, $data['paging']->offset, $data['paging']->per_page);
        $data['gallery']     = $gal;
        $data['sub']         = $this->web_gallery_model->get_gallery($gal);
        $header              = $this->header_model->get_data();
        $nav['act']          = 3;

        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('gallery/sub_gallery_table', $data);
        $this->load->view('footer');
    }

    public function form_sub_gallery($gallery = 0, $id = 0)
    {
        if ($id) {
            $data['gallery']     = $this->web_gallery_model->get_gallery($id);
            $data['form_action'] = site_url("gallery/update_sub_gallery/{$gallery}/{$id}");
        } else {
            $data['gallery']     = null;
            $data['form_action'] = site_url("gallery/insert_sub_gallery/{$gallery}");
        }
        $data['album'] = $gallery;

        $header = $this->header_model->get_data();

        $nav['act'] = 3;
        $this->load->view('header', $header);
        $this->load->view('web/nav', $nav);
        $this->load->view('gallery/form_sub_gallery', $data);
        $this->load->view('footer');
    }

    public function insert_sub_gallery($gallery = '')
    {
        $this->web_gallery_model->insert_sub_gallery($gallery);
        redirect("gallery/sub_gallery/{$gallery}");
    }

    public function update_sub_gallery($gallery = '', $id = '')
    {
        $this->web_gallery_model->update_sub_gallery($id);
        redirect("gallery/sub_gallery/{$gallery}");
    }

    public function delete_sub_gallery($gallery = '', $id = '')
    {
        $this->web_gallery_model->delete($id);
        redirect("gallery/sub_gallery/{$gallery}");
    }

    public function delete_all_sub_gallery($gallery = '')
    {
        $this->web_gallery_model->delete_all_sub_gallery();
        redirect("gallery/sub_gallery/{$gallery}");
    }

    public function gallery_lock_sub_gallery($gallery = '', $id = '')
    {
        $this->web_gallery_model->gallery_lock($id, 1);
        redirect("gallery/sub_gallery/{$gallery}");
    }

    public function gallery_unlock_sub_gallery($gallery = '', $id = '')
    {
        $this->web_gallery_model->gallery_lock($id, 2);
        redirect("gallery/sub_gallery/{$gallery}");
    }
}
