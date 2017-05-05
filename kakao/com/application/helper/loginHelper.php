<?php

class loginHelper extends Application{
	
	var $_mainLayout="";
	
	var $login = false;
	
	function __construct(){
		parent::__construct();	
		
		if( $this->session->get('user') ){
			
			$this->login = true;
		
		}
	
	}
	
	function checkLogin(){
		
		return $this->login;
	}
	
	function loginSession($mobile=false){
		$ok = false;
		
		if($this->Request->getPost('login')==1){
		
			if($this->goLogin()){
				$this->log('login','');
				$this->assign("msg","login-in.. please wait");
				$this->assign("link","index.php?page=axisLife");
				sendRedirect('index.php?page=axisLife');
				return $this->out(TEMPLATE_DOMAIN_WEB . '/message.html');
				
				die();
			}
			
			if(!$ok){
				$this->log('access_denied','');
				$this->assign("msg","ga boleh masuk.. coba connect ke social media dulu ya");
				$this->assign("link","index.php?page=login");
				sendRedirect('index.php?page=login');
				return $this->out(TEMPLATE_DOMAIN_WEB . '/message.html');
				die();
			}
		}
		if($mobile) return $this->out(TEMPLATE_DOMAIN_MOBILE.'/login.html');
		return $this->out(TEMPLATE_DOMAIN_WEB .'/login.html');
	}
	
	function goLogin(){
		global $logger, $APP_PATH;
		//check social media logon
		// if(!$this->checkSocialMediaSession()) return false;
		require $APP_PATH. APPLICATION ."/helper/socialMediaHelper.php";
		$smHelper = new socialMediaHelper($this);
		// pr($this->session->getSession('facebook_session','facebook'));exit;
		
		
		$username = trim($this->Request->getPost('username'));
		$password = trim($this->Request->getPost('password'));
		$phonenumber = trim($this->Request->getPost('phonenumber'));
		if(substr($phonenumber,1)=='0') $phonenumber = trim(substr($phonenumber,2,30));
		
		
		$sql = "SELECT * FROM social_member WHERE n_status=1 AND phone_number='{$phonenumber}' LIMIT 1";
		$rs = $this->fetch($sql);
		$logger->log($sql);
	

		$hash = sha1($password.$rs['phone_number'].$rs['salt']);
		//check password and phonumber , each field must be same of input value (higher security)
 		if($rs['phone_number']==$phonenumber && $rs['password']==$hash){
			$logger->log('can login');
			$id = $rs['id'];
			$this->add_stat_login($id);
			$this->setUniqueIDuser($phonenumber);
			//klo bisa login
				 $arrSocialMedia['facebook'] = false;
				 $arrSocialMedia['twitter'] = false;
				 $arrSocialMedia['gplus'] = false;
				 
				if(@isset($this->session->getSession('facebook_session','facebook')->user)) $arrSocialMedia['facebook'] = true;
				if(@isset($this->session->getSession('twitter_session','twitter')->user)) $arrSocialMedia['twitter'] = true;
				if(@isset($this->session->getSession('gplus_session','gplus')->user)) $arrSocialMedia['gplus'] = true;
					
				$logger->log('check unique ID');
								
					if(!$smHelper->checkUserSocialID($arrSocialMedia)){
						$logger->log('unique id and phone not found or match');
						$smHelper->addSocialMedia();	//klo ga sama nomor hape nya, bikin sebagai new user
					}else $logger->log('social id found');					
					
					//klo semua oke, baru boleh login ke axis life
					// exit;	
		
					$sql = "
					SELECT id,name,nickname,email,register_date,sex,birthday,phone_number,fb_id,twitter_id,gplus_id 
					FROM social_member 
					WHERE 
					n_status=1 AND 
					phone_number='".$phonenumber."'
					LIMIT 1";
					if($rs['phone_number']==$phonenumber && $rs['password']==$hash) $rs = $this->fetch($sql);
				
			if(!$rs) return false;
			$this->session->set('user',urlencode64(json_encode($rs)));
			$this->login = true;
			return true;
		}else {
			$logger->log('cannot login, password or phonenumber not exists');
			$logger->log($rs['phone_number']." ".$phonenumber." ".$rs['password']." ".$hash);
			return false;
		}
	
	}
	
	
	function add_stat_login($user_id){
	
	$this->open(0);
	$sql ="UPDATE social_member SET last_login=now(),login_count=login_count+1 WHERE id=".$user_id." LIMIT 1";
	$rs = $this->query($sql);
	$this->close();
	
	}
	
	function getProfile(){
		
		$user = json_decode(urldecode64($this->session->get('user')));
		
		return $user;
	
	}
	
	
	function checkSocialMediaSession(){
	
		if(@isset($this->session->getSession('facebook_session','facebook')->user)) $arrSoMed[] = true;
		else $arrSoMed[] = false;
		
		if(@isset($this->session->getSession('twitter_session','twitter')->user)) $arrSoMed[] = true;
		else $arrSoMed[] = false;
		
		if(@isset($this->session->getSession('gplus_session','gplus')->user)) $arrSoMed[] = true;
		else $arrSoMed[] = false;
		
		// pr($arrSoMed);exit;
		if(in_array(true,$arrSoMed)) return true;
		else return false;
	
	}
	
	
	function setUniqueIDuser($phonenumber=null){
		if($phonenumber==null) return false;
		$data['phonenumber'] = $phonenumber;
		$this->session->setSession('request_session','data',$data);
	
	}
	
	
}
