<?php

global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class barcode extends Admin{
	function __construct(){
	
		parent::__construct();
		
	}
	
	function admin(){
		
		$act = $this->Request->getParam('act');
		
		if(!$act){
			return $this->activity();
		}else{
			return $this->$act();
		}
	}

	function activity(){	
		
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 10;
		$sql = "SELECT * FROM ".SCHEMA_DATA.".soundrenaline_status_code ORDER BY entry_date DESC LIMIT {$start},{$total_per_page}";
		$totalSql = "SELECT count(*) total FROM ".SCHEMA_DATA.".soundrenaline_status_code WHERE 1";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$barcode = $this->fetch($totalSql);
		$this->close();
		// print_r($list);exit;
		$total = $barcode['total'];
		$this->View->assign('list',$list);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=barcode&act=activity"));	
		return $this->View->toString("soundrenaline/admin/barcode/activity.html");
	}
	
	function downloadreport(){
	
		$total_per_page = 10;
		$sql = "SELECT * FROM ".SCHEMA_DATA.".soundrenaline_status_code ORDER BY entry_date DESC";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$this->close();
		
	
		
		$export_file = "barcode_activity_".date('Y-m-d').".xls";
		ob_end_clean();
		ini_set('zlib.output_compression','Off');
	   
		header('Pragma: public');
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");                  // Date in the past   
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
		header ("Pragma: no-cache");
		header("Expires: 0");
		header('Content-Transfer-Encoding: none');
		header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
		header("Content-type: application/x-msexcel");                    // This should work for the rest
		header('Content-Disposition: attachment; filename="'.basename($export_file).'"'); 
		$this->View->assign('list',$list);
		print $this->View->toString("soundrenaline/admin/barcode/downloadreport.html");
		exit;
		
		
	}
}