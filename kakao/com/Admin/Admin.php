<?php

class AdminConfig extends Admin{
	var $strHTML;
	var $View;
	function __construct(){
		parent::__construct();
		
		
	}
	
	/****** End-user FUNCTIONS ********************************************/
	
	/****** ADMIN FUNCTIONS ********************************************/
	function admin(){
		
		$msg="";
		if($this->Request->getPost("r")=="update_email"){
			
		}else if($this->Request->getParam("r")=="permission"){
			
			if($this->Request->isPostAvailable()){
		
				$msg = $this->applyPermissions();
			}
			return $this->showPermissionPage($msg);
		}else if($this->Request->getParam("r")=="users"){
			if($this->Request->getPost("do")=="add"){
				return $this->performCreateAccount();
			}else if($this->Request->getPost("do")=="update"){
				return $this->performUpdateAccount();
			}else if($this->Request->getParam("do")=="new"){
				return $this->showCreateAccountForm();
			}else if($this->Request->getParam("do")=="edit"){
				return $this->showEditAccountForm();
			}else if($this->Request->getParam("do")=="delete"){
				return $this->performDeleteuser();
			}else{
				return $this->showuserManagement();
			}
		}else if($this->Request->getRequest("r")=="dashboard"){
			return $this->DashboardConfig();
		}else if($this->Request->getParam("r")=="delete"){
			return $this->performDeleteuser();
		}else{
			return $this->View->toString("common/admin/config.html");
		}
	}
	function DashboardConfig(){
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Admin/DashboardManager.php";
		$dashboard = new DashboardManager(null);
		if($this->Request->getPost("do")=="save"){
			$dashboard->addItem($this->Request->getPost("name"),
								$this->Request->getPost("class"),
								$this->Request->getPost("invoker")
								,$this->Request->getPost("slot"),
								$this->Request->getPost("status"));
			$this->View->assign("msg","INFO : The addon has been added successfully !");
			
		}else if($this->Request->getParam("do")=="delete"){
			$this->View->assign("msg","INFO : The addon has been removed successfully !");
			$dashboard->removeItem($this->Request->getParam("id"));
		}
		$list = $dashboard->getConfiguration();
		$this->View->assign("list",$list);
		return $this->View->toString("common/admin/dashboard_config.html");
	}
	function performUpdateAccount(){
		$username = $this->Request->getPost("username");
		$password = $this->Request->getPost("password");
		$confirm = $this->Request->getPost("confirm");
		$userID = $this->Request->getPost("id");
		
		$name = $this->Request->getPost("name");
		$email = $this->Request->getPost("email");
		$position = $this->Request->getPost("position");
		$category = $this->Request->getPost("categoryid");
		$level = $this->Request->getPost("level");
		
		$flag=0;
		
		if($password!=$confirm){
			$rs['e2'] = "password doesn't match.";
			$flag=1;
		}
		if(strlen($password)<5){
			$rs['e2'] = "wrong password !";
			$flag=1;
		}
		if($password==''&&$confirm=='') $flag = 0;
		if($flag){
			$msg = "Update failed, wrong password format and/or the password doesn't match.";
		}else{
			$data['username'] = trim(stripslashes($username));
			if($password==''&&$confirm=='') $data['noupdatepass'] = true;
			else{
				$data['noupdatepass'] = false;
				$data['password'] = $password;
			}
			$data['email'] = $email;
			$data['position'] = $position;
			$data['level'] = $level;
			$data['category'] = $category;
			$data['name'] = $name;
			$data['userID'] = $userID;
			
			if($this->user->update($data)){
				$msg = "Update Success !";
			}else{
				$msg = "Update failed, wrong password format and/or the password doesn't match.";
			}
		}
		return $this->View->showMessage($msg,"?s=admin&r=users");
	}
	function performCreateAccount(){
		$username = $this->Request->getPost("username");
		$password = $this->Request->getPost("password");
		$confirm = $this->Request->getPost("confirm");
		$name = $this->Request->getPost("name");
		$email = $this->Request->getPost("email");
		$position = $this->Request->getPost("position");
		$category = $this->Request->getPost("categoryid");
		$level = $this->Request->getPost("level");
		
		$rs = $_POST;
		$flag=0;
		if(strlen($username)<5){
			$rs['e1'] = "username is in a wrong format!";
			$flag=1;
		}
		if(!eregi("^([a-zA-Z0-9]+)$",$username)){
			$rs['e1'] = "username is in a wrong format!";
			$flag=1;
		}
		if($password!=$confirm){
			$rs['e2'] = "password doesn't match.";
			$flag=1;
		}
		if(strlen($password)<5){
			$rs['e2'] = "wrong password !";
			$flag=1;
		}
		if($flag){
			return $this->showCreateAccountForm($rs);
		}else{
			$data['username'] = trim(stripslashes($username));
			$data['password'] = $password;
			$data['email'] = $email;
			$data['position'] = $position;
			$data['level'] = $level;
			$data['category'] = $category;
			$data['name'] = $name;
			
			if($this->user->add($data)){
				$msg = "New account has been created successfully !";
			}else{
				$msg = "Account creation is failed !";
			}
			return $this->View->showMessage($msg,"?s=admin&r=users");
		}
		
	}
	function showCreateAccountForm($rs=NULL){
		$level = $this->fetch("SELECT * FROM gm_level WHERE 1  ",1);
		$this->View->assign("level",$level);
	
		$category = $this->fetch("SELECT * FROM axis_news_content_category WHERE 1  ",1);
		$this->View->assign("category",$category);
		
		
		return $this->View->toString("common/admin/user_new.html");
	}
	function showEditAccountForm(){
		$level = $this->fetch("SELECT * FROM gm_level WHERE 1  ",1);
		$this->View->assign("level",$level);
	
		$category = $this->fetch("SELECT * FROM axis_news_content_category WHERE 1  ",1);
		$this->View->assign("category",$category);
		$userID = $this->Request->getParam("id");
		$rs = $this->fetch("SELECT * FROM gm_user WHERE userID='".$userID."' LIMIT 1");
		$this->View->assign("rs",$rs);
		
		return $this->View->toString("common/admin/user_edit.html");
	}
	function performDeleteuser(){
		if($this->user->delete($this->Request->getParam("id"))){
			$msg = "The account has been deleted successfully !";
		}else{
			$msg = "Cannot delete the account, please try again later !";
		}
		return $this->View->showMessage($msg,"?s=admin&r=users");
	}
	function applyPermissions(){
			$id = $this->Request->getPost("id");
			
			$this->query("DELETE FROM gm_permission WHERE userID='".$id."'");
			$msg = "Permission updated!";
			$permissions = $_POST;
			foreach($permissions as $name=>$val){
				if($val=="yes"){
					$this->query("INSERT gm_permission(userID,reqID)
									  VALUES('".$id."','".$name."')");
				}
			}
			return $msg;
	}
	function showPermissionPage($msg=""){
		
		$user = $this->user->getuserInfo($this->Request->getParam("id"));
		$this->View->assign("rs",$user);
		//request id list
	
		$list = $this->fetch("SELECT * FROM gm_module_registry ORDER BY requestID",1);
		
		// print_r($list);exit;
		for($i=0;$i<sizeof($list);$i++){
			//get permission
			$foo = $this->fetch("SELECT * FROM gm_permission 
								  WHERE userID='".$user['userID']."' 
								  AND reqID='".$list[$i]['requestID']."' 
								  LIMIT 1");
			if($foo['userID']==$user['userID']&&$foo['reqID']==$list[$i]['requestID']){
				$list[$i]['isAllowed'] = "1";
			}
		}
		$this->View->assign("list",$list);
		$this->View->assign("msg",$msg);
		return $this->View->toString("common/admin/permission.html");
	}
	function showuserManagement(){
		$start = $this->Request->getParam('st');
		if($start==NULL){$start=0;}
		$this->user->database = $this->database;
		$list = $this->user->getAllusers(base64_encode(date("YmdHi")),$start,30);
	
		for($i=0;$i<sizeof($list);$i++){
			$list[$i]['no'] = $start+$i+1;
		}
		$this->View->assign("list",$list);
		return $this->View->toString("common/admin/user_manage.html");
	}
		
}
?>