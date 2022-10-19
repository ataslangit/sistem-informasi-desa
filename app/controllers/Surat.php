<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Surat extends CI_Controller{
	function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('user_model');
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1 AND $grup!=2 AND $grup!=3) redirect('siteman');
		$this->load->model('header_model');
		$this->load->model('penduduk_model');
		$this->load->model('surat_model');
		$this->load->model('surat_keluar_model');
	}
	function index(){
		unset($_SESSION['nik']);
		unset($_SESSION['nik_ayah']);
		unset($_SESSION['nik_ibu']);
		$header = $this->header_model->get_data();
		$data['menu_surat'] = $this->surat_model->list_surat();
		$data['menu_surat2'] = $this->surat_model->list_surat2();
		$data['surat_favorit'] = $this->surat_model->list_surat_fav();
		
		$this->load->view('header', $header);
		$nav['act']= 1;
		
		$this->load->view('surat/nav',$nav);
		$this->load->view('surat/format_surat',$data);
		$this->load->view('footer');
	}
	function panduan(){
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$nav['act']= 4;
		
		$this->load->view('surat/nav',$nav);
		$this->load->view('surat/panduan');
		$this->load->view('footer');
	}
	function form($url=''){
		$data['url']=$url;
		if(isset($_POST['nik']))
			$_SESSION['nik'] = $_POST['nik'];
		
		if(isset($_POST['nik_ayah']))
			$_SESSION['nik_ayah'] = $_POST['nik_ayah'];
		
		if(isset($_POST['nik_ibu']))
			$_SESSION['nik_ibu'] = $_POST['nik_ibu'];
		
		if(isset($_SESSION['nik'])){
			$data['individu']=$this->surat_model->get_penduduk($_SESSION['nik']);
			$data['ayah']=$this->surat_model->get_penduduk($_SESSION['nik_ayah']);
			$data['ibu']=$this->surat_model->get_penduduk($_SESSION['nik_ibu']);
			$data['anggota']=$this->surat_model->list_anggota($data['individu']['id_kk'],$data['individu']['nik']);
			$data['list_dokumen'] = $this->penduduk_model->list_dokumen($_SESSION['nik']);
		}else{
			$data['individu']=NULL;
			$data['ayah']=NULL;
			$data['ibu']=NULL;
			$data['anggota']=NULL;
			$data['list_dokumen'] = null;
		}
		$data['penduduk'] = $this->surat_model->list_penduduk();
		$data['pamong'] = $this->surat_model->list_pamong();
		
		$data['form_action'] = site_url("surat/cetak/$url");
		$data['form_action2'] = site_url("surat/doc/$url");
		$nav['act']= 1;
		$header = $this->header_model->get_data();
		$this->load->view('header',$header);
		
		$this->load->view('surat/nav',$nav);
		$this->load->view("surat/form/$url",$data);
		$this->load->view('footer');
	}
		
	function cetak($url=''){
		
		$f=$url;
		$g=$_POST['pamong'];
		$u=$_SESSION['user'];
		$z=$_POST['nomor'];
		
		
		$id = $_POST['nik'];
		$data['input'] = $_POST;
		$data['tanggal_sekarang'] = tgl_indo(date("Y m d"));
		
		$data['data'] = $this->surat_model->get_data_surat($id);
		$data['ayah'] = $this->surat_model->get_data_suami($id);
		
		$data['pribadi'] = $this->surat_model->get_data_pribadi($id);
		$data['kk'] = $this->surat_model->get_data_kk($id);
		
		$data['desa'] = $this->surat_model->get_data_desa();
		$data['pamong'] = $this->surat_model->get_pamong($_POST['pamong']);
			
		$data['pengikut']=$this->surat_model->pengikut();
		$this->surat_keluar_model->log_surat($f,$id,$g,$u,$z);
		$this->load->view("surat/print/print_".$url."",$data);
	}
	function doc($url=''){
		
		$format = $this->surat_model->get_surat($url);
		$f = $format['id'];
		$g=$_POST['pamong'];
		$u=$_SESSION['user'];
		$z=$_POST['nomor'];
		
		$id = $_POST['nik'];
		$this->surat_keluar_model->log_surat($f,$id,$g,$u,$z);
		
		$this->surat_model->coba($url);
	}	
	function search(){
		$cari = $this->input->post('nik');
		if($cari!='')
			redirect("surat/form/$cari");
		else
			redirect('surat');
	}
}