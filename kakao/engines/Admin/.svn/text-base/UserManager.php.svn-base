<?php
class UserManager extends SQLData{
	var $userID;
	function UserManager(){
		parent::SQLData();
		$this->force_connect(true);
		
	}
	function add($data){
		$enc_key = md5(base64_encode($data['username'].md5($data['password'])));
		$password = md5($data['password']);
	
		$sql ="INSERT INTO gm_user(name,email,position,level,username,password,enc_key)
					  VALUES('".$data['name']."','".$data['email']."','".$data['position']."','".$data['level']."','".$data['username']."','".$password."','".$enc_key."')";
		$rs = $this->query($sql);
		// pr($sql);exit;
		$last_id = $this->getLastInsertId();
		if($last_id){
			$this->query("
			INSERT INTO gm_specified_role (level ,	aid ,	type ,	category ,	n_status )
			VALUES ('".$data['level']."',{$last_id},2,'".$data['category']."',1)
			");
		}
		return $rs;
	}
	function delete($userID){

		$f = $this->query("DELETE FROM gm_user WHERE userID='".$userID."'");

		return $f;
	}
	function update($data){
		if(!$data['noupdatepass']){
			$enc_key = md5(base64_encode($data['username'].md5($data['password'])));
			$password = md5($data['password']);
			$qUpdatePass = " password='".$password."',  enc_key='".$enc_key."' , ";
		}
		else  $qUpdatePass ="";
		$f = $this->query("UPDATE gm_user SET username='".$data['username']."', 
							name='".$data['name']."', position='".$data['position']."', 
							{$qUpdatePass} 
							email='".$data['email']."', level='".$data['level']."' 						 
						   WHERE userID='".$data['userID']."'");
		if($f){
			$this->query("
			INSERT INTO gm_specified_role (level ,	aid ,	type ,	category ,	n_status )
			VALUES ('".$data['level']."',{$data['userID']},2,'".$data['category']."',1)
			");
		
		}
		return $f;
	}
	function getAllUsers($AC,$start,$total=30){
		
		if($AC==base64_encode(date("YmdHi"))){
	
			
			$rs = $this->fetch("SELECT * FROM gm_user ORDER BY userID LIMIT ".$start.",".$total,1);
		
			
			return $rs;
		}else{
			
			return false;
		}
	}
	function getUserInfo($userID){
		if(strlen(stripslashes($userID))>0){
			return $this->fetch("SELECT * FROM gm_user WHERE userID='".$userID."' LIMIT 1");
		}
	}
	function check($username,$password){
		$enc_key = md5(base64_encode($username.md5($password)));
		$password = md5($password);
		
		// $this->userID = 1;
		// return true;

		$rs = $this->fetch("SELECT userID,username,password,enc_key FROM gm_user
							WHERE username='".mysql_escape_string($username)."' 
							AND password='".$password."'");
		
		if($rs['username'] == $username && $rs['password'] == $password && $rs['enc_key'] = $enc_key){
			$this->userID = $rs['userID'];

			return true;
		}else{
			print mysql_error();
		}

	}
}
?>