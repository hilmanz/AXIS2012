<?php
error_reporting(E_ALL);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class dashboard extends Admin{
	function __construct(){	
		parent::__construct();	
		$this->type = 0;
	}
	
	function admin(){
		if($this->_g("lid")) $this->lid = $this->_g("lid");
		else  $this->lid = 1;
		//helper
		global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$startdate = $this->Request->getParam('startdate');
		$enddate = $this->Request->getParam('enddate');
		if($startdate=='') $startdate = "2012-12-12";
		if($enddate=='') $enddate = date("Y-m-d");
		$qData = $this->getData($startdate,$enddate);
		// pr($qData);exit;
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('xls',false);
		$this->View->assign('data',$qData);
		
		return $this->View->toString("application/admin/dashboard/dashboard_list.html");
	}
	
	function getxls(){
		$startdate = $this->Request->getParam('startdate');
		$enddate = $this->Request->getParam('enddate');
		if($startdate=='') $startdate = "2012-12-12";
		if($enddate=='') $enddate = date("Y-m-d");
		$qData = $this->getData($startdate,$enddate);
		
		
		$this->View->assign('xls',true);
		$this->View->assign('data',$qData);
		$filename = "report_".date("YmdHis")."_weekly.xls";
		
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		
		print $this->View->toString("application/admin/dashboard/dashboard_list.html");
		exit;
	}
	
	function getData($startdate,$enddate){
		// log my world
		$sql ="select 'My World' map,count(*) total FROM tbl_activity_log where action_id=4 AND action_value='User Page' AND date_time between '{$startdate}' AND '{$enddate}'  group by action_id LIMIT 1;";
		$qData['total visit my world'] = $this->fetch($sql,1);
		
		// social media akun
		$sql ="select register_by,count(*) total   FROM social_member WHERE register_date BETWEEN '{$startdate}' AND  '{$enddate}'  GROUP BY register_by;";
		$qData['social media akun'] = $this->fetch($sql,1);
		
		// total login per social media
		$sql ="select action_value, count(*) total FROM tbl_activity_log where action_id=1 AND date_time between '{$startdate}' AND '{$enddate}'  group by action_value ORDER BY total DESC LIMIT 0,3;";
		$qData['total login per social media'] = $this->fetch($sql,1);
		
		// most view article
		$sql ="select title ,count(*) total FROM tbl_activity_log a LEFT JOIN axis_news_content b ON b.id=a.action_value WHERE articleType=2  AND action_id=2 AND date_time BETWEEN '{$startdate}' AND '{$enddate}' GROUP BY action_value ORDER BY total DESC LIMIT 1;";
		$qData['most view article'] = $this->fetch($sql,1);
		
		// most comment article
		$sql ="select title,count(*) total FROM axis_news_content_comment a LEFT JOIN axis_news_content b ON b.id=a.contentid WHERE date between '{$startdate}' AND  '{$enddate}' GROUP BY a.contentid ORDER BY total DESC LIMIT 1;";
		$qData['most comment article'] = $this->fetch($sql,1);
		
		// most rating article
		$sql ="select title,count(*) total FROM axis_news_content_rating a LEFT JOIN axis_news_content b ON b.id=a.contentid WHERE date between '{$startdate}' AND  '{$enddate}' GROUP BY contentid ORDER BY total DESC LIMIT 1;";
		$qData['most rating article'] = $this->fetch($sql,1);
		
		// most share social media article
			//facebook
			$sql ="select  'facebook' socmed,title,facebook FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=2 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY facebook desc LIMIT 1;";
			$qData['most share social media article']['facebook'] = $this->fetch($sql);
			//twitter
			$sql ="select  'twitter' socmed,title,twitter FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=2 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY twitter desc LIMIT 1;";
			$qData['most share social media article']['twitter'] = $this->fetch($sql);
			//gplus
			$sql ="select  'gplus' socmed,title,gplus FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=2 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY gplus desc LIMIT 1;";
			$qData['most share social media article']['gplus'] = $this->fetch($sql);
			
		
		// most share social media promo
			//facebook
			$sql ="select 'facebook' socmed, title,facebook FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=3 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY facebook desc LIMIT 1;";
			$qData['most share social media promo']['facebook'] = $this->fetch($sql);
			//twitter
			$sql ="select  'twitter' socmed,title,twitter FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=3 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY twitter desc LIMIT 1;";
			$qData['most share social media promo']['twitter'] = $this->fetch($sql);
			//gplus
			$sql ="select  'gplus' socmed,title,gplus FROM tbl_summary_share_content a LEFT JOIN axis_news_content b ON a.contentid=b.id WHERE articleType=3 AND posted_date BETWEEN '{$startdate}' AND '{$enddate}' ORDER BY gplus desc LIMIT 1;";
			$qData['most share social media promo']['gplus'] = $this->fetch($sql);


		// most visited menu & pageview
		$sql ="select action_value, count(*) total FROM tbl_activity_log where action_id=4 AND date_time between '{$startdate}' AND '{$enddate}'  AND action_value NOT IN ('home','wap-home','mobile-home','axis-wap-produk-detail','change-locale-2','change-locale-1','LOGIN') group by action_value ORDER BY total DESC LIMIT 0,20;";
		$qData['most visited menu'] = $this->fetch($sql,1);
		
		if($qData) return $qData;
		else return false;
	}
	
}