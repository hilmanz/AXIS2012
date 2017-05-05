<?php 
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Mobile_Detect.php";
class contentHelper {

	var $uid;

	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
	}
	
	function saveVote($fbid=null,$profile=null,$description=null){
		if($fbid==null) return false;
		if($profile==null) return false;
		if($description==null) return false;
		
		$pid = $this->apps->_g('pid');
		$description =  $description;
		$shareon = $this->apps->_p('shareon');
		$uid = $fbid;
		$email = $profile['email'];
		$name = $profile['name'];
		if($uid=='') return false;
		
		$udata = $this->saveUserData($uid,$email,$name);
		$alreadyVoteThisDay = $this->checkVote($uid,$pid);
		if($alreadyVoteThisDay) return false;
		
		$sql = "INSERT INTO axis_kakao_vote (pid,uid,description,shareon,created_date,n_status) VALUES ({$pid},'{$uid}','{$description}','{$shareon}',NOW(),1)";
		$rs = $this->apps->query($sql);
	
		if($this->apps->getLastInsertId()) {
			return true;
		} else {
			return false;
		}
	}
	
	function saveUserData($fbid=null,$email,$name){
		if($fbid==null) return false;
		$sql = "INSERT INTO social_member (fb_id,email,name,register_date) VALUES ('{$fbid}','{$email}','{$name}',NOW())";		
		$rs = $this->apps->query($sql);			
		if($this->apps->getLastInsertId()) return true;
		return false;
	}
	
	function checkVote($fbid=null,$pid=null){
		if($fbid==null) return false;
		if($pid==null) return false;
		$sql = "SELECT count(*) total FROM axis_kakao_vote WHERE  DATE(created_date)=DATE(NOW()) AND pid={$pid} AND uid='{$fbid}' LIMIT 10";
		$rs = $this->apps->fetch($sql);
		if($rs['total']>0) return true;
		else return false;
	}
	
	function getVote(){
		$sql = "SELECT count(*) total,pid FROM axis_kakao_vote GROUP BY pid ";		
		$rs = $this->apps->fetch($sql,1);
		if(!$rs) return false;
		foreach($rs as $val){
			$arrVote[$val['pid']] = $val['total'];		
		}
		return $arrVote;	
	}
	
	function getEmoticon($start=0, $limit=2){
		$id = intval($this->apps->_g('pid'));
		if($id==0) $qId = "";
		else $qId = " AND id = {$id} ";
		
		$sql = "SELECT count(*) total FROM axis_kakao_emoticon WHERE n_status = 1";		
		$rs = $this->apps->fetch($sql);
		
		if(!$rs) return false;
		$total= $rs['total'];
		$sql = "SELECT * FROM axis_kakao_emoticon WHERE n_status = 1 {$qId} ORDER BY  publish_date DESC LIMIT {$start},{$limit} ";		
		$rs = $this->apps->fetch($sql,1);
		
		if(!$rs) return false;
		
		$vData = $this->getVote();		
		foreach($rs as $key => $val){
			if($vData){
				if(array_key_exists($val['id'],$vData)) $rs[$key]['vote'] = $vData[$val['id']];
				else $rs[$key]['vote'] = 0;
			}else $rs[$key]['vote'] = 0;
		}
		$rs[0]['total'] = $total;
		return $rs;
	}
	
	function gallery($start=0, $limit=1){
		try{
			$fbid = $this->apps->facebookHelper->fb->getUser();
		}catch (Exception $e){
			$fbid = null;
		}
		
		$start = $this->apps->_g('st')=='' ? $start : $this->apps->_g('st');
		$id = intval($this->apps->_p('pid'));
		if($id==0) $qId = ""; 
		else $qId = " AND id = {$id} ";
		$sql = "SELECT count(*) total FROM axis_kakao_emoticon WHERE n_status = 1";		
		$rs = $this->apps->fetch($sql);
		if(!$rs) return false;
		$total= $rs['total'];
		$start = $start==$total ? $start-1 : $start;
		$sql = "SELECT * FROM axis_kakao_emoticon WHERE n_status = 1 {$qId} ORDER BY  publish_date DESC LIMIT {$start},{$limit} ";
		$rs = $this->apps->fetch($sql,1);
		
		if(!$rs) return false;
		$vData = $this->getVote();
		foreach($rs as $key => $val){
			if($vData){
				if(array_key_exists($val['id'],$vData)) $rs[$key]['vote'] = $vData[$val['id']];
				else $rs[$key]['vote'] = 0;
			}else $rs[$key]['vote'] = 0;
			$rs[$key]['total'] = $total;
			$rs[$key]['status_vote'] = $this->checkVote($fbid,$val['id']);
			$rs[$key]['prev'] = $start==0 ? 0 : $start-1;
			$rs[$key]['next'] = $start+1;
		}
		//$rs[0]['total'] = $total;
		//print_r($rs);
		return $rs;
	}
}

?>

