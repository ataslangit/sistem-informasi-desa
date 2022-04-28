<?php class Laporan_Bulanan_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	
			
		$sql   = "SELECT (SELECT COUNT(id) FROM tweb_penduduk WHERE status_dasar =1) AS pend,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_dasar =1 AND sex =1) AS lk,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_dasar =1 AND sex =2) AS pr,(SELECT COUNT(id) FROM tweb_keluarga) AS kk";
		$query = $this->db->query($sql);
		$data=$query->row_array();
		
		$bln=date("m");
		$thn=date("Y");
		
		$sql   = "SELECT * FROM log_bulanan WHERE month(tgl) = $bln AND year(tgl) = $thn";
		$query = $this->db->query($sql);
		$ada  = $query->result_array();
		
		if(!$ada){
			$this->db->insert('log_bulanan',$data);
		}else{
		
			$sql = "UPDATE log_bulanan SET pend=$data[pend], lk = $data[lk],pr=$data[pr],kk = $data[kk] WHERE month(tgl) = $bln AND year(tgl) = $thn";
			$this->db->query($sql);
		}
		
	
	
	}

	function autocomplete(){
		$sql   = "SELECT dusun_nama FROM tweb_wil_dusun";
		$query = $this->db->query($sql);
		$data  = $query->result_array();
		
		$i=0;
		$outp='';
		while($i<count($data)){
			$outp .= ",'" .$data[$i]['dusun_nama']. "'";
			$i++;
		}
		$outp = strtolower(substr($outp, 1));
		$outp = '[' .$outp. ']';
		return $outp;
	}

	function search_sql(){
		if(isset($_SESSION['cari'])){
		$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' .$kw. '%';
			$search_sql= " AND u.nama LIKE '$kw'";
			return $search_sql;
			}
		}

	function dusun_sql(){		
		if(isset($_SESSION['dusun'])){
			$kf = $_SESSION['dusun'];
			if($kf==""){
			$dusun_sql= "";} else {			
			$dusun_sql= " AND c.dusun = '".$kf."'";}
		return $dusun_sql;
		}
	}
	
	function bulan_sql(){		
		if(isset($_SESSION['bulanku'])){
			$kf = $_SESSION['bulanku'];
			if($kf==""){
			$bulan_sql= "";} else {			
			$bulan_sql= " where bulan = $kf";}
		return $bulan_sql;
		}
	}
	
	function tahun_sql(){		
		if(isset($_SESSION['tahunku'])){
			$kf = $_SESSION['tahunku'];
			if($kf==""){
			$bulan_sql= "";} else {			
			$bulan_sql= " and tahun = $kf";}
		return $bulan_sql;
		}
	}
	
	function bulan($bulan)
		{
		Switch ($bulan){
		    case 1 : $bulan="Januari";
			Break;
		    case 2 : $bulan="Februari";
			Break;
		    case 3 : $bulan="Maret";
			Break;
		    case 4 : $bulan="April";
			Break;
		    case 5 : $bulan="Mei";
			Break;
		    case 6 : $bulan="Juni";
			Break;
		    case 7 : $bulan="Juli";
			Break;
		    case 8 : $bulan="Agustus";
			Break;
		    case 9 : $bulan="September";
			Break;
		    case 10 : $bulan="Oktober";
			Break;
		    case 11 : $bulan="November";
			Break;
		    case 12 : $bulan="Desember";
			Break;
		    }
		return $bulan;
		}


	function paging($lap=0,$p=1,$o=0){
		
		switch($lap){
			case 0: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 1: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pekerjaan u WHERE 1 "; break;
			case 2: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 3: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 4: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 5: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 6: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 7: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			case 8: $sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 "; break;
			default:$sql      = "SELECT COUNT(id) AS id FROM tweb_penduduk_pendidikan u WHERE 1 ";
		}
	
		//$sql     .= $this->search_sql();     
		$query    = $this->db->query($sql);
		$row      = $query->row_array();
		$jml_data = $row['id'];
		
		$this->load->library('paging');
		$cfg['page']     = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);
		
		return $this->paging;
	}
	
	function list_data(){
	
		$sql="select c.id as id_cluster,c.rt,c.rw,c.dusun as dusunnya, 
(select count(id) from tweb_penduduk where sex='1' and id_cluster=c.id) as L,
(select count(id) from tweb_penduduk where sex='2' and id_cluster=c.id) as P,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<1 and id_cluster=c.id ) as bayi,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=1 and (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=5  and id_cluster=c.id ) as balita,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=6 and (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=12  and id_cluster=c.id ) as sd,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=13 and (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=15  and id_cluster=c.id ) as smp,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>=16 and (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)<=18  and id_cluster=c.id ) as sma,
(select count(id) from tweb_penduduk where (DATE_FORMAT( FROM_DAYS( TO_DAYS(NOW()) - TO_DAYS( tanggallahir ) ) , '%Y' ) +0)>60 and id_cluster=c.id ) as lansia,
(select count(id) from tweb_penduduk where cacat_id is not null and cacat_id <>'0'  and id_cluster=c.id) as cacat,
(select count(id) from tweb_penduduk where sakit_menahun_id is not null and sakit_menahun_id <>'0' and id_cluster=c.id and sex='1') as sakit_L,
(select count(id) from tweb_penduduk where sakit_menahun_id is not null and sakit_menahun_id <>'0' and id_cluster=c.id and sex='2') as sakit_P,
(select count(id) from tweb_penduduk where hamil='1' and id_cluster=c.id) as hamil
from  tweb_wil_clusterdesa c WHERE rw<>'0' AND rt<>'0' AND (select count(id) from tweb_penduduk where id_cluster=c.id)>0  ";	
		
		$sql .= $this->dusun_sql();
		
		$sql .= " ORDER BY c.dusun,c.rw,c.rt ";
		$query = $this->db->query($sql);
		$data=$query->result_array();
	//	$data = null;
		//Formating Output
		$i=0;
		while($i<count($data)){
			$data[$i]['no']=$i+1;
			$data[$i]['tabel']=$data[$i]['rt'];
			$i++;
		}
		return $data;
	}
	
	
  function list_dusun(){
		$sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' ";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}


	function configku(){
		$sql   = "SELECT * FROM config limit 1 ";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function penduduk_awal(){
	
		$bln=$_SESSION['bulanku'];
		$thn=$_SESSION['tahunku'];
		
		$sql   = "SELECT lk as WNI_L,pr AS WNI_P FROM log_bulanan WHERE month(tgl) = $bln-1 AND year(tgl) = $thn;";
		$query = $this->db->query($sql);
		if($query){
			if($query->num_rows() > 0){
				$hasil=$query->row();
				$data= array(
				"WNI_L"=>$hasil->WNI_L, 
				"WNI_P"=>$hasil->WNI_P, 
				"WNA_L"=>0,
				"WNA_P"=>0,
				"bulan"=>$bln,
				"tahun"=>$thn);
			}else{
				$data= array(
				"WNI_L"=>0, 
				"WNI_P"=>0, 
				"WNA_L"=>0,
				"WNA_P"=>0,
				"bulan"=>$bln,
				"tahun"=>$thn);
			}
		}else{
			$data = $this->db->error_reporting();
		}
		return $data;
	}

	function penduduk_akhir(){
	
		$bln=$_SESSION['bulanku'];
		$thn=$_SESSION['tahunku'];
		
		$sql   = "SELECT lk as WNI_L,pr AS WNI_P FROM log_bulanan WHERE month(tgl) = $bln AND year(tgl) = $thn;";
		$query = $this->db->query($sql);
		$hasil=$query->row_array();
		$data= array(
		"WNI_L"=>$hasil["WNI_L"], 
		"WNI_P"=>$hasil["WNI_P"], 
		"WNA_L"=>0,
		"WNA_P"=>0,
		"bulan"=>$bln,
		"tahun"=>$thn);
		return $data;
	}

	function penduduk_akhirx(){
	$paging_sql = ' LIMIT 1';
		$sql   = "SELECT (select count(s.id) from log_penduduk s INNER join tweb_penduduk p on s.id_pend=p.id  where warganegara_id='1' and sex='1' and id_detail in ('5','1','8')   and day(tanggal)>15  and day(tanggal)<=30 and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_L,
(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id  where warganegara_id='1' and sex='2' and id_detail in ('5','1','8')   and day(tanggal)>15  and day(tanggal)<=30  and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_P,
(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id  where warganegara_id='2' and sex='1' and id_detail in ('5','1','8')   and day(tanggal)>15  and day(tanggal)<=30 and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_L,
(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id  where warganegara_id='2' and sex='2'  and id_detail in ('5','1','8')  and day(tanggal)>15  and day(tanggal)<=30  and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_P, bulan, tahun  
FROM log_penduduk   ";
		$sql .= $this->bulan_sql();
		$sql .= $this->tahun_sql();
		$sql .= $paging_sql;
		$query = $this->db->query($sql);
		$data=$query->row_array();
		return $data;
	}

	function kelahiran(){
		$sql   = "SELECT (SELECT COUNT(id) FROM tweb_penduduk WHERE month(tanggallahir) = ? AND year(tanggallahir) =? AND sex = 1) AS WNI_L,(SELECT COUNT(id) FROM tweb_penduduk WHERE month(tanggallahir) = ? AND year(tanggallahir) =? AND sex = 1) AS WNI_P";
		$query = $this->db->query($sql,array($_SESSION['bulanku'],$_SESSION['tahunku'],$_SESSION['bulanku'],$_SESSION['tahunku']));
		$data=$query->row_array();
	
			$data['WNA_L']=0;
			$data['WNA_P']=0;
		return $data;
	}

	function kematian(){
		$sql   = "SELECT (SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex =1 AND id_detail =2) AS WNI_L,(SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex = 2 AND id_detail = 2) AS WNI_P";
		$query = $this->db->query($sql,array($_SESSION['bulanku'],$_SESSION['tahunku'],$_SESSION['bulanku'],$_SESSION['tahunku']));
		$data=$query->row_array();
	
			$data['WNA_L']=0;
			$data['WNA_P']=0;
		return $data;
	}

	function pindah(){
		$sql   = "SELECT (SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex =1 AND id_detail =3) AS WNI_L,(SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex = 2 AND id_detail = 3) AS WNI_P";
		$query = $this->db->query($sql,array($_SESSION['bulanku'],$_SESSION['tahunku'],$_SESSION['bulanku'],$_SESSION['tahunku']));
		$data=$query->row_array();
	
			$data['WNA_L']=0;
			$data['WNA_P']=0;
		return $data;
	}

	function pendatang(){
		$bln=$_SESSION['bulanku'];
		$thn=$_SESSION['tahunku'];
		
		$paging_sql = ' LIMIT 1';
		$sql   = "SELECT (select count(s.id) from log_penduduk s INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='1' and sex='1' and id_detail in ('8','5') and  month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_L,
		(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='1' and sex='2' and id_detail in ('8','5')  and  month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_P,
		(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='2' and sex='1' and id_detail in ('8','5')  and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_L,
		(select count(s.id) from log_penduduk s  INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='2' and sex='2'  and id_detail in ('8','5')   and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_P , bulan, tahun 
		FROM log_penduduk   ";
		$sql .= $this->bulan_sql();
		$sql .= $this->tahun_sql();
		$sql .= $paging_sql;
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			$data=$query->row_array();
		}else{
			$data= array(
			"WNI_L"=>0, 
			"WNI_P"=>0,
			"WNA_L"=>0,
			"WNA_P"=>0,
			"bulan"=>$bln,
			"tahun"=>$thn);
		}
		return $data;
	}

	function pindahx(){
	$paging_sql = ' LIMIT 1';
		$sql   = "SELECT (select count(s.id) from log_penduduk s INNER join detail_log_penduduk t on s.id_detail=t.id INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='1' and sex='1' and id_detail='3' and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_L,
(select count(s.id) from log_penduduk s INNER join detail_log_penduduk t on s.id_detail=t.id INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='1' and sex='2'  and id_detail='3' and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNI_P,
(select count(s.id) from log_penduduk s INNER join detail_log_penduduk t on s.id_detail=t.id INNER join tweb_penduduk p on 
s.id_pend=p.id and warganegara_id='2' and sex='1'  and id_detail='3' and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_L,
(select count(s.id) from log_penduduk s INNER join detail_log_penduduk t on s.id_detail=t.id INNER join tweb_penduduk p on s.id_pend=p.id and warganegara_id='2' and sex='2'   and id_detail='3' and month(tanggal)=month(curdate()) and year(tanggal)=year(curdate()) ) as WNA_P , bulan, tahun 
FROM log_penduduk   ";
		$sql .= $this->bulan_sql();
		$sql .= $this->tahun_sql();
		$sql .= $paging_sql;
		$query = $this->db->query($sql);
		$data=$query->row_array();
		return $data;
	}

	function hilang(){
		$sql   = "SELECT (SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex =1 AND id_detail =4) AS WNI_L,(SELECT COUNT(u.id) FROM log_penduduk u LEFT JOIN tweb_penduduk p ON u.id_pend = p.id WHERE month(tgl_peristiwa) = ? AND year(tgl_peristiwa) =? AND sex = 2 AND id_detail = 4) AS WNI_P";
		$query = $this->db->query($sql,array($_SESSION['bulanku'],$_SESSION['tahunku'],$_SESSION['bulanku'],$_SESSION['tahunku']));
		$data=$query->row_array();
	
			$data['WNA_L']=0;
			$data['WNA_P']=0;
		return $data;
	}

}

?>
