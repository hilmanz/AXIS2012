<?php
error_reporting(0);
global $ENGINE_PATH;
global $CONFIG;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once $ENGINE_PATH."config/config.inc.php";
		
class message_cscorporate extends Admin{
	function __construct(){	
		parent::__construct();
	}
	
	function admin(){
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 20;
		$filter = $this->_g('search')=='' ? "" : " AND (msg.message like '%{$this->_g('search')}%' OR msg.nama like '%{$this->_g('search')}%' OR ct.city like '%{$this->_g('search')}%'  OR pr.province like '%{$this->_g('search')}%') " ;
		$filter .= $this->_g('startdate')=='' ? "" : " AND msg.date_time >= '{$this->_g('startdate')}' ";
		$filter .= $this->_g('enddate')=='' ? "" : " AND msg.date_time < '{$this->_g('enddate')}' ";
		
		$sql = "SELECT * FROM axis_message_type WHERE web_type=2";
		$qData = $this->fetch($sql,1);
		foreach($qData as $val){
			$arrMessageID[] = $val['id'];
		}
		
		$strCid = implode(',',$arrMessageID);
		/* list message */
		$sql = "
			SELECT msg.*,mt.type,pr.province,ct.city 
			FROM axis_message msg
			LEFT JOIN axis_message_type mt ON msg.tipe = mt.id
			LEFT JOIN axis_province_reference pr ON msg.propinsi = pr.id
			LEFT JOIN axis_city_reference ct ON msg.kota = ct.id
			WHERE msg.n_status<>3 
			AND msg.tipe IN ({$strCid}) {$filter} 
			ORDER BY msg.date_time DESC LIMIT {$start},{$total_per_page}
		";
		$list = $this->fetch($sql,1);
		$totalList = $this->fetch("SELECT count(*) total FROM axis_message WHERE n_status<>3 AND tipe IN ({$strCid}) {$filter}");
		$total = intval($totalList['total']);
		$this->View->assign('list',$list);
		$this->View->assign('time',$time);
		$this->View->assign('search',$this->_g('search'));
		$this->View->assign('startdate',$this->_g('startdate'));
		$this->View->assign('enddate',$this->_g('enddate'));
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=message_cscorporate&search={$this->_g('search')}&startdate={$this->_g('startdate')}&enddate={$this->_g('enddate')}"));	
		return $this->View->toString("application/admin/cscorporate/cs_corporate.html");
	}
	
	function detail(){
		$id = $this->_g('id');
		
		$this->View->assign('search',$this->_g('search'));
		$this->View->assign('startdate',$this->_g('startdate'));
		$this->View->assign('enddate',$this->_g('enddate'));
		
		$sql = "
			SELECT msg.*,mt.type,pr.province,ct.city 
			FROM axis_message msg
			LEFT JOIN axis_message_type mt ON msg.tipe = mt.id
			LEFT JOIN axis_province_reference pr ON msg.propinsi = pr.id
			LEFT JOIN axis_city_reference ct ON msg.kota = ct.id
			WHERE msg.id={$id}
		";
		$list_message = $this->fetch($sql);
		if( is_array($list_message) ){
			$this->View->assign("nama",$list_message['nama']);
			$this->View->assign("email",$list_message['email']);
			$this->View->assign("propinsi",$list_message['province']);
			$this->View->assign("kota",$list_message['city']);
			$this->View->assign("telepon",$list_message['telepon']);
			$this->View->assign("tipe",$list_message['type']);
			$this->View->assign("message",$list_message['message']);
			return $this->View->toString("application/admin/cscorporate/detail_csCorporate.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=message_cscorporate");
		}
		return $this->View->toString("application/admin/cscorporate/detail_csCorporate.html");
	}
	
	function hapus(){
		$id = $this->_g('id');
		if( !$this->query("UPDATE axis_message SET n_status=3 WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=message_cscorporate");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=message_cscorporate");
		}
	}
	
	function export_excel(){
		$search = $this->_g('search');
		$startdate = $this->_g('startdate');
		$enddate = $this->_g('enddate');
		$filter = $this->_g('search')=='' ? "" : " AND (msg.message like '%{$this->_g('search')}%' OR msg.nama like '%{$this->_g('search')}%' OR ct.city like '%{$this->_g('search')}%'  OR pr.province like '%{$this->_g('search')}%') " ;
		$filter .= $this->_g('startdate')=='' ? "" : " AND msg.date_time >= '{$this->_g('startdate')}' ";
		$filter .= $this->_g('enddate')=='' ? "" : " AND msg.date_time < '{$this->_g('enddate')}' ";
		
		$sql = "SELECT * FROM axis_message_type WHERE web_type=2";
		$qData = $this->fetch($sql,1);
		foreach($qData as $val){
			$arrMessageID[] = $val['id'];
		}
		
		$strCid = implode(',',$arrMessageID);
		/* list message */
		$sql = "
			SELECT msg.nama,msg.email,pr.province,ct.city,msg.telepon,mt.type,msg.message,msg.date_time
			FROM axis_message msg
			LEFT JOIN axis_message_type mt ON msg.tipe = mt.id
			LEFT JOIN axis_province_reference pr ON msg.propinsi = pr.id
			LEFT JOIN axis_city_reference ct ON msg.kota = ct.id
			WHERE msg.n_status<>3 
			AND msg.tipe IN ({$strCid}) {$filter} 
			ORDER BY msg.date_time DESC
		";
		
		$r = $this->fetch($sql,1);
		$status = array(0=>"Non Publishing",1=>"Publishing");
		
		/* $no=1;
		foreach($r as $key => $val){
			$val['no'] = $no++;
			$val['n_status'] = $status[$val['n_status']];
			$data[] = $val;
		} */
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Utility/PHPExcelWrapper.php";
		$excel = new PHPExcelWrapper();
		$excel->setGlobalBorder(true, 'allborders', '00000000');
		$excel->setHeader(array('Nama','Email','Propinsi','Kota','Telepon','Type','Message','Posted Date'));
		$excel->getExcel($r,'message_csCorporate');
		exit;
	}
}