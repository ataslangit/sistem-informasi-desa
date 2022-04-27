<?php
/*
 * data_persil.php
 * 
 * Copyright 2015 Isnu Suntoro <isnusun@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Data_persil extends CI_Controller{
	function __construct(){
		parent::__construct();
		session_start();
		$this->load->model('user_model');
		
		$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
		if($grup!=1 AND $grup!=2) redirect('siteman');
		$this->load->model('header_model');
		$this->load->model('config_model');
		$this->load->model('data_persil_model');
		$this->load->model('penduduk_model');
	}
	
	function clear(){
		unset($_SESSION['cari']);
		redirect('data_persil');
	}
	
	function index($page=1){
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		
		if(isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';
		
		$data["desa"] = $this->config_model->get_data();
		$data["persil"] = $this->data_persil_model->list_persil('',0,$page);
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		$data['keyword'] = $this->data_persil_model->autocomplete();
		$this->load->view('data_persil/persil',$data);
		$this->load->view('footer');
	}
	
	function import(){
		$data['form_action'] = site_url("data_persil/import_proses");
		$this->load->view('data_persil/import',$data);
	}
	
	function search(){
		$cari = $this->input->post('cari');
		if($cari!='')
			$_SESSION['cari']=$cari;
		else unset($_SESSION['cari']);
		redirect('data_persil');
	}
	
	function detail($id=0){
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);

		$data["persil_detail"] = $this->data_persil_model->get_persil($id);
		if($id > 0){
			$data['pemilik'] = $this->data_persil_model->get_penduduk($data["persil_detail"]["nik"]);
		}else{
			$data['pemilik']=false;
		}

		$data["persil_lokasi"] = $this->data_persil_model->list_dusunrwrt();

		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		
		$this->load->view('data_persil/detail',$data);
		$this->load->view('footer');
	}
	
	function create($id=0){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
		
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);

		$data["penduduk"] = $this->data_persil_model->list_penduduk();
		$data["persil_detail"] = $this->data_persil_model->get_persil($id);
		if($id > 0){
			$data['pemilik'] = $this->data_persil_model->get_penduduk($data["persil_detail"]["nik"]);
		}else{
			$data['pemilik']=false;
		}

		if(isset($_POST['nik'])){
			$data['pemilik']=$this->data_persil_model->get_penduduk($_POST['nik']);
		}
			
		$data["persil_lokasi"] = $this->data_persil_model->list_dusunrwrt();
		
		
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		$this->load->view('data_persil/create',$data);
		$this->load->view('footer');
	}
	
	function create_ext($id=0){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
		
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);

		$data["penduduk"] = $this->data_persil_model->list_penduduk();
		$data["persil_detail"] = $this->data_persil_model->get_persil($id); 
		
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		$this->load->view('data_persil/create_ext',$data);
		$this->load->view('footer');
	}
	
	function simpan_persil($page=1){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');

		$header = $this->header_model->get_data();
		$this->load->view('header', $header);

		$data["hasil"] = $this->data_persil_model->simpan_persil();
		$data["persil"] = $this->data_persil_model->list_persil(0,$page);
		
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		redirect("data_persil/clear");
		$this->load->view('data_persil/persil',$data);
		$this->load->view('footer');
	}

	function jenis($apa=0,$page=1){
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();

		$data["persil"] = $this->data_persil_model->list_persil('jenis',$apa,$page);;

		$this->load->view('data_persil/persil',$data);
		$this->load->view('footer');
	}
	
	function peruntukan($apa='',$page=1){
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();

		$data["persil"] = $this->data_persil_model->list_persil('peruntukan',$apa,$page);;
		
		$this->load->view('data_persil/persil',$data);
		$this->load->view('footer');
	}

	function persil_jenis($id=0){
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$data["id"]=$id;
		if ($this->form_validation->run() === FALSE){
			$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
			$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
			$data["persil_jenis_detail"] = $this->data_persil_model->get_persil_jenis($id);
			$data["hasil"] = false;
			$this->load->view('data_persil/persil_jenis',$data);
		}else{
			$data["hasil"] = $this->data_persil_model->update_persil_jenis($id);
			$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
			$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
			$data["persil_jenis_detail"] = $this->data_persil_model->get_persil_jenis($id);
			$this->load->view('data_persil/persil_jenis',$data);
		}
		$this->load->view('footer');
	}
	
	public function hapus_persil_jenis($id){
		$this->data_persil_model->hapus_jenis($id);
		redirect("data_persil/persil_jenis");
	}
	
	function persil_peruntukan($id=0){
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nama', 'Nama Jenis Persil', 'required');
		$header = $this->header_model->get_data();
		$this->load->view('header', $header);
		$data["id"]=$id;
		if ($this->form_validation->run() === FALSE){
			$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
			$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
			$data["persil_peruntukan_detail"] = $this->data_persil_model->get_persil_peruntukan($id);
			$data["hasil"] = false;
			$this->load->view('data_persil/persil_peruntukan',$data);
		}else{
			$data["hasil"] = $this->data_persil_model->update_persil_peruntukan($id);
			$data["persil_peruntukan"] = $this->data_persil_model->list_persil_peruntukan();
			$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
			$data["persil_peruntukan_detail"] = $this->data_persil_model->get_persil_peruntukan($id);
			$this->load->view('data_persil/persil_peruntukan',$data);
		}
		$this->load->view('footer');
	}	

	public function hapus_persil_peruntukan($id){
		$this->data_persil_model->hapus_peruntukan($id);
		redirect("data_persil/persil_peruntukan");
	}
	
	public function hapus($id){
		$this->data_persil_model->hapus_persil($id);
		redirect("data_persil");
	}
	
	function import_proses(){
		$this->load->model('import_model');
		$this->import_model->persil();
		redirect("data_persil");
	}
	
}

?>
