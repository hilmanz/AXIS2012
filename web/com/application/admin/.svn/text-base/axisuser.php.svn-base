<?php
error_reporting(0);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class axisuser extends Admin{
	function __construct(){
		parent::__construct();		
	}
	
	function admin(){
		global $CONFIG;
		$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
	
		if($this->Request->getParam('act') == 'hapus' ){
			return $this->Axisuser_delete();
		}elseif($this->Request->getParam('act') == 'excel_listuser' ){
			return $this->excel_listuser();
		} else {
			return $this->Axisuser_list();
		}
	}

	function Axisuser_list(){
		$time['time'] = '%H:%M:%S';
		$total_per_page = 20;
		$start = intval($this->Request->getParam('st'));
		
		$filter = $this->_g('search')=='' ? "" : " AND ( name like '%{$this->_g('search')}%' OR nickname like '%{$this->_g('search')}%' OR email like '%{$this->_g('search')}%' OR username like '%{$this->_g('search')}%' OR last_name like '%{$this->_g('search')}%' ) ";
		$filter .= $this->_g('startdate')=='' ? "" : " AND register_date >= '{$this->_g('startdate')}' ";
		$filter .= $this->_g('enddate')=='' ? "" : " AND register_date < '{$this->_g('enddate')}' ";
		
		$sql = "SELECT * FROM social_member WHERE n_status<>3 {$filter} ORDER BY register_date DESC LIMIT {$start},{$total_per_page}";
		$totalSql = "SELECT count(*) total FROM social_member WHERE n_status<>3 {$filter}";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$member = $this->fetch($totalSql);
		$this->close();
		$total = $member['total'];
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
			$arrIDuser[$v['id']] = $v['id'];
		}
		
		$strIDuser = implode(",",$arrIDuser);

		if($strIDuser){
			$sql_activity ="SELECT * FROM tbl_activity_log WHERE user_id IN ({$strIDuser})  AND action_id = 1 GROUP BY user_id  ORDER BY date_ts ";
			$qData_activity = $this->fetch($sql_activity,1);
			
			foreach($qData_activity as $key => $val){
				$loginTime[$val['user_id']]['login_date'] =  $val['date_time'];
			}
			
			$sql_socRank ="SELECT sr.id,sr.userid,sr.rank,mr.rank as desc_rank FROM social_rank sr LEFT JOIN axis_rank_table mr ON sr.rank = mr.id WHERE userid IN ({$strIDuser}) AND n_status = 1 ";			
			$qData_socRank = $this->fetch($sql_socRank,1);
			foreach($qData_socRank as $key => $val){
				$socRank[$val['userid']]['rank'] =  $val['rank'];
				$pangkat[$val['rank']]['pangkat'] =  $val['desc_rank'];
			}
		}
		
		foreach($data as $key => $v){
			if(array_key_exists($v['id'],$loginTime))$data[$key]['last_login_date'] = $loginTime[$v['id']]['login_date'];
			else $data[$key]['last_login_date'] = false;
			if(array_key_exists($v['id'],$socRank))$data[$key]['rank'] = $socRank[$v['id']]['rank'];
			else $data[$key]['rank'] = false;
			if(array_key_exists($data[$key]['rank'],$pangkat))$data[$key]['pangkat'] = $pangkat[$data[$key]['rank']]['pangkat'];
			else $data[$key]['pangkat'] = false;
		}
		
		$valRegFB = $this->fetch("SELECT count(register_by) as total_fb FROM social_member WHERE register_by='facebook' GROUP BY register_by");
		$valRegTwitter = $this->fetch("SELECT count(register_by) as total_twitter FROM social_member WHERE register_by='twitter' GROUP BY register_by");
		$valRegGplus = $this->fetch("SELECT count(register_by) as total_gplus FROM social_member WHERE register_by='gplus' GROUP BY register_by");
		$this->View->assign('total_fb',$valRegFB['total_fb']);
		$this->View->assign('total_twitter',$valRegTwitter['total_twitter']);
		$this->View->assign('total_gplus',$valRegGplus['total_gplus']);
		
		$this->View->assign('list',$data);
		$this->View->assign('time',$time);
		$this->View->assign('total',$total);
		$this->View->assign('search',$this->_g('search'));
		$this->View->assign('startdate',$this->_g('startdate'));
		$this->View->assign('enddate',$this->_g('enddate'));
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=axisuser&search={$this->_g('search')}&startdate={$this->_g('startdate')}&enddate={$this->_g('enddate')}"));	
		return $this->View->toString("application/admin/Axisuser/axisuser_list.html");
	}
	
	function Axisuser_add(){
		$username 		= $this->Request->getPost('username');
		$password 		= $this->Request->getPost('password');
		$email 			= $this->Request->getPost('email');
		$name 			= $this->Request->getPost('name');
		$last_name 		= $this->Request->getPost('last_name');
		$status 		= $this->Request->getPost('n_status');
		
		if( $username != '' && $password != '' && $email != '' && $name != ''){
			$salt = rand(1000,9999);
			$hash = sha1($password.$username.$salt);
			
			$id = mysql_insert_id();
			$qry = "INSERT INTO social_member (username,password,email,name,last_name,n_status,last_login,salt)
						VALUES ('{$username}','{$hash}','{$email}','{$name}','{$last_name}','{$status}',NOW(),'{$salt}')";
			if(!$this->query($qry)){
				$this->View->assign("msg","Add process failure");
				return $this->View->toString("application/admin/Axisuser/axisuser_new.html");
			}else{
				return $this->View->showMessage('Berhasil', "index.php?s=axisuser");
			}
		}else{
			$this->View->assign('msg','Error, please fill all field!');
		}
		return $this->View->toString("application/admin/Axisuser/axisuser_new.html");
	}
		
	function Axisuser_delete(){
		$id = $this->Request->getParam('id');
		if( !$this->query("UPDATE social_member SET img='',small_img='' WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=axisuser");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=axisuser");
		}
	}
	
	function excel_listuser(){
		$search = $this->Request->getParam('search');
		$filter = $search=='' ? "" : "AND ( name like '%{$search}%' OR nickname like '%{$search}%' OR email like '%{$search}%' OR username like '%{$search}%' OR last_name like '%{$search}%' )";
		$sql = "
			SELECT '' as no,id,name,last_name,email,phone_number,register_date,last_login,n_status,verified,login_count
			FROM social_member WHERE n_status<>3 {$filter} ORDER BY register_date DESC;
		";
		$r = $this->fetch($sql,1);
		$status = array(0=>"Pending",1=>"Staging",2=>"Production",3=>"Deleted");
		
		$no=1;
		foreach($r as $key => $val){
			$val['no'] = $no++;
			$val['n_status'] = $status[$val['n_status']];
			$val['verified'] = $val['verified']==0 ? "No HP belum verified" : "Sudah Verified";
			$data[] = $val;
		}
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Utility/PHPExcelWrapper.php";
		$excel = new PHPExcelWrapper();
		$excel->setGlobalBorder(true, 'allborders', '00000000');
		$excel->setHeader(array('No','User ID','Name','Last Name','Email','Phone Number','Register Date','Last Login','Status','Verified','Total Login'));
		$excel->getExcel($data,'list_User_Axis');
		exit;
	}
	
	function adddate($vardate,$added) {
		$data = explode("-", $vardate);
		$date = new DateTime();
		$date->setDate($data[0],$data[1],$data[2]);
		$date->modify("".$added."");
		$day= $date->format("Y-m-d");
		return $day;
	}
}