<?php
global $APP_PATH,$ENGINE_PATH;
require_once $APP_PATH . APPLICATION . "/helper/AccessControlHelper.php";
include_once $ENGINE_PATH."Utility/Mobile_Detect.php";
class App extends Application{
	
	var $_mainLayout=""; 
	var $user = array();
	var $ACL;
	var $userHelper;
	var $osDetect;

	function __construct(){
		parent::__construct();
		$this->setVar();
	
	}
	/**
	 * warning : do not put db query here.
	 */
	function setVar(){
		$this->ACL = new AccessControlHelper();
		if($this->isUserOnline()){
			$this->user = $this->getUserOnline();
			$this->userHelper = $this->useHelper('userHelper');
		}
	}

	function facebokConnect(){
			
			if(isset($this->session->getSession('facebook_session','facebook')->user)) {
				$this->assign('fbConnect',false);
				$this->assign('facebookButton','FB[Connected] ');
			}else {
				$this->facebookHelper = $this->useHelper('FacebookHelper');
				$this->assign('fbConnect',@$this->session->getSession('facebook_session','facebook')->urlConnect);
				$this->assign('facebookButton','FB[not connect]');
			}
	}
	
	function twitterConnect(){
			if(!isset($this->session->getSession('twitter_session','twitter')->user)){
				$this->twitterHelper = $this->useHelper('twitterHelper');
				
				if(isset($this->session->getSession('twitter_session','twitter')->loginPermission)){
					$this->twitterHelper->authorize();			
				}			
				if($this->twitterHelper->getUserLogin()) {

					$this->assign('twConnect',false);
					$this->assign('twConnectButton','Twitter[Connected]');
				}else {
					$this->twitterHelper->request_login_link();
					$this->assign('twConnect',@$this->session->getSession('twitter_session','twitter')->urlConnect);
					$this->assign('twConnectButton','Twitter[not connect]');
				}
			}
			
	}
	
	function gplusConnect(){
		$this->gplusHelper = $this->useHelper('GPlusHelper');
		if($this->gplusHelper->isLogin()){
			$this->assign('gplusConnect',false);
			$this->assign('gplusConnectButton','G+[connect]');
		}else{
			$connectUrl = $this->gplusHelper->getLoginUrl();
			$this->assign('gplusConnect',$connectUrl);
			$this->assign('gplusConnectButton','G+[not connect]');
		}
	}
	
	function loginWithFacebook(){
			
	}
	function loginWithTwitter(){
			
	}
	function loginWithGPlus(){
		
	}
	function loginWithNoAxis(){
		
	}
	function main(){
		global $CONFIG;
		global $FB;
		
		if($CONFIG['CLOSED_WEB']==true){
				sendRedirect($CONFIG['TEASER_DOMAIN']);
				die();
		}
		if($CONFIG['MAINTENANCE']==true){
			$this->assign('fbID',$FB['appID']);
			$this->assign('meta',$this->View->toString(APPLICATION . "/meta.html"));
			$this->assign('mainContent', $this->View->toString(APPLICATION . '/under-maintenance.html'));
			$this->mainLayout(APPLICATION . '/master.html');
		}else{
		
			//all url connect
			// $this->facebokConnect();
			$this->twitterConnect();
			$this->gplusConnect();
			
			switch($this->_g("loginType")){
				case "twitter":
					$this->loginWithTwitter();
				break;
				case "google":
					$this->loginWithGPlus();
				break;
				case "axis":
					$this->loginWithNoAxis();
				break;
				default:
					$this->loginWithFacebook();		
				break;
			}
		
		
		
			
				$str = $this->run();
				$this->afterFilter();
				
				//encrypt URL
				if($this->isUserOnline()) $this->assign('user',$this->user);
				$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);				
				$this->assign('meta',$this->View->toString(APPLICATION . "/mobile/meta.html"));
				
				//Mobile OS detection
				$this->osDetect = new Mobile_Detect;
				if($this->osDetect->isBlackBerryOS()){
					$osType = "BlackBerry";
				}else if($this->osDetect->isiOS()){
					$osType = "Apple";
				}else if($this->osDetect->isAndroidOS()){
					$osType = "Android";
				}else if(!$this->osDetect->isMobile()){
					$osType = "Desktop";
				}else{
					$osType = "Featured Phone";
				}
				
				$this->assign('isLogin',$this->isUserOnline());
				if($this->isUserOnline()) $this->assign('user',$this->user);
				$this->assign('mobileType',$osType);
				$this->assign('header',$this->View->toString(APPLICATION . "/mobile/header.html"));
				$this->assign('footer',$this->View->toString(APPLICATION . "/mobile/footer.html"));
				
				$this->assign('mainContent',$str);
				$this->beforeRender();
				$this->mainLayout(APPLICATION . '/mobile/master.html');
				
		}
	}
	
	function setWidgets($class=null,$path=null){
		GLOBAL $APP_PATH;
		if($class==null) return false;
			if( !is_file( $APP_PATH . MOBILE_APPS . '/widgets/'. $path . $class .'.php' ) ){
				if( is_file( '../templates/'. MOBILE_APPS . '/widgets/'. $path  . $class .'.html' ) ){
					return $this->View->toString(MOBILE_APPS.'/widgets/'.$path. $class .'.html');
				}
			}else{
				require_once $APP_PATH . MOBILE_APPS . '/widgets/'. $path. $class .'.php';
				$widgetsContent = new $class($this);
				return $widgetsContent->main();
			}
	}
	
	
	function useHelper($class=null,$path=null){
		GLOBAL $APP_PATH,$DEVELOPMENT_MODE;
		if($class==null) return false;
		if(file_exists($APP_PATH . MOBILE_APPS . '/helper/'. $path. $class .'.php')){
			require_once $APP_PATH . MOBILE_APPS . '/helper/'. $path. $class .'.php';
			$helper = new $class($this);
			return $helper;
		}else{
			if($DEVELOPMENT_MODE){
				print "please define : ".$APP_PATH . MOBILE_APPS . '/helper/'. $path. $class .'.php';
				die();
			}
		}
	}
	
	/*
	 *	Mengatur setiap paramater di alihkan ke class yang mengaturnya
	 *
	 *	Urutan paramater:
	 *	- page			(nama class) 
	 *	- act				(nama method)
	 *	- optional		(paramater selanjutnya optional, tergantung kebutuhan)
	 */
	function run(){
		global $APP_PATH,$CONFIG;
		
		//ini me-return variable $page dan $act
		if($this->Request->getParam("req")) $this->Request->decrypt_params($this->Request->getParam("req"));
		$page = $this->Request->getParam('page');
		$act = $this->Request->getParam('act');		
		if( $page != '' ){
			if( !is_file( $APP_PATH . APPLICATION . '/modules/'. $page . '.php' ) ){
				if( is_file( '../templates/'. APPLICATION . '/'. $page . '.html' ) ){
					return $this->View->toString(APPLICATION.'/'.$page.'.html');
				}else{
					sendRedirect("index.php");
					die();
				}
			}else{
				require_once 'modules/'. $page.'.php';
				$content = new $page();
				$content->beforeFilter();
				if( $act != '' ){
					if( method_exists($content, $act) )	return $content->$act();
					else return $content->main();
				}else return $content->main();
			}
		}else{
			require_once "modules/{$CONFIG['DEFAULT_MODULES']}";
			$content = new home();
			$content->beforeFilter();
			return $content->main();
		}
	}
	
	function birthday($birthday){
		$birth = explode(' ',$birthday);
		list($year,$month,$day) = explode("-",$birth[0]);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)
		  $year_diff--;
		return $year_diff;
	}
	
	function is_valid_email($email) {
	  $result = TRUE;
	  if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
		$result = FALSE;
	  }
	  return $result;
	}
	
	function is_email_available($email){
		//VALIDATION EMAIL TO DB (cari di table smac_registration,smac_agency & smac_user adakah yang sama?)
		$sql = "SELECT a.email FROM
						(
						SELECT r.agency_email AS email FROM smac_web.smac_registration r WHERE n_status IN ('0','1') 
						UNION
						SELECT agency_email AS email FROM smac_web.smac_agency 
						UNION
						SELECT email FROM smac_web.smac_user
						) a
						WHERE
						a.email='".mysql_escape_string(strtolower($email))."';";
		
		$this->open(0);
		$rs = $this->fetch($sql);
		$this->close();		
		if($rs['email'] != ''){
			return false;
		}
		
		return true;
		
	}
	
	function is_admin(){
	
		$sql = "SELECT count(*) as total 
			FROM tbl_front_admin
			WHERE
			user_id='".mysql_escape_string(intval($_SESSION['user_id']))."' 
			AND fb_id='".mysql_escape_string(intval($_SESSION['user_login_id']))."'
			LIMIT 1
			;";
		
		$this->open(0);
		$checkAdmin = $this->fetch($sql);
		$this->close();	
		// print_r($sql);			
		if($checkAdmin) {
		$is_admin = ($checkAdmin['total']>=1) ? true : false ;
		}else $is_admin = false;
		
		return $is_admin;
	}
	function objectToArray($object) {
		//print_r($object);exit;
		
		 if (is_object($object)) {
		    foreach ($object as $key => $value) {
		        $array[$key] = $value;
		    }
		}
		else {
		    $array = $object;
		}
		return $array;
		
	}
	
}
?>