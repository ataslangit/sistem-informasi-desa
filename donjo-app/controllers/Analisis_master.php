<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class analisis_master extends CI_Controller{

	function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('analisis_master_model');
		$this->load->model('analisis_import_model');
		$this->load->model('user_model');
		$this->load->model('header_model');
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1) redirect('siteman');
	}
	
	function clear(){
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		unset($_SESSION['state']);
		redirect('analisis_master');
	}
	
	function index($p=1,$o=0){
	    unset($_SESSION['analisis_master']);
		$data['p']        = $p;
		$data['o']        = $o;
		
		if(isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';
		
		if(isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';
	
		if(isset($_SESSION['state']))
			$data['state'] = $_SESSION['state'];
		else $data['state'] = '';
	
		if(isset($_POST['per_page'])) 
			$_SESSION['per_page']=$_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];
		
		$data['paging']  = $this->analisis_master_model->paging($p,$o);
		$data['main']    = $this->analisis_master_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->analisis_master_model->autocomplete();
		$data['list_subjek'] = $this->analisis_master_model->list_subjek();

		$header = $this->header_model->get_data();
		
		$this->load->view('header', $header);
		$this->load->view('analisis_master/nav');
		$this->load->view('analisis_master/table',$data);
		$this->load->view('footer');
	}
	
	function form($p=1,$o=0,$id=''){
	
		$data['p'] = $p;
		$data['o'] = $o;
		
		if($id){
			$data['analisis_master']        = $this->analisis_master_model->get_analisis_master($id);
			$data['form_action'] = site_url("analisis_master/update/$p/$o/$id");
		}
		
		else{
			$data['analisis_master']        = null;
			$data['form_action'] = site_url("analisis_master/insert");
		}
		
		$data['list_kelompok'] = $this->analisis_master_model->list_kelompok();
		$header = $this->header_model->get_data();
		
		$this->load->view('header', $header);
		$this->load->view('analisis_master/nav');
		$this->load->view('analisis_master/form',$data);
		$this->load->view('footer');
	}
	
	function panduan(){
	
		$header = $this->header_model->get_data();
		
		$this->load->view('header', $header);
		$this->load->view('analisis_master/nav');
		$this->load->view('analisis_master/panduan');
		$this->load->view('footer');
	}
	
	function import_analisis(){
	
		$header = $this->header_model->get_data();
		
		$data['form_action'] = site_url("analisis_master/import");
		$this->load->view('header', $header);
		$this->load->view('analisis_master/nav');
		$this->load->view('analisis_master/import', $data);
		$this->load->view('footer');
	}
	
	function menu($id=''){
	$_SESSION['analisis_master']=$id;
		$data['analisis_master']        = $this->analisis_master_model->get_analisis_master($id);
		$da = $data['analisis_master'];
		$subjek = $da['subjek_tipe'];
		
			switch($subjek){
				case 1: $data['menu_respon'] = "analisis_respon_penduduk"; $data['menu_laporan'] = "analisis_laporan_penduduk"; break;
				case 2: $data['menu_respon'] = "analisis_respon_keluarga"; $data['menu_laporan'] = "analisis_laporan_keluarga";break;
				case 3: $data['menu_respon'] = "analisis_respon_rtm"; $data['menu_laporan'] = "analisis_laporan_rtm";break;
				case 4: $data['menu_respon'] = "analisis_respon_kelompok"; $data['menu_laporan'] = "analisis_laporan_kelompok";break;
				default:redirect('analisis_master');
			}
		
		$header = $this->header_model->get_data();
		
		$this->load->view('header', $header);
		$this->load->view('analisis_master/nav');
		$this->load->view('analisis_master/menu',$data);
		$this->load->view('footer');
	}

	function search(){
		$cari = $this->input->post('cari');
		if($cari!='')
			$_SESSION['cari']=$cari;
		else unset($_SESSION['cari']);
		redirect('analisis_master');
	}
	
	function filter(){
		$filter = $this->input->post('filter');
		if($filter!=0)
			$_SESSION['filter']=$filter;
		else unset($_SESSION['filter']);
		redirect('analisis_master');
	}
	
	function state(){
		$filter = $this->input->post('state');
		if($filter!=0)
			$_SESSION['state']=$filter;
		else unset($_SESSION['state']);
		redirect('analisis_master');
	}
	
	function insert(){
		$this->analisis_master_model->insert();
		redirect('analisis_master');
	}
	
	function import(){
		$this->analisis_import_model->import_excel();
		//redirect('analisis_master/import_analisis');
	}
	
	function update($p=1,$o=0,$id=''){
		$this->analisis_master_model->update($id);
		redirect("analisis_master/index/$p/$o");
	}
	
	function delete($p=1,$o=0,$id=''){
		$this->analisis_master_model->delete($id);
		redirect("analisis_master/index/$p/$o");
	}
	
	function delete_all($p=1,$o=0){
		$this->analisis_master_model->delete_all();
		redirect("analisis_master/index/$p/$o");
	}
	
}
