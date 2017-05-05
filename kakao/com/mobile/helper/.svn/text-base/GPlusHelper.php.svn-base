<?php
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/gplus/apiClient.php";
include_once $ENGINE_PATH."Utility/gplus/contrib/apiPlusService.php";
include_once $ENGINE_PATH."Utility/gplus/contrib/apiOauth2Service.php";
class GPlusHelper {
	var $me;
	var $_access_token;
	var $client;
	var $plus;
	var $registered = FALSE;
	public function __construct($apps=null){
		$this->apps = $apps;
		
	}
	public function init(){
		
		global $GPLUS;
		$this->client = new apiClient();
		$this->client->setApplicationName('Google+ PHP Starter Application');
		// Visit https://code.google.com/apis/console?api=plus to generate your
		// client id, client secret, and to register your redirect uri.
		$this->client->setClientId($GPLUS['client_id']);
		$this->client->setClientSecret($GPLUS['client_secret']);
		$this->client->setRedirectUri($GPLUS['redirect_url']);
		$this->client->setDeveloperKey($GPLUS['developer_key']);
		$this->client->setScopes(array("https://www.googleapis.com/auth/plus.me","https://www.googleapis.com/auth/userinfo.profile","https://www.googleapis.com/auth/userinfo.email"));
		$this->plus = new apiPlusService($this->client);
		$this->initSession();
			
	}
	private function initSession(){
		if(isset($this->apps->session->getSession('gplus_session','gplus_permission')->loginPermission)){
			global $CONFIG;
					//check if the user has been redirected back from google+ login form.
				if($this->apps->session->getSession('gplus_session','gplus_permission')->loginPermission==true) {
					if(!$this->apps->_g('state')){
						if ($this->apps->_g('code')) {
							try{
								$this->client->authenticate();
								$data['token'] = $this->client->getAccessToken();
								$this->apps->session->setSession('gplus_session','gplus_token',$data);
								
							}catch (Exception $e){
									pr('google authenticate and access token failed');
									sendRedirect($CONFIG['BASE_DOMAIN']);
									exit;										
							}
							$data['loginPermission'] = false;
							$this->apps->session->setSession('gplus_session','gplus_permission',$data);							
							sendRedirect($CONFIG['BASE_DOMAIN']);
							exit;
							// header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
						}else{
							$data['token'] = false;
							$this->apps->session->setSession('gplus_session','gplus_token',$data);
						}
					}
				}else{
					$this->getAuthorizeUser();
				}
			
			}
			
			$data['loginPermission'] = false;
			$this->apps->session->setSession('gplus_session','gplus_permission',$data);
			return false;
			
			
			
		
		//-->
	}
	
	function getAuthorizeUser(){
		global $CONFIG;
		
		if (@isset($this->apps->session->getSession('gplus_session','gplus_token')->token)){
			
			if (!$this->apps->session->getSession('gplus_session','gplus_token')->token) return false;
			try{
				$this->client->setAccessToken($this->apps->session->getSession('gplus_session','gplus_token')->token);
				}catch (Exception $e){
				pr('google set access token failed');
				sendRedirect($CONFIG['BASE_DOMAIN']);
				exit;					
			}		
			
			//update me
			
			if(@!isset($this->apps->session->getSession('gplus_session','gplus')->userProfile)){
				$oauth2 = new apiOauth2Service($this->client);
				
				try{
				$this->me = $oauth2->userinfo->get();
				
				// $this->me =  $this->plus->people->get('me');
			
				unset($oauth2);
				$data['userProfile'] = $this->me;
				$data['login'] = true;
				$data['user'] = $this->me['id'];
				$this->apps->session->setSession('gplus_session','gplus',$data);
				$this->sync_gplus();
				$data['loginPermission'] = false;
				$this->apps->session->setSession('gplus_session','gplus_permission',$data);
					
				return true;
				}catch (Exception $e){
					pr('google failed oauth service ');
					// sendRedirect($CONFIG['BASE_DOMAIN']);
					exit;	
				}
			}
		}
		return false;
	
	}
	
	public function isLogin(){
		$this->init();
		if(@$this->client->getAccessToken()){
			return true;
		}else return false;
	}
	public function getLoginUrl(){
		$this->init();
		return $this->client->createAuthUrl();
	}
	/**
	 * @todo
	 * add functionality to synchronize / integrate the google+ id into axis's database
	 */
	public function sync_gplus(){
		
		$this->registered = false;
	}
	public function is_registered(){
		return $this->registered;
	}
}
?>