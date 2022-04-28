<?php
class Header_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
		
	function get_id_user($user=''){
		$sql   = "SELECT id FROM user WHERE username=?";
		$query = $this->db->query($sql,$user);
		$data = $query->row_array();
		return $data['id'];
	}	
	
	function get_data(){
	/*
	 * global variabel
	 * */
		$outp["sasaran"] = array("1"=>"Penduduk","2"=>"Keluarga / KK","3"=>"Rumah Tangga","4"=>"Kelompok/Organisasi Kemasyarakatan");
		
		/*
		 * Pembenahan per 13 Juli 15, sebelumnya ada notifikasi Error, saat $_SESSOIN['user'] nya kosong!
		 * */
		$id = @$_SESSION['user'];
		$sql   = "SELECT nama,foto FROM user WHERE id=?";
		$query = $this->db->query($sql, $id);
		if($query){
			if($query->num_rows()>0){
				$data  = $query->row_array();
				$outp['nama'] = $data['nama'];
				$outp['foto'] = $data['foto'];
			}
		}
		
		$sql   = "SELECT * FROM config WHERE 1";
		$query = $this->db->query($sql);
		$outp['desa'] = $query->row_array();


		$sql   = "SELECT COUNT(id) AS jml FROM komentar WHERE id_artikel=775 AND enabled = 2;";
		$query = $this->db->query($sql);
		$lap = $query->row_array();
		$outp['lapor'] = $lap['jml'];
		
		return $outp;
	}
	
	function get_config(){
		$sql   = "SELECT * FROM config WHERE 1";
		$query = $this->db->query($sql);
		$outp['desa'] = $query->row_array();
		return $outp;
	}
}
