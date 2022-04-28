<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class menu extends CI_Controller{

	function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('user_model');
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1 AND $grup!=2 AND $grup!=3) redirect('siteman');
		$this->load->model('header_model');
		$this->load->model('web_menu_model');
	
	}
	
	function clear(){
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		redirect('menu');
	}
	
	function index($tip=1,$p=1,$o=0){
	
		$data['p']        = $p;
		$data['o']        = $o;
		$data['tip']        = $tip;
		
		if(isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';
		
		if(isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';
	
		if(isset($_POST['per_page'])) 
			$_SESSION['per_page']=$_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];
		
		$data['paging']  = $this->web_menu_model->paging($tip,$p,$o);
		$data['main']    = $this->web_menu_model->list_data($tip,$o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->web_menu_model->autocomplete();

		$header = $this->header_model->get_data();
		$nav['act']=1;
		
		$this->load->view('header', $header);
		$this->load->view('web/nav',$nav);
		$this->load->view('menu/table',$data);
		$this->load->view('footer');
	}
	
	function form($tip=1,$id=''){
	
		if($tip==1){
			$data['link']        = $this->web_menu_model->list_link();
		}else{
			$data['link']        = $this->web_menu_model->list_kategori();
		}
		if($id){
			$data['menu']        = $this->web_menu_model->get_menu($id);
			$data['form_action'] = site_url("menu/update/$tip/$id");
		}
		else{
			$data['menu']        = null;
			$data['form_action'] = site_url("menu/insert/$tip");
		}

		$header = $this->header_model->get_data();
		$data['tip'] = $tip; 
		
		$nav['act']=1;
		$this->load->view('header', $header);
		$this->load->view('web/nav',$nav);
		$this->load->view('menu/form',$data);
		$this->load->view('footer');
	}

	function sub_menu($tip=1,$menu=1){
	
		$data['submenu']    = $this->web_menu_model->list_sub_menu($menu);
		$data['tip'] = $tip; 
		$data['menu'] = $menu; 
		$header = $this->header_model->get_data();
		$nav['act']=1;
		
		$this->load->view('header', $header);
		$this->load->view('web/nav',$nav);
		$this->load->view('menu/sub_menu_table',$data);
		$this->load->view('footer');
	}
	
	function ajax_add_sub_menu($tip=1,$menu='',$id=''){
	
		$data['menu'] = $menu;
		$data['tip'] = $tip;
		
		$data['link']        = $this->web_menu_model->list_link();
		
		if($id){
			$data['submenu']        = $this->web_menu_model->get_menu($id);
			$data['form_action'] = site_url("menu/update_sub_menu/$tip/$menu/$id");
		}
		else{
			$data['submenu']        = null;
			$data['form_action'] = site_url("menu/insert_sub_menu/$tip/$menu");
		}

		$this->load->view('menu/ajax_add_sub_menu_form',$data);
	}

	function search($tip=1){
		$cari = $this->input->post('cari');
		if($cari!='')
			$_SESSION['cari']=$cari;
		else unset($_SESSION['cari']);
		redirect("menu/index/$tip");
	}
	
	function filter(){
		$filter = $this->input->post('filter');
		if($filter!=0)
			$_SESSION['filter']=$filter;
		else unset($_SESSION['filter']);
		redirect('menu');
	}
	
	function insert($tip=1){
		$this->web_menu_model->insert($tip);
		redirect("menu/index/$tip");
	}
	
	function update($tip=1,$id=''){
		$this->web_menu_model->update($id);
		redirect("menu/index/$tip");
	}
	
	function delete($tip=1,$id=''){
		$this->web_menu_model->delete($id);
		redirect("menu/index/$tip");
	}
	
	function delete_all($tip=1,$p=1,$o=0){
		$this->web_menu_model->delete_all();
		redirect("menu/index/$tip/$p/$o");
	}
	
	function menu_lock($tip=1,$id=''){
		$this->web_menu_model->menu_lock($id,1);
		redirect("menu/index/$tip/$p/$o");
	}

	function menu_unlock($tip=1,$id=''){
		$this->web_menu_model->menu_lock($id,2);
		redirect("menu/index/$tip/$p/$o");
	}	
	
	function insert_sub_menu($tip=1,$menu=''){
		$this->web_menu_model->insert_sub_menu($menu);
		redirect("menu/sub_menu/$tip/$menu");
	}
	
	function update_sub_menu($tip=1,$menu='',$id=''){
		$this->web_menu_model->update_sub_menu($id);
		redirect("menu/sub_menu/$tip/$menu");
	}
	
	function delete_sub_menu($tip='',$menu='',$id=0){
		$this->web_menu_model->delete($id);
		redirect("menu/sub_menu/$tip/$menu");
	}
	
	function delete_all_sub_menu($tip=1,$menu=''){
		$this->web_menu_model->delete_all();
		redirect("menu/sub_menu/$tip/$menu");
	}
	
	function menu_lock_sub_menu($tip=1,$menu='',$id=''){
		$this->web_menu_model->menu_lock($id,1);
		redirect("menu/sub_menu/$tip/$menu");
	}

	function menu_unlock_sub_menu($tip=1,$menu='',$id=''){
		$this->web_menu_model->menu_lock($id,2);
		redirect("menu/sub_menu/$tip/$menu");
	}
}
