<?php
/**
 * @author duf
 *
 */
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Twitter/tmhOAuth.php";
include_once $ENGINE_PATH."Utility/Twitter/tmhUtilities.php";

class twitterHelper {

	var $tmhOAuth;
	var $oauth;
		
	function __construct($apps=null){
		$this->apps = $apps;
		
	}
	
	function init(){
		global $TWITTER;
		
		$this->tmhOAuth = new tmhOAuth(array(
							  'consumer_key'    => $TWITTER['CONSUMER_KEY'],
							  'consumer_secret' =>  $TWITTER['CONSUMER_SECRET']
							));

	}
	
	function authorize(){
		$this->init();
		
		$request_code = unserialize(urldecode64(@$this->apps->session->getSession('twitter_session','twitter')->c));
	
		$this->tmhOAuth->config['user_token']  = $request_code['oauth_token'];
		$this->tmhOAuth->config['user_secret'] = $request_code['oauth_token_secret'];
		// pr($request_code);
		$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/access_token', ''), 
										array(
										'oauth_verifier' => $this->apps->Request->getParam('oauth_verifier')
									  	)
	  	);
		
		if ($code == 200) {
			$access_token = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']);
			$data['twitter_id'] = $access_token['screen_name'];
			$data['token']= $access_token['oauth_token'];
			$data['secret'] = $access_token['oauth_token_secret'];
			$data['user'] = $access_token['screen_name'];
			$data['userProfile'] = $access_token;
			$data['login'] = true;
			$this->apps->session->setSession('twitter_session','twitter',$data);
			$permission['loginPermission'] = false;
			$this->apps->session->setSession('twitter_session','twitter_permission',$permission);
		}
		return false;
	}
	
	function request_login_link(){
		global $TWITTER;
		$this->init();
   		$callback = isset($_REQUEST['oob']) ? 'oob' : $TWITTER['LOGIN_CALLBACK'];
   		$params = array(
    		'oauth_callback'=> $callback,
   			'x_auth_access_type'=>'write'
  		);
		$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/request_token', ''), $params);
		
	  	if ($code == 200) {
		  //berhasil dapet access token
	    	$oauth = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']);
	    	$data['c'] = urlencode64(serialize($oauth));
		   	$method = 'authenticate';
	    	$force  = '';
	    	$authurl = $this->tmhOAuth->url("oauth/{$method}", '') .  "?oauth_token={$oauth['oauth_token']}{$force}";
	    	$data['urlConnect'] = $authurl;
			$data['login'] = false;
			$this->apps->session->setSession('twitter_session','twitter',$data);
	  	} else {
	    	return false;
	  	}
	}

	function remove_tweet(){
	
		if($twitter['token']!=null && $twitter['secret']!=null){
			$this->tmhOAuth->config['user_token']  = $twitter['token'];
			$this->tmhOAuth->config['user_secret'] = $twitter['secret'];
			$id = $this->apps->Request->getParam("id");
			if(strlen($id)>8){
				$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url("1/statuses/destroy/{$id}"));
				if($code==200){
					//flag deleted
					//$this->flag_deleted_tweet($this->user_id,$twitter['twitter_id'],$id);
					return false; //the tweet has been deleted successfully'
				}else{
					return false ;//tweet not found
				}
			}else{
				return  false; //Cannot remove tweet. u need to specify the tweet id
			}
		}
		return  false; //unauthorized access
	}
	
	function update_tweet($update=null){
		$this->init();
		$request_code = $this->apps->session->getSession('twitter_session','twitter')->userProfile;
				
		$this->tmhOAuth->config['user_token']  = $request_code->oauth_token;
		$this->tmhOAuth->config['user_secret'] = $request_code->oauth_token_secret;

		$params = array('status' => str_replace("\\\\\\", "", $update));
		$updateStatus = $this->tmhOAuth->request('POST', $this->tmhOAuth->url("1.1/statuses/update"), $params);
		if($updateStatus == 200){
			echo "Success";exit;
		}else{
			echo "Updating twitter status is failed, please try again.";exit;
		}
		
	}
	
	function getUserLogin(){
		return @$this->apps->session->getSession('twitter_session','twitter')->login;
	}
	
}
?>