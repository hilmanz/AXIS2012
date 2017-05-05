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
		return false;
		
		$pid = $this->apps->_p('pid');
		$description =  $description;
		$shareon = $this->apps->_p('shareon');
		$uid = $fbid;
		$email = $profile['email'];
		$name = $profile['name'];
		if($uid=='') return false;
		
		$udata = $this->saveUserData($uid,$email,$name);
		$alreadyVoteThisDay = $this->checkVote($uid,$pid);
		if($alreadyVoteThisDay) return false;
		
		$sql = "INSERT INTO axis_kakao_vote (pid,uid,description,shareon,created_date,n_status) 
		VALUES ({$pid},'{$uid}','{$description}','{$shareon}',NOW(),1) 
		";
		$rs = $this->apps->query($sql);
	
		if($this->apps->getLastInsertId()) {
	
	 	return true;
		}else{
		return false;
		}
	}
	
	function saveUserData($fbid=null,$email,$name){
			if($fbid==null) return false;
			$sql = "INSERT INTO social_member (fb_id,email,name,register_date) 
			VALUES ('{$fbid}','{$email}','{$name}',NOW()) 
			";
		
			$rs = $this->apps->query($sql);
			
			if($this->apps->getLastInsertId()) return true;
			return false;
	}
	
	function checkVote($fbid=null,$pid=null){
		if($fbid==null) return false;
		if($pid==null) return false;
		$sql = "SELECT count(*) total FROM axis_kakao_vote WHERE  DATE(created_date)=DATE(NOW()) AND pid={$pid} AND uid='{$fbid}' LIMIT 10";
		// pr($sql);exit;
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
	function emotcheckvote($fbid=null,$pid=null){
		if($fbid==null) return false;
		if($pid==null) return false;
		$sql = "SELECT pid,count(pid) total FROM axis_kakao_vote WHERE  DATE(created_date)=DATE(NOW()) AND pid IN ({$pid}) AND uid='{$fbid}'  GROUP BY pid";
		// pr($sql);exit;
		$rs = $this->apps->fetch($sql,1);
		if(!$rs) return false;
		foreach($rs as $val){
			if($val['total']>0)$arrData[$val['pid']] = true;
			else $arrData[$val['pid']] = false;
		}
		if(!$arrData) return false;
		
		return $arrData;
	
	}
	
	function getEmoticon($start=0, $limit=2){
		$id = intval($this->apps->_p('pid'));
		if($id==0) $qId = "";
		else $qId = " AND id = {$id} ";
		
		$sql = "SELECT count(*) total FROM axis_kakao_emoticon WHERE n_status = 1";
		
		$rs = $this->apps->fetch($sql);
		if(!$rs) return false;
		$total= $rs['total'];
		$sql = "SELECT * FROM axis_kakao_emoticon WHERE n_status = 1 {$qId} ORDER BY  publish_date DESC LIMIT {$start},{$limit} ";
		
		$rs = $this->apps->fetch($sql,1);
			
		if(!$rs) return false;
		
		
		try{
			$profile = $this->apps->facebookHelper->fb->api('/me');
		}catch (Exception $e){
			$profile = null;
		}
		foreach($rs as $val){
			$arrPid[] = $val['id'];
		}
		$strPid = implode(',',$arrPid);
		
		$alreadyVoteThisDay = false;
		if($profile!=null) $alreadyVoteThisDay = $this->emotcheckvote($profile['id'],$strPid);
				
		$vData = $this->getVote();
		
		foreach($rs as $key => $val){
			if($vData){
				if(array_key_exists($val['id'],$vData)) $rs[$key]['vote'] = $vData[$val['id']];
				else $rs[$key]['vote'] = 0;
			}else $rs[$key]['vote'] = 0;
			if($alreadyVoteThisDay) {
				if(array_key_exists($val['id'],$alreadyVoteThisDay)) $rs[$key]['hasvote'] = $alreadyVoteThisDay[$val['id']];
				else $rs[$key]['hasvote'] = false;
			}else $rs[$key]['hasvote'] = false;
		}
		$rs[0]['total'] = $total;
		return $rs;
	}
	
}	

?>

