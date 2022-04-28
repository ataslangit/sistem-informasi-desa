<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Penduduk extends CI_Controller{

	function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('user_model');
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1 AND $grup!=2) redirect('siteman');
		
		$this->load->model('penduduk_model');
		$this->load->model('header_model');
		
	}
	
	function clear(){
		unset($_SESSION['log']);
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		unset($_SESSION['sex']);
		unset($_SESSION['warganegara']);
		unset($_SESSION['cacat']);
		unset($_SESSION['menahun']);
		unset($_SESSION['cacatx']);
		unset($_SESSION['menahunx']);		
		unset($_SESSION['golongan_darah']);
		unset($_SESSION['dusun']);
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		unset($_SESSION['agama']);
		unset($_SESSION['umur_min']);
		unset($_SESSION['umur_max']);
		unset($_SESSION['pekerjaan_id']);
		unset($_SESSION['status']);
		unset($_SESSION['pendidikan_id']);
		unset($_SESSION['pendidikan_sedang_id']);
		unset($_SESSION['pendidikan_kk_id']);
		unset($_SESSION['umurx']);
		unset($_SESSION['status_penduduk']);
		unset($_SESSION['judul_statistik']);
		unset($_SESSION['hamil']);
		$_SESSION['per_page'] = 50;
		redirect('penduduk');
	}
	
	function index($p=1,$o=0){
		
		unset($_SESSION['log']);
	
		$data['p']        = $p;
		$data['o']        = $o;
		
		if(isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';
		
		if(isset($_SESSION['judul_statistik']))
			$data['judul_statistik'] = $_SESSION['judul_statistik'];
		else $data['judul_statistik'] = '';
		
		if(isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';
	
		if(isset($_SESSION['sex']))
			$data['sex'] = $_SESSION['sex'];
		else $data['sex'] = '';
		
		if(isset($_SESSION['dusun'])){
			$data['dusun'] = $_SESSION['dusun'];
			$data['list_rw'] = $this->penduduk_model->list_rw($data['dusun']);
			
		if(isset($_SESSION['rw'])){
			$data['rw'] = $_SESSION['rw'];
			$data['list_rt'] = $this->penduduk_model->list_rt($data['dusun'],$data['rw']);
						
		if(isset($_SESSION['rt']))
			$data['rt'] = $_SESSION['rt'];
			else $data['rt'] = '';
				
			}else $data['rw'] = '';
			
		}else{
			$data['dusun'] = '';
			$data['rw'] = '';
			$data['rt'] = '';
		}
		
		if(isset($_SESSION['agama']))
			$data['agama'] = $_SESSION['agama'];
		else $data['agama'] = '';

                if(isset($_SESSION['cacat']))
			$data['cacat'] = $_SESSION['cacat'];
		else $data['cacat'] = '';
		
		if(isset($_SESSION['pekerjaan_id']))
			$data['pekerjaan_id'] = $_SESSION['pekerjaan_id'];
		else $data['pekerjaan_id'] = '';

		if(isset($_SESSION['status']))
			$data['status'] = $_SESSION['status'];
		else $data['status'] = '';

		if(isset($_SESSION['pendidikan_sedang_id']))
			$data['pendidikan_sedang_id'] = $_SESSION['pendidikan_sedang_id'];
		else $data['pendidikan_sedang_id'] = '';

		if(isset($_SESSION['pendidikan_kk_id']))
			$data['pendidikan_kk_id'] = $_SESSION['pendidikan_kk_id'];
		else $data['pendidikan_kk_id'] = '';

		if(isset($_SESSION['status_penduduk']))
			$data['status_penduduk'] = $_SESSION['status_penduduk'];
		else $data['status_penduduk'] = '';

		if(isset($_POST['per_page'])) 
			$_SESSION['per_page']=$_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];
		
		$data['grup']	= $this->user_model->sesi_grup($_SESSION['sesi']);
		$data['paging']  = $this->penduduk_model->paging($p,$o);
		$data['main']    = $this->penduduk_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->penduduk_model->autocomplete();
		$data['list_agama'] = $this->penduduk_model->list_agama();
		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		
		$header = $this->header_model->get_data();
		$nav['act']= 2;
		
		$this->load->view('header', $header);

		$this->load->view('sid/nav',$nav);
		$this->load->view('sid/kependudukan/penduduk',$data);
		$this->load->view('footer');
		//unset($_SESSION['judul_statistik']);
	}
	
	function form($p=1,$o=0,$id=''){
	
		$data['p'] = $p;
		$data['o'] = $o;
		
		if(isset($_POST['dusun']))
			$data['dus_sel'] = $_POST['dusun'];
		else
			$data['dus_sel'] = '';
			
		if(isset($_POST['rw']))
			$data['rw_sel'] = $_POST['rw'];
		else
			$data['rw_sel'] = '';
			
		if(isset($_POST['rt']))
			$data['rt_sel'] = $_POST['rt'];
		else
			$data['rt_sel'] = '';
			
		if($id){
			$data['penduduk']        = $this->penduduk_model->get_penduduk($id);
			$data['form_action'] = site_url("penduduk/update/$p/$o/$id");
		}
		else{
			$data['penduduk']        = null;
			$data['form_action'] = site_url("penduduk/insert");
		}
		
		$header = $this->header_model->get_data();
		$data['dusun'] = $this->penduduk_model->list_dusun();
		$data['rw']    = $this->penduduk_model->list_rw($data['dus_sel']);
		$data['rt']    = $this->penduduk_model->list_rt($data['dus_sel'],$data['rw_sel']);
		$data['agama'] = $this->penduduk_model->list_agama();
		$data['pendidikan_sedang'] = $this->penduduk_model->list_pendidikan_sedang();
		$data['pendidikan_kk'] = $this->penduduk_model->list_pendidikan_kk();
		$data['pekerjaan'] = $this->penduduk_model->list_pekerjaan();
		$data['warganegara'] = $this->penduduk_model->list_warganegara();
		$data['hubungan'] = $this->penduduk_model->list_hubungan();
		$data['kawin'] = $this->penduduk_model->list_status_kawin();
		$data['golongan_darah'] = $this->penduduk_model->list_golongan_darah();
		$data['cacat'] = $this->penduduk_model->list_cacat();
		
		$this->load->view('header', $header);
		$nav['act']= 2;

		$this->load->view('sid/nav',$nav);
		$this->load->view('sid/kependudukan/penduduk_form',$data);
		$this->load->view('footer');
	}

        function detail($p=1,$o=0,$id=''){
	
		$data['p'] = $p;
		$data['o'] = $o;
		$data['penduduk'] = $this->penduduk_model->get_penduduk($id);
		$header = $this->header_model->get_data();
		
		$this->load->view('header', $header);
		$nav['act']= 2;

		$this->load->view('sid/nav',$nav);
		$this->load->view('sid/kependudukan/penduduk_detail',$data);
		$this->load->view('footer');
	}

        function cetak_biodata($id=''){
		
		$data['desa'] = $this->header_model->get_data();
		$data['penduduk'] = $this->penduduk_model->get_penduduk($id);
		$this->load->view('sid/kependudukan/cetak_biodata',$data);
	}

	function search(){
		$cari = $this->input->post('cari');
		if($cari!='')
			$_SESSION['cari']=$cari;
		else unset($_SESSION['cari']);
		redirect('penduduk');
	}
	
	function filter(){
		$filter = $this->input->post('filter');
		if($filter!="")
			$_SESSION['filter']=$filter;
		else unset($_SESSION['filter']);
		redirect('penduduk');
	}
	
	function sex(){
		$sex = $this->input->post('sex');
		if($sex!="")
			$_SESSION['sex']=$sex;
		else unset($_SESSION['sex']);
		redirect('penduduk');
	}
	
	function agama(){
		$agama = $this->input->post('agama');
		if($agama!="")
			$_SESSION['agama']=$agama;
		else unset($_SESSION['agama']);
		redirect('penduduk');
	}
	
	function warganegara(){
		$warganegara = $this->input->post('warganegara');
		if($warganegara!="")
			$_SESSION['warganegara']=$warganegara;
		else unset($_SESSION['warganegara']);
		redirect('penduduk');
	}
	
	function dusun(){
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		$dusun = $this->input->post('dusun');
		if($dusun!="")
			$_SESSION['dusun']=$dusun;
		else unset($_SESSION['dusun']);
		redirect('penduduk');
	}
	
	function rw(){
		unset($_SESSION['rt']);
		$rw = $this->input->post('rw');
		if($rw!="")
			$_SESSION['rw']=$rw;
		else unset($_SESSION['rw']);
		redirect('penduduk');
	}
	
	function rt(){
		$rt = $this->input->post('rt');
		if($rt!="")
			$_SESSION['rt']=$rt;
		else unset($_SESSION['rt']);
		redirect('penduduk');
	}
	
	function insert(){
		$this->penduduk_model->insert();
		redirect('penduduk');
	}
	
	function update($p=1,$o=0,$id=''){
		$this->penduduk_model->update($id);
		redirect("penduduk/index/$p/$o");
	}
	
		
	function delete_confirm($p=1,$o=0,$id=''){
		$data['form_action'] = site_url("penduduk/index/$p/$o/$id");
		$this->load->view("sid/kependudukan/ajax_delete", $data);
	}
	
	function delete($p=1,$o=0,$id=''){
		//$pass = $_POST['pass'];
		//if($pass == "yakin")
		
			$this->penduduk_model->delete($id);
		//else
			//$_SESSION['success'] = -1;
		
		redirect("penduduk/index/$p/$o");
	}
	
	function delete_all($p=1,$o=0){
		$this->penduduk_model->delete_all();
		redirect("penduduk/index/$p/$o");
	}
	
	function ajax_adv_search(){
	
	
		if(isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';
		
		if(isset($_SESSION['judul_statistik']))
			$data['judul_statistik'] = $_SESSION['judul_statistik'];
		else $data['judul_statistik'] = '';
		
		if(isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';
	
		if(isset($_SESSION['sex']))
			$data['sex'] = $_SESSION['sex'];
		else $data['sex'] = '';
		
		if(isset($_SESSION['umur_min']))
			$data['umur_min'] = $_SESSION['umur_min'];
		else $data['umur_min'] = '';
		
		if(isset($_SESSION['umur_max']))
			$data['umur_max'] = $_SESSION['umur_max'];
		else $data['umur_max'] = '';
		
		if(isset($_SESSION['agama']))
			$data['agama'] = $_SESSION['agama'];
		else $data['agama'] = '';

		if(isset($_SESSION['tahun']))
			$data['tahun'] = $_SESSION['tahun'];
		else $data['tahun'] = date("Y");

        if(isset($_SESSION['cacat']))
			$data['cacat'] = $_SESSION['cacat'];
		else $data['cacat'] = '';
		
		if(isset($_SESSION['pekerjaan_id']))
			$data['pekerjaan_id'] = $_SESSION['pekerjaan_id'];
		else $data['pekerjaan_id'] = '';

		if(isset($_SESSION['status']))
			$data['status'] = $_SESSION['status'];
		else $data['status'] = '';

		if(isset($_SESSION['pendidikan_sedang_id']))
			$data['pendidikan_sedang_id'] = $_SESSION['pendidikan_sedang_id'];
		else $data['pendidikan_sedang_id'] = '';

		if(isset($_SESSION['pendidikan_kk_id']))
			$data['pendidikan_kk_id'] = $_SESSION['pendidikan_kk_id'];
		else $data['pendidikan_kk_id'] = '';

		if(isset($_SESSION['status_penduduk']))
			$data['status_penduduk'] = $_SESSION['status_penduduk'];
		else $data['status_penduduk'] = '';
		
		$data['list_agama'] = $this->penduduk_model->list_agama();
		$data['pendidikan'] = $this->penduduk_model->list_pendidikan();
		$data['pendidikan_kk'] = $this->penduduk_model->list_pendidikan_kk();
		$data['pekerjaan'] = $this->penduduk_model->list_pekerjaan();
		$data['form_action'] = site_url("penduduk/adv_search_proses");
	
		$this->load->view("sid/kependudukan/ajax_adv_search_form", $data);
	}
	
	function adv_search_proses(){
	
		$adv_search = $_POST;
		$i=0;
		while($i++ < count($adv_search)){
			$col[$i] = key($adv_search);
				next($adv_search);
		}
		$i=0;
		while($i++ < count($col)){
			if($adv_search[$col[$i]]==""){
				UNSET($adv_search[$col[$i]]);
				UNSET($_SESSION[$col[$i]]);
			}else{
				$_SESSION[$col[$i]]=$adv_search[$col[$i]];
			}
		}
		
		redirect('penduduk');
	}
	
	function ajax_penduduk_pindah($id=0){
	
		$data['dusun'] = $this->penduduk_model->list_dusun();
		
		$data['form_action'] = site_url("penduduk/pindah_proses/$id");
		$this->load->view('sid/kependudukan/ajax_pindah_form',$data);
	}
	
	function ajax_penduduk_pindah_rw($dusun=''){
		$rw = $this->penduduk_model->list_rw($dusun);
		
		echo"<td>RW</td>
		<td><select name='rw' onchange=RWSel('".$dusun."',this.value)>
		<option value=''>Pilih RW&nbsp;</option>";
		foreach($rw as $data){
			echo "<option>".$data['rw']."</option>";
		}echo"</select>
		</td>";
	}
	
	function ajax_penduduk_pindah_rt($dusun='',$rw=''){
		$rt = $this->penduduk_model->list_rt($dusun,$rw);

		echo "<td>RT</td>
		<td><select name='id_cluster'>
		<option value=''>Pilih RT&nbsp;</option>";
		foreach($rt as $data){
			echo "<option value=".$data['id'].">".$data['rt']."</option>";
		}echo"</select>
		</td>";
	}
	
	
	function ajax_penduduk_cari_rw($dusun=''){
		$rw = $this->penduduk_model->list_rw($dusun);
		
		echo"<td>RW</td>
		<td><select name='rw' onchange=RWSel('".$dusun."',this.value)>
		<option value=''>Pilih RW&nbsp;</option>";
		foreach($rw as $data){
			echo "<option>".$data['rw']."</option>";
		}echo"</select>
		</td>";
	}
	
	function ajax_penduduk_cari_rt($dusun='',$rw=''){
		$rt = $this->penduduk_model->list_rt($dusun,$rw);

		echo "<td>RT</td>
		<td><select name='rt'>
		<option value=''>Pilih RT&nbsp;</option>";
		foreach($rt as $data){
			echo "<option value=".$data['rt'].">".$data['rt']."</option>";
		}echo"</select>
		</td>";
	}
	
	function pindah_proses($id=0){
		$id_cluster = $_POST['id_cluster'];
		$this->penduduk_model->pindah_proses($id,$id_cluster);
		redirect("penduduk");
	}
	
	function ajax_penduduk_maps($p=1,$o=0,$id=''){

		$data['p'] = $p;
		$data['o'] = $o;
		
		$data['penduduk'] = $this->penduduk_model->get_penduduk_map($id);
		$data['desa'] = $this->penduduk_model->get_desa();
		
		$data['form_action'] = site_url("penduduk/update_maps/$p/$o/$id");
		
		$this->load->view("sid/kependudukan/maps", $data);
	}
			
	function update_maps($p=1,$o=0,$id=''){
		$this->penduduk_model->update_position($id);
		redirect("penduduk/form/$p/$o/$id");
	}
	function wilayah_sel($p=1,$o=0,$id=''){

		$data['p'] = $p;
		$data['o'] = $o;
		
		$data['form_action'] = site_url("penduduk");
		
		$this->load->view("sid/kependudukan/maps", $data);
	}
	
	
	function edit_status_dasar($p=1,$o=0,$id=0){
	$data['nik']          = $this->penduduk_model->get_penduduk($id);
		$data['form_action'] = site_url("penduduk/update_status_dasar/$p/$o/$id");
		$this->load->view('sid/kependudukan/ajax_edit_status_dasar',$data);
	}
			
	function update_status_dasar($p=1,$o=0,$id=''){
		$this->penduduk_model->update_status_dasar($id);
		redirect("penduduk/index/$p/$o");
	}
		
	function cetak($o=0){

		$data['main']    = $this->penduduk_model->list_data($o,0, 10000);

		$this->load->view('sid/kependudukan/penduduk_print',$data);
	}

	function excel($o=0){

		$data['main']    = $this->penduduk_model->list_data($o,0, 10000);

		$this->load->view('sid/kependudukan/penduduk_excel',$data);
	}
		
	function statistik($tipe=0,$nomor=0,$sex=0){
		$_SESSION['per_page'] = 50;
		unset($_SESSION['log']);
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		
		if($sex==0)
			unset($_SESSION['sex']);
		else
			$_SESSION['sex']=$sex;
			
		unset($_SESSION['warganegara']);
		unset($_SESSION['cacat']);
		unset($_SESSION['menahun']);
		unset($_SESSION['golongan_darah']);
		unset($_SESSION['dusun']);
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		unset($_SESSION['agama']);
		unset($_SESSION['umur_min']);
		unset($_SESSION['umur_max']);
		unset($_SESSION['pekerjaan_id']);
		unset($_SESSION['status']);
		unset($_SESSION['pendidikan_sedang_id']);
		unset($_SESSION['pendidikan_kk_id']);
		unset($_SESSION['status_penduduk']);
		unset($_SESSION['umurx']);
		
		switch($tipe){
			case 0: $_SESSION['pendidikan_kk_id'] = $nomor;  $pre="PENDIDIKAN DALAM KK : "; break;	
			case 1: $_SESSION['pekerjaan_id'] = $nomor; $pre="PEKERJAAN : ";  break;
			case 2: $_SESSION['status'] = $nomor; $pre="STATUS PERKAWINAN : ";  break;
			case 3: $_SESSION['agama'] = $nomor; $pre="AGAMA : ";  break;
			case 4: $_SESSION['sex'] = $nomor; $pre="JENIS KELAMIN : ";  break;
			case 5: $_SESSION['warganegara'] = $nomor;  $pre="WARGANEGARA : "; break;
			case 6: $_SESSION['status_penduduk'] = $nomor; $pre="STATUS PENDUDUK : ";  break;
			case 7: $_SESSION['golongan_darah'] = $nomor; $pre="GOLONGAN DARAH : ";  break;
			case 9: $_SESSION['cacat'] = $nomor; $pre="CACAT : ";  break;
			case 10: $_SESSION['menahun'] = $nomor;  $pre="SAKIT MENAHUN : "; break;
			case 11: $_SESSION['jamkesmas'] = $nomor;  $pre="JAMKESMAS : "; break;
			case 13: $_SESSION['umurx'] = $nomor;  $pre="UMUR "; break;						
			case 14: $_SESSION['pendidikan_sedang_id'] = $nomor; $pre="PENDIDIKAN SEDANG DITEMPUH : "; break;
		}
		$judul= $this->penduduk_model->get_judul_statistik($tipe,$nomor);
		if($judul['nama']){
			$_SESSION['judul_statistik']=$pre.$judul['nama'];
		}else{
			unset($_SESSION['judul_statistik']);
		}
		redirect('penduduk');
	}
	
	function lap_statistik($id_cluster=0,$tipe=0,$nomor=0){
		unset($_SESSION['sex']);
		unset($_SESSION['cacatx']);
		unset($_SESSION['menahun']);
		unset($_SESSION['menahunx']);
		unset($_SESSION['dusun']);
		unset($_SESSION['rw']);
		unset($_SESSION['rt']);
		unset($_SESSION['umur_min']);
		unset($_SESSION['umur_max']);
		unset($_SESSION['hamil']);
		unset($_SESSION['status']);
		$cluster= $this->penduduk_model->get_cluster($id_cluster);
		switch($tipe){
			case 1: 
				$_SESSION['sex'] = '1'; 
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="JENIS KELAMIN LAKI-LAKI  ";  
				break;
			case 2: 
				$_SESSION['sex'] = '2'; 
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt'];  
				$pre="JENIS KELAMIN PEREMPUAN ";  
				break;
			case 3: 
				$_SESSION['umur_min'] = '0'; 
				$_SESSION['umur_max'] = '0';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="BERUMUR <1 ";  
				break;
			case 4: 
				$_SESSION['umur_min'] = '1'; 
				$_SESSION['umur_max'] = '5';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt'];  
				$pre="BERUMUR 1-5 ";  
				break;
			case 5: 
				$_SESSION['umur_min'] = '6'; 
				$_SESSION['umur_max'] = '12'; 
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="BERUMUR 6-12 ";   
				break;
			case 6: 
				$_SESSION['umur_min'] = '13'; 
				$_SESSION['umur_max'] = '15';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="BERUMUR 13-16 ";  
				break;
			case 7: 
				$_SESSION['umur_min'] = '16'; 
				$_SESSION['umur_max'] = '18';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="BERUMUR 16-18 ";  
				break;
			case 8: 
				$_SESSION['umur_min'] = '61';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="BERUMUR >60";  
				break;
			case 9: 
				$_SESSION['cacatx'] = '7';   
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="CACAT "; 
				break;
			case 10: 
				$_SESSION['menahunx'] = '14'; 
				$_SESSION['sex']='1' ; 
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="SAKIT MENAHUN LAKI-LAKI "; 
				break;
			case 11:
				$_SESSION['menahunx'] = '14'; 
				$_SESSION['sex']='2';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt']; 
				$pre="SAKIT MENAHUN PEREMPUAN "; 
				break;	
			case 12: 
				$_SESSION['hamil'] = '1';  
				$_SESSION['dusun']=$cluster['dusun']; 
				$_SESSION['rw']=$cluster['rw']; 
				$_SESSION['rt']=$cluster['rt'];  
				$pre="HAMIL "; 
				break;						
		}
		//$judul= $this->penduduk_model->get_judul_lap_statistik($tipe,$nomor);
		if($pre){
			$_SESSION['judul_statistik']=$pre;
		}else{
			unset($_SESSION['judul_statistik']);
		}
		redirect("penduduk");
	}
	
	
	function coba2($id=0){
	
		//$data['desa']     = $this->keluarga_model->get_desa();
		
		//$data['id_kk']    = $id;
		//$data['main']     = $this->keluarga_model->list_anggota($id);
		//$data['kepala_kk']= $this->keluarga_model->get_kepala_kk($id);
		
		$this->penduduk_model->coba2();
	}
		
}
