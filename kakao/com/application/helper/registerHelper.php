<?php

class registerHelper extends Application{
	
	var $_mainLayout="";
	
	var $login = false;
	
	function __construct(){
		global $logger;
		parent::__construct();
		$this->logger = $logger;
	
	}
	
	function registerPhase($mobile=false){
		$ok = false;
		
		$mobilePath = '';
		if($mobile) $mobilePath = '/mobile';
		
		if($this->Request->getPost('register')==1){
		
			$this->logger->log('can register');
			if($this->doRegister()){
				$this->log('register','');
				$this->assign("msg","success registration");
				$this->assign("link","index.php?page=login");
				sendRedirect('index.php?page=login');
				return $this->out(APPLICATION . '/message.html');
				die();
			}
				$this->logger->log('failed to register');
			if(!$ok){
				$this->assign("msg","failed to register");
				$this->assign("link","index.php?page=login");
				sendRedirect('index.php?page=login');
				return $this->out(APPLICATION . '/message.html');
				die();
			}
		}
		$this->logger->log('can not register');
		return $this->out(APPLICATION . $mobilePath .'/register.html');
	}
	
	function doRegister(){
		global $CONFIG;
		$this->logger->log('do register');
		$gplus_id = @$this->session->getSession('gplus_session','gplus')->user;
		$twitter_id = @$this->session->getSession('twitter_session','twitter')->user;
		$fbid = @$this->session->getSession('facebook_session','facebook')->user;
		
		
		$name = $this->Request->getPost('name');
	
		
		$phonenumber = trim($this->Request->getPost('phonenumber'));
		$password = trim($this->Request->getPost('password'));
		$repassword = trim($this->Request->getPost('repassword'));
		if(substr($phonenumber,1)=='0') $phonenumber = trim(substr($phonenumber,2,30));
		$email = trim($this->Request->getPost('email'));
		
		if($name==''||$name==null){
			$this->logger->log('name is null');
			return false;
		}
		if($password!=$repassword) {
			$this->logger->log('pass and re pass not match');
			return false;
		}
			
		$hashPass = sha1($password.$phonenumber.$CONFIG['salt']);
		$sql = "
			INSERT INTO social_member (fb_id,twitter_id,gplus_id,phone_number,password,email,register_date,salt,n_status,name) 
			VALUES ('{$fbid}','{$twitter_id}','{$gplus_id}','{$phonenumber}','{$hashPass}','{$email}',NOW(),'{$CONFIG['salt']}',1,'{$name}')
		";
		$rs = $this->query($sql);
		$this->logger->log($sql);
	
		
 		if($rs)return true;
		else return false;
	
	}
	
	
	
	
}
