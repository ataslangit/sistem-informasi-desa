<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_Rentan extends CI_Controller{

function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('user_model');
		$this->load->model('laporan_bulanan_model');
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1 AND $grup!=2 AND $grup!=3) redirect('siteman');
		$this->load->model('header_model');
		
		//Initialize Session ------------
		$_SESSION['success']  = 0;
		$_SESSION['per_page'] = 20;
		$_SESSION['cari']  = '';
		//-------------------------------
		
		$this->load->model('header_model');
	}
	

	function clear(){
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		unset($_SESSION['dusun']);
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		redirect('laporan_rentan');
	}
	
	function index(){
	
		if(isset($_SESSION['dusun']))
			$data['dusun'] = $_SESSION['dusun'];
		else $data['dusun'] = '';	
		
		$data['list_dusun'] = $this->laporan_bulanan_model->list_dusun();
		$data['config'] = $this->laporan_bulanan_model->configku();
		//$data['paging']  = $this->laporan_bulanan_model->paging($lap,$p,$o);
		$data['main']    = $this->laporan_bulanan_model->list_data();
		//$data['keyword'] = $this->laporan_bulanan_model->autocomplete();
		$nav['act']= 2;
		$header = $this->header_model->get_data();
		$this->load->view('header',$header);
		$this->load->view('statistik/nav',$nav);
		$this->load->view('laporan/kelompok',$data);
		$this->load->view('footer');
	}
		
	function cetak(){
		$data['config'] = $this->laporan_bulanan_model->configku();
		$data['main']    = $this->laporan_bulanan_model->list_data();
		$this->load->view('laporan/kelompok_print',$data);
	}

	function excel(){
		$data['config'] = $this->laporan_bulanan_model->configku();
		$data['main']    = $this->laporan_bulanan_model->list_data();
		$this->load->view('laporan/kelompok_excel',$data);
	}
		
	function dusun(){
		$dusun = $this->input->post('dusun');
		if($dusun!="")
			$_SESSION['dusun']=$dusun;
		else unset($_SESSION['dusun']);
		redirect('laporan_rentan');
	}
}
