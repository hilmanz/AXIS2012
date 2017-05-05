<?php
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/facebook/facebook.php";
class FacebookHelper {
	var $fb;
	var $user_id;
	var $me;
	var $_access_token;
	
	function __construct($apps=null){
		$this->apps = $apps;
		$this->init();
		
	}
	
	function init(){
		global $FB;
			
				$this->fb = new Facebook(array(
				  'appId'  => $FB['appID'],
				  'secret' => $FB['appSecret'],
				));
		
			// pr($this->fb->getUser());
			if($this->fb->getUser()){
				try{
					$data['ac'] = $this->fb->getAccessToken();
					$data['user'] =$this->fb->getUser();
					$data['userProfile']= $this->fb->api('/me');
					$data['urlConnect'] =$this->fb->getLogoutUrl();
					$this->apps->session->setSession('facebook_session','facebook',$data);
				}catch (Exception $e){
					$params = array('scope' => 'email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream');
					$data['urlConnect'] =$this->fb->getLoginUrl($params);
					$this->apps->session->setSession('facebook_session','facebook',$data);
				}		
			}else {
				$params = array('scope' => 'email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream');
				$data['urlConnect'] =$this->fb->getLoginUrl($params);
				$this->apps->session->setSession('facebook_session','facebook',$data);
			}
		
	}
	
	
	
	
}
?>