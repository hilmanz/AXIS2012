<?php
class activityReportHelper{
		
	var $userID = null;
		
	function __construct($apps){
		$this->apps = $apps;		
	}
	
	function log($param=NULL,$id=NULL,$expLog=FALSE){
		$user = $this->apps->getUserOnline();
		if($user) $this->userID = $user->id;
		if($this->userID==null) return false;
		if($param!=NULL){
			$actionID=0;
			$userID = $this->userID;
			$actionValue = NULL;
			
			$sql ="SELECT id,point FROM tbl_activity_actions WHERE activityName = '".$param."' ";
		
			$qData = $this->apps->fetch($sql);

									
			
			if($qData) 	$actionID = $qData['id'];
			
			$score=$qData['point'];			
			
			
			$qData=NULL;
			if($id!=NULL) $actionValue = $id;
				
			
			$sql = "INSERT IGNORE INTO tbl_activity_log 
					(id,user_id,date_ts,date_time,action_id,action_value) 
					VALUES 
					(NULL,".$userID.",".strtotime(date('Y-m-d H:i:s')).",'".date('Y-m-d H:i:s')."',".$actionID.",'".$actionValue."')
					";
			
		
			//activity log : id 	user_id 	date_ts 	date_time 	action_id 	action_value
			if($userID!=0  && $actionID!=0 ){
		
			$this->apps->query($sql);

			}
		
		}
		
		if($expLog==TRUE){
	
		
		
		$actScore = $score;
		if($actScore==0)	return false;	
		$sql = "
		INSERT  IGNORE INTO tbl_exp_point 
		(id,user_id,date_time_ts,date_time,activity_id,score) 
		VALUES 
		(NULL,".$userID.",".strtotime(date('Y-m-d H:i:s')).",'".date('Y-m-d H:i:s')."',".$actionID.",".intval($actScore).")
		";
	
		if($userID!=0  && $actionID!=0 ){

		$this->apps->query($sql);

		
		}
		}
		
		
		
	}
	
	
	function activityTime(){
		$userID = $this->userID;
		$countTime =0;
		$sql = "
		SELECT login_count FROM kana_member 
		WHERE 
		id = ".$userID." LIMIT 1";
		$this->apps->open();
		$qData = $this->apps->fetch($sql);
		$this->apps->close();
		$token_this_day = sha1($userID.$qData['login_count'].date('Ymd'));
		$qData = NULL;
		if($userID!=''){
		$sql = "
		SELECT ping_time_ts FROM tbl_activity_time 
		WHERE 
		user_id = ".$userID." and 
		session_token='".$token_this_day."' 
		ORDER BY ping_time_ts DESC LIMIT 1";
		$this->apps->open();
		$qData = $this->apps->fetch($sql);
		$this->apps->close();
		if($qData){
		$countTime = intval(strtotime(date('Y-m-d H:i:s'))) - $qData['ping_time_ts'];
		
		}else  $countTime = 15;
		
		
		// print_r($sql);
		$qData = NULL;
		if( $countTime >= 15){
		
		//activity time : id 	user_id 	ping_time 	ping_time_ts 	session_token a unique session token
		$sql = "
		INSERT INTO tbl_activity_time 
		(id, user_id,ping_time,ping_time_ts,session_token) 
		VALUES 
		(NULL,".$userID.",'".date('Y-m-d H:i:s')."',".strtotime(date('Y-m-d H:i:s')).",'".$token_this_day."')
		";
		// echo $sql;
		// echo $sql;exit;
	
		$this->apps->query($sql);

		}
		}
		
	}
	
	
	function promo_ref($regID,$refID){
	//activity time : id 	user_id 	ping_time 	ping_time_ts 	session_token a unique session token
		$sql = "
		INSERT INTO referral 
		(refID, regID) 
		VALUES 
		('{$refID}',{$regID})
		";
		// echo $sql;
		// echo $sql;exit;

		$this->apps->query($sql);
	
	
	}
	
	
}
?>
