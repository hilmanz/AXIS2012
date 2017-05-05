<?php
error_reporting(0);
global $ENGINE_PATH;
global $CONFIG;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once $ENGINE_PATH."config/config.inc.php";
		
class message extends Admin{
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
		$filter='';
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;
		if($this->_g('search')) {
			$search = $this->_g('search');
			$filter .= " AND (message like '%{$search}%' OR nama like '%{$search}%' OR kota like '%{$search}%'  OR propinsi like '%{$search}%') ";
		}
		/* list message */
		$sql = "SELECT * FROM axis_message WHERE n_status<>3 {$filter} ORDER BY date_time DESC LIMIT {$start},{$total_per_page}";
		$list = $this->fetch($sql,1);
		
		$sql = " SELECT * FROM axis_message_type ";
		$typeMessage = $this->fetch($sql,1);
		
		foreach($typeMessage as $val){
			$arrType[$val['id']] = $val['type'];
		}
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total
			FROM axis_message
			WHERE n_status<>3 ");
		if($list) {
			foreach($list as $key => $val){
				if(array_key_exists($val['tipe'],$arrType))$list[$key]['message_type'] = $arrType[$val['tipe']];
			}
		}
		$total = intval($totalList);
		$this->View->assign('list',$list);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=message"));	
		return $this->View->toString("application/admin/message/message_list.html");
	}
	
	function csCorporate(){
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;
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
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=message&act=csCorporate&search={$this->_g('search')}&startdate={$this->_g('startdate')}&enddate={$this->_g('enddate')}"));	
		return $this->View->toString("application/admin/message/cs_corporate.html");
	}
	
	function detail_csCorporate(){
		$id = $this->_g('id');
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
			return $this->View->toString("application/admin/message/detail_csCorporate.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=message&act=csCorporate");
		}
		return $this->View->toString("application/admin/message/detail_csCorporate.html");
	}
	
	function hapus_csCorporate(){
		$id = $this->_g('id');
		if( !$this->query("UPDATE axis_message SET n_status=3 WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=message&act=csCorporate");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=message&act=csCorporate");
		}
	}
	
	function csWebsite(){
		$filter='';
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;
		$filter = $this->_g('search')=='' ? "" : " AND (msg.message like '%{$this->_g('search')}%' OR msg.nama like '%{$this->_g('search')}%' OR ct.city like '%{$this->_g('search')}%'  OR pr.province like '%{$this->_g('search')}%') " ;
		$filter .= $this->_g('startdate')=='' ? "" : " AND date_time >= '{$this->_g('startdate')}' ";
		$filter .= $this->_g('enddate')=='' ? "" : " AND date_time < '{$this->_g('enddate')}' ";
		
		$sql = "SELECT * FROM axis_message_type WHERE web_type=1";		
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
		
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total FROM axis_message WHERE n_status<>3 AND tipe IN ({$strCid}) {$filter} ");
		
		$total = intval($totalList['total']);
		$this->View->assign('list',$list);
		$this->View->assign('time',$time);
		$this->View->assign('search',$this->_g('search'));
		$this->View->assign('startdate',$this->_g('startdate'));
		$this->View->assign('enddate',$this->_g('enddate'));
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=message&act=csWebsite&search={$this->_g('search')}&startdate={$this->_g('startdate')}&enddate={$this->_g('enddate')}"));	
		return $this->View->toString("application/admin/message/cs_website.html");
	}
	
	function detail_csWebsite(){
		$id = $this->_g('id');
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
			return $this->View->toString("application/admin/message/detail_csWebsite.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=message&act=csWebsite");
		}
		return $this->View->toString("application/admin/message/detail_csWebsite.html");
	}
	
	function hapus_csWebsite(){
		$id = $this->_g('id');
		if( !$this->query("UPDATE axis_message SET n_status=3 WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=message&act=csWebsite");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=message&act=csWebsite");
		}
	}
	
	function uploadCV(){
		$filter='';
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 10;
		$filter = $this->_g('search')=='' ? "" : " AND cv_name LIKE '%{$this->_g('search')}%' " ;
		$filter .= $this->_g('startdate')=='' ? "" : " AND tgl_submit >= '{$this->_g('startdate')}' ";
		$filter .= $this->_g('enddate')=='' ? "" : " AND tgl_submit < '{$this->_g('enddate')}' ";
		
		/* list message */
		$sql = "SELECT * FROM tbl_submit_cv WHERE 1 {$filter} ORDER BY tgl_submit DESC LIMIT {$start},{$total_per_page}";
		$list = $this->fetch($sql,1);
		
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total FROM tbl_submit_cv WHERE 1 {$filter}");
		
		$total = intval($totalList['total']);
		$this->View->assign('list',$list);
		$this->View->assign('time',$time);
		$this->View->assign('search',$this->_g('search'));
		$this->View->assign('startdate',$this->_g('startdate'));
		$this->View->assign('enddate',$this->_g('enddate'));
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=message&act=uploadCV&search={$this->_g('search')}&startdate={$this->_g('startdate')}&enddate={$this->_g('enddate')}"));	
		return $this->View->toString("application/admin/message/cv_upload.html");
	}
	
	function downloadCV(){
		global $CONFIG;
		$file = $this->_g('file');
		
		while (ob_get_level() > 0){
			ob_end_clean();
		}
		$size = sprintf('%u', filesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}cv/".$file));
		
		header('Expires: 0');
		header('Pragma: public');         
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');         
		header('Content-Type: application/octet-stream');
		header('Content-Length: ' . $size);
		header('Content-Transfer-Encoding: binary');          
		header('Content-disposition: attachment; filename='. str_replace(' ','_',$file));
		readfile("{$CONFIG['LOCAL_PUBLIC_ASSET']}cv/".$file);
		exit;
	}
	
	function delete(){
		$parentid = $this->_g('parentid');
		if( !$this->query("UPDATE axis_coorporate_blog SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=coorporate_blog");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=coorporate_blog");
		}
	}
}