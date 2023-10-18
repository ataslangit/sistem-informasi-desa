<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller;

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }
        $this->load->model('header_model');
        $this->load->model('web_menu_model');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        redirect('menu');
    }

    public function index($tip = 1, $p = 1, $o = 0)
    {
        $data['p']   = $p;
        $data['o']   = $o;
        $data['tip'] = $tip;

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

        $data['paging']  = $this->web_menu_model->paging($tip, $p, $o);
        $data['main']    = $this->web_menu_model->list_data($tip, $o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->web_menu_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 1;

        view('header', $header);
        view('web/nav', $nav);
        view('menu/table', $data);
        view('footer');
    }

    public function form($tip = 1, $id = '')
    {
        if ($tip === 1) {
            $data['link'] = $this->web_menu_model->list_link();
        } else {
            $data['link'] = $this->web_menu_model->list_kategori();
        }
        if ($id) {
            $data['menu']        = $this->web_menu_model->get_menu($id);
            $data['form_action'] = site_url("menu/update/{$tip}/{$id}");
        } else {
            $data['menu']        = null;
            $data['form_action'] = site_url("menu/insert/{$tip}");
        }
        $header      = $this->header_model->get_data();
        $data['tip'] = $tip;

        $nav['act'] = 1;
        view('header', $header);
        view('web/nav', $nav);
        view('menu/form', $data);
        view('footer');
    }

    public function sub_menu($tip = 1, $menu = 1)
    {
        $data['submenu'] = $this->web_menu_model->list_sub_menu($menu);
        $data['tip']     = $tip;
        $data['menu']    = $menu;
        $header          = $this->header_model->get_data();
        $nav['act']      = 1;

        view('header', $header);
        view('web/nav', $nav);
        view('menu/sub_menu_table', $data);
        view('footer');
    }

    public function ajax_add_sub_menu($tip = 1, $menu = '', $id = '')
    {
        $data['menu'] = $menu;
        $data['tip']  = $tip;

        $data['link'] = $this->web_menu_model->list_link();

        if ($id) {
            $data['submenu']     = $this->web_menu_model->get_menu($id);
            $data['form_action'] = site_url("menu/update_sub_menu/{$tip}/{$menu}/{$id}");
        } else {
            $data['submenu']     = null;
            $data['form_action'] = site_url("menu/insert_sub_menu/{$tip}/{$menu}");
        }
        view('menu/ajax_add_sub_menu_form', $data);
    }

    public function search($tip = 1)
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect("menu/index/{$tip}");
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('menu');
    }

    public function insert($tip = 1)
    {
        $this->web_menu_model->insert($tip);
        redirect("menu/index/{$tip}");
    }

    public function update($tip = 1, $id = '')
    {
        $this->web_menu_model->update($id);
        redirect("menu/index/{$tip}");
    }

    public function delete($tip = 1, $id = '')
    {
        $this->web_menu_model->delete($id);
        redirect("menu/index/{$tip}");
    }

    public function delete_all($tip = 1, $p = 1, $o = 0)
    {
        $this->web_menu_model->delete_all();
        redirect("menu/index/{$tip}/{$p}/{$o}");
    }

    public function menu_lock($tip = 1, $id = '')
    {
        $this->web_menu_model->menu_lock($id, 1);
        redirect("menu/index/{$tip}/{$p}/{$o}");
    }

    public function menu_unlock($tip = 1, $id = '')
    {
        $this->web_menu_model->menu_lock($id, 2);
        redirect("menu/index/{$tip}/{$p}/{$o}");
    }

    public function insert_sub_menu($tip = 1, $menu = '')
    {
        $this->web_menu_model->insert_sub_menu($menu);
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }

    public function update_sub_menu($tip = 1, $menu = '', $id = '')
    {
        $this->web_menu_model->update_sub_menu($id);
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }

    public function delete_sub_menu($tip = '', $menu = '', $id = 0)
    {
        $this->web_menu_model->delete($id);
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }

    public function delete_all_sub_menu($tip = 1, $menu = '')
    {
        $this->web_menu_model->delete_all();
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }

    public function menu_lock_sub_menu($tip = 1, $menu = '', $id = '')
    {
        $this->web_menu_model->menu_lock($id, 1);
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }

    public function menu_unlock_sub_menu($tip = 1, $menu = '', $id = '')
    {
        $this->web_menu_model->menu_lock($id, 2);
        redirect("menu/sub_menu/{$tip}/{$menu}");
    }
}
