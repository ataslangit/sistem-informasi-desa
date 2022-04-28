<?php

class First_Menu_M extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	function list_menu_atas(){
			
		$sql   = "SELECT m.* FROM menu m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 1 order by id asc";
		
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$url = site_url()."first/";
		$i=0;
		while($i<count($data)){
			//$man = spliti("l]:",$data[$i]['link']);
			//if($man[0]=="[manual ur"){
			//	$data[$i]['link'] = $man[1];
			//}
			
			//if($data[$i]['link_tipe']!=1)
				$data[$i]['menu'] = "<li><a href='$url".$data[$i]['link']."'>".$data[$i]['nama']."</a>";
			//else
				//$data[$i]['menu'] = "<li><a href='".$data[$i]['link']."'>".$data[$i]['nama']."</a>";
			
			$sql2   = "SELECT s.* FROM menu s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3";
			$query = $this->db->query($sql2,$data[$i]['id']);
			$data2=$query->result_array();
			
			if($data2){
				$data[$i]['menu'] = $data[$i]['menu']."<ul>";
				$j=0;
				while($j<count($data2)){
					
					//if($data2[$j]['link_tipe']!=1)
						$data[$i]['menu'] = $data[$i]['menu']."<li><a href='$url".$data2[$j]['link']."'>".$data2[$j]['nama']."</a></li>";
					//else
						//$data[$i]['menu'] = $data[$i]['menu']."<li><a href='".$data2[$j]['link']."'>".$data2[$j]['nama']."</a></li>";
					
					$j++;
				}
				$data[$i]['menu'] = $data[$i]['menu']."</ul>";
			}
			$data[$i]['menu'] = $data[$i]['menu']."</li>";
			$i++;
		}
		return $data;
	}
	
	function list_menu_kiri(){
	

		$sql   = "SELECT m.*,m.kategori AS nama FROM kategori m WHERE m.parrent =0 AND m.enabled = 1 AND m.kategori <> 'teks_berjalan' ORDER BY id";
		
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$url = site_url()."first/kategori/";
		$i=0;
		
		while($i<count($data)){
					$data[$i]['menu'] = "<li><a href='$url".$data[$i]['id']."'>".$data[$i]['nama']."</a>";
					
				$sql2   = "SELECT s.*,s.kategori AS nama FROM kategori s WHERE s.parrent = ? AND s.enabled = 1";
				$query = $this->db->query($sql2,$data[$i]['id']);
				$data2=$query->result_array();
				
				if($data2){
					$data[$i]['menu'] = $data[$i]['menu']."<ul>";
					$j=0;
					while($j<count($data2)){
							$data[$i]['menu'] = $data[$i]['menu']."<li><a href='$url".$data2[$j]['id']."'>".$data2[$j]['nama']."</a></li>";
						$j++;
					}
					$data[$i]['menu'] = $data[$i]['menu']."</ul>";
				}
				$data[$i]['menu'] = $data[$i]['menu']."</li>";
			$i++;
		}
		return $data;
	}
}