<?php
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once APP_PATH."Dashboard/SocialModel.php";
require_once $APP_PATH."Dashboard/helper/wordcloudHelper.php";
class Web extends SQLData{
	function __construct($req){
		parent::SQLData();
		$this->Request = $req;
		$this->View = new BasicView();
		$this->User = new UserManager();
	}
	function admin(){
		$act = $this->Request->getParam('actAjax');
		if ($act == 'daily'){
			return $this->dailyDataCat();
		}elseif($act == 'weekly'){
			return $this->weeklyData();
		}else{
			return $this->main();
		}
	}

	function main(){
		//###GA###
		$this->open(0);
		$sqlGA = "SELECT * FROM rpt_axis_dashboard";
		$ga = $this->fetch($sqlGA,1);
		$this->close();
		
		foreach($ga as $k=>$v){
			$key[$v['key']] = $v['value'];
		}
		//  
		//returning visitor
		$returningVisitor = round(($key['returning_visitors_percentage']), 2);
		$this->View->assign('returnVisitor', $returningVisitor);
		
		//bounce rate
		$bounceRate = round($key['bounce_rate'],2);
		$this->View->assign('bounceRate', $bounceRate);
		
		//total twitter shares rate
		$totalTwitterShares = $key['total_twitter_shares'];
		$this->View->assign('totalTwitterShares', $totalTwitterShares);
		
		//total facebook shares
		$totalFacebookShares = $key['total_facebook_shares'];
		$this->View->assign('totalFacebookShares', $totalFacebookShares);
		
		//total paid content clicks
		$totalPaidContentClicks = $key['total_paid_content_clicks'];
		$this->View->assign('totalPaidContentClicks', $totalPaidContentClicks);
		
		//total free content clicks
		$totalFreeContentClicks = $key['total_free_content_clicks'];
		$this->View->assign('totalFreeContentClicks', $totalFreeContentClicks);
		
		//###END###
		
		//Daily Data
		$this->open(0);
		$sql = "SELECT * 
				FROM rpt_axis_daily_data 
				WHERE data_type = 'registered'
				AND data_date > '2012-07-23'
				ORDER BY data_date DESC";
		$dd = $this->fetch($sql,1);
		$reverse = sizeof($dd)-1;
		foreach($dd as $k=>$v){
			$dd[$reverse] =  $v;
			$reverse--;
		}
		$this->close();
		
		foreach ($dd as $cat){
			$tgl = substr($cat["data_date"], 8, 2)."/".substr($cat["data_date"], 5, 2);
			$category[] = $tgl;
			$data[] = intval($cat["data_count"]);
		}
		
		$registered = array(
					"category" => $category,
					"data_count" => $data
					);
		
		
		//Weekly Winner
		$this->open(0);
		$sql2 = "SELECT *
				FROM rpt_axis_weekly_winner
				WHERE week_number = 1
				ORDER BY score DESC LIMIT 5";
		$ww = $this->fetch($sql2,1);
		$this->close();
		
		
		//Top 5 User
		// $this->open(0);
		// $sql3 = "SELECT a.*, b.fb_id
				// FROM rpt_axis_weekly_winner a
				// LEFT JOIN axis_member b
				// ON a.user_id = b.id
				// WHERE 1 ORDER BY a.score DESC LIMIT 5";
		// $t5u = $this->fetch($sql3,1);
		// $this->close();
		
		//Max people Online
		$this->open(0);
		$sql4 = "SELECT * 
				FROM rpt_axis_maximum_people_online
				WHERE online_date BETWEEN '2012-07-24' AND '2012-07-30'
				ORDER BY online_date
				ASC";
		$max = $this->fetch($sql4,1);
		$this->close();
		
		foreach ($max as $mpo){
			$tgl2 = substr($mpo["online_date"], 8, 2)."/".substr($mpo["online_date"], 5, 2);
			$category2[] = $tgl2;
			$data2[] = intval($mpo["online_count"]);
		}
		
		$max = array(
				"category" => $category2,
				"online_count" => $data2
		);
		
		//Free Content
		$this->open(0);
		$sql5 = "SELECT * FROM rpt_axis_top_items 
				WHERE item_type = '2'  and week_number = 1
				ORDER BY item_count DESC LIMIT 5";
		$free = $this->fetch($sql5,1);
		$this->close();
		
		//Paid Content
		$this->open(0);
		$sql6 = "SELECT * FROM rpt_axis_top_items 
				WHERE item_type = '1' and week_number = 1
				ORDER BY item_count DESC LIMIT 5";
		$paid = $this->fetch($sql6,1);
		$this->close();

		//Last Update
		// var_dump($_SESSION['lastUpdateAXIS']);
		$this->View->assign('axislastUpdate', $_SESSION['lastUpdateAXIS']);
		
		$this->View->assign("dd", json_encode($registered));
		$this->View->assign("ww", $ww);
		$this->View->assign("t5u", $t5u);
		$this->View->assign("max", json_encode($max));
		$this->View->assign("free", $free);
		$this->View->assign("paid", $paid);
		return $this->View->toString("dashboard/web.html");
	}
	
	function dailyDataCat(){
		$categoryID = $this->Request->getPost('categoryID');
		$this->open(0);
		$sql = "SELECT * 
				FROM rpt_axis_daily_data 
				WHERE data_type = '{$categoryID}'
				AND data_date > '2012-07-23'
				ORDER BY data_date DESC";
		$dd = $this->fetch($sql,1);
		$reverse = sizeof($dd)-1;
		foreach($dd as $k=>$v){
			$dd[$reverse] =  $v;
			$reverse--;
		}
		$this->close();
		
		foreach ($dd as $cat){
			$tgl = substr($cat["data_date"], 8, 2)."/".substr($cat["data_date"], 5, 2);
			$category[] = $tgl;
			$data[] = intval($cat["data_count"]);
		}
		$dailydata = array(
					"category" => $category,
					"data_count" => $data,
					"cat_name" => $dd[0]['data_type']
					);
		
		print_r(json_encode($dailydata));exit;
	}
	
	function weeklyData(){
		$weekNum = $this->Request->getPost('weekNum');
		
		$rangeDate = array(
					'1' => array('start' => '2012-07-24', 'end' => '2012-07-30'),
					'2' => array('start' => '2012-07-31', 'end' => '2012-08-06'),
					'3' => array('start' => '2012-08-07', 'end' => '2012-08-13'),
					'4' => array('start' => '2012-08-14', 'end' => '2012-08-18'),
					);
		//Weekly Winner
		if(date("Y-m-d") > $rangeDate[$weekNum]['end']){
			$n_status = 1;
		}else{
			$n_status = 0;
		}
		
		$this->open(0);
		$sql2 = "SELECT *
				FROM rpt_axis_weekly_winner a
				WHERE week_number = {$weekNum}
				ORDER BY score DESC LIMIT 5";
		$ww = $this->fetch($sql2,1);
		$this->close();
		
		//Max people Online
		$this->open(0);
		$sql4 = "SELECT * 
				FROM rpt_axis_maximum_people_online
				WHERE online_date BETWEEN '".$rangeDate[$weekNum]['start']."' AND '".$rangeDate[$weekNum]['end']."'
				ORDER BY online_date
				ASC";
		$max = $this->fetch($sql4,1);
		$this->close();
		
		foreach ($max as $mpo){
			$tgl2 = substr($mpo["online_date"], 8, 2)."/".substr($mpo["online_date"], 5, 2);
			$category2[] = $tgl2;
			$data2[] = intval($mpo["online_count"]);
		}
		
		$max = array(
				"category" => $category2,
				"online_count" => $data2
		);
		
		//Free Content
		$this->open(0);
		$sql5 = "SELECT * FROM rpt_axis_top_items 
				WHERE item_type = '2' and week_number = {$weekNum}
				ORDER BY item_count DESC LIMIT 5";
		$free = $this->fetch($sql5,1);
		$this->close();
		
		//Paid Content
		$this->open(0);
		$sql6 = "SELECT * FROM rpt_axis_top_items 
				WHERE item_type = '1' and week_number = {$weekNum}
				ORDER BY item_count DESC LIMIT 5";
		$paid = $this->fetch($sql6,1);
		$this->close();
		
		$weeklyData = array(
						'winner' => $ww,
						'maxOnline' => $max,
						'free' => $free,
						'paid' => $paid
		);
		
		print_r(json_encode($weeklyData));exit;
	}
}