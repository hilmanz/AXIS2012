<?php
class device_handlers extends App{
	
	
	
	function beforeFilter(){
		
		// $this->authenticate();
		$this->cdmHelper = $this->useHelper('cdmHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
		
	}
	
	function authenticate() {
		global $CONFIG;
		if ($_SERVER['PHP_AUTH_USER'] != $CONFIG['userpage'] || $_SERVER['PHP_AUTH_PW'] != $CONFIG['SERVICE_KEY'] ) { 
			header('WWW-Authenticate: Basic realm="Test Authentication System"');
			header('HTTP/1.0 401 Unauthorized');
			echo "You must enter a valid login ID and password to access this resource\n";
			exit;
		}
		
	}
	
	function main(){
		global $LOCALE;
		
	
		$this->View->assign('type',$LOCALE[$this->lid]['footnav']['bantuan']);
	
		// print_r($this);exit;
		$this->log('globalAction','admin access uploader data CMD');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/services/cdmuploader.html');
	}
	
	function saveDataFromUploader(){
		$data = $this->cdmHelper->saveDataFromUploader();
		if($data) pr('success send data');
		else pr('failed to send data');
		exit;
	
	}
	
	function saveDataFromCDM(){
		$data = $this->cdmHelper->saveDataFromCDM();
		if($data) pr('success send data');
		else pr('failed to send data');
		exit;
	
	}
}
?>