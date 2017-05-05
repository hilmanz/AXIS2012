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
	var $contentHelper;

	function __construct(){
		parent::__construct();
		$this->setVar();
	
	}
	/**
	 * warning : do not put db query here.
	 */
	function setVar(){
		global $CONFIG;
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;
		if($this->lid=='')$this->lid=1;
		
		$this->userpage = $CONFIG['userpage'];
		$this->assign('userpage',$this->userpage);
		
		$this->ACL = new AccessControlHelper();
		if($this->isUserOnline()){
			$this->user = $this->getUserOnline();
			$this->userHelper = $this->useHelper('userHelper');
		}
		if($this->Request->getParam("id")){
			$this->contentHelper = $this->useHelper('contentHelper');
		}
		
	}

	function facebokConnect(){
			global $CONFIG;
			if(isset($this->session->getSession('facebook_session','facebook')->user)) {
				$this->assign('fbConnect',@$this->session->getSession('facebook_session','facebook')->urlConnect);
				$this->assign('facebookButton','loginFacebookActive');
			}else {
				$this->facebookHelper = $this->useHelper('FacebookHelper');
				$this->assign('fbConnect',@$this->session->getSession('facebook_session','facebook')->urlConnect);
				$this->assign('facebookButton','');
							
			}
			
	}
	
	
	function twitterConnect(){
			global $CONFIG;
			
				$this->twitterHelper = $this->useHelper('twitterHelper');
				
				if(isset($this->session->getSession('twitter_session','twitter_permission')->loginPermission)){
					if($this->session->getSession('twitter_session','twitter_permission')->loginPermission==true)	$this->twitterHelper->authorize();		
				}else{
					$data['loginPermission'] = false;
					$this->session->setSession('twitter_session','twitter_permission',$data);
				}
				
				if($this->twitterHelper->getUserLogin()) {
				
					$this->assign('twConnect',$CONFIG['MOBILE_SITE']."logout.php");
					$this->assign('twConnectButton','loginTwitterActive');
				}else {
					
					$this->twitterHelper->request_login_link();
					$this->assign('twConnect',@$this->session->getSession('twitter_session','twitter')->urlConnect);
					$this->assign('twConnectButton','');
				}
			
	}
	
	function gplusConnect(){
		global $CONFIG;
			$this->gplusHelper = $this->useHelper('GPlusHelper');
		
			if($this->gplusHelper->isLogin()){
				$this->assign('gplusConnect',$CONFIG['MOBILE_SITE']."logout.php");
				$this->assign('gplusConnectButton','loginGplusActive');
			}else{
				$connectUrl = $this->gplusHelper->getLoginUrl();
				$this->assign('gplusConnect',$connectUrl);
				$this->assign('gplusConnectButton','');
			}
	}
	
	function loginWithFacebook(){
			
	}
	function loginWithTwitter(){
			$data['loginPermission'] = true;
			$this->session->setSession('twitter_session','twitter_permission',$data);
			
			
	}
	function loginWithGPlus(){
			$data['loginPermission'] = true;
			$this->session->setSession('gplus_session','gplus_permission',$data);
	}
	function loginWithNoAxis(){
		
	}
	function main(){
		global $CONFIG,$LOCALE,$SEO;
		global $FB;
		
		//fullsite
		if(strip_tags($this->_g('fullsite'))==true) {
			sendRedirect($CONFIG['BASE_DOMAIN_PATH']."?fullsite=1");
			die();
		}
		
		
		$this->assign('locale',$LOCALE[$this->lid]);
		
		if($CONFIG['CLOSED_WEB']==true){
				sendRedirect($CONFIG['TEASER_DOMAIN']);
				die();
		}
		if($CONFIG['MAINTENANCE']==true){
			$this->assign('fbID',$FB['appID']);
			$this->assign('meta',$this->View->toString(MOBILE_APPS . "/meta.html"));
			$this->assign('mainContent', $this->View->toString(MOBILE_APPS . '/under-maintenance.html'));
			$this->mainLayout(MOBILE_APPS . '/master.html');
		}else{
		
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
		
			
			//all url connect
			$this->facebokConnect();
			$this->twitterConnect();
			$this->gplusConnect();
			
			// pr($this->session->getSession('facebook_session','facebook'));
		
					
				$str = $this->run();
				$this->afterFilter();
				
				//encrypt URL
				$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
				$this->assign('webdomain', $CONFIG['BASE_DOMAIN_PATH']);
				$nexturl = urlencode64(serialize(array('basedomain'=>$CONFIG['MOBILE_SITE'],'nexturl' => $_SERVER['REQUEST_URI'])));
				$this->assign('nexturl',$nexturl);
				$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
				$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
				if($this->isUserOnline()) $this->assign('user',$this->user);
				$metaPage = "";
				if(intval($this->Request->getParam("id"))){
					$contentType = strip_tags($this->Request->getParam('act'));
					if($contentType =='detail') {
						$qData = $this->contentHelper->getDetailContent();
						$qData['content'] = strip_tags($qData['content']);
						$this->assign('metaTag',$qData);
						$metaPage = $this->Request->getParam("page");
						if($metaPage == 'myworld'){$webPage='content';}
						else{$webPage='promo';}
						$this->assign('metaURL',$CONFIG['BASE_DOMAIN_PATH'].$metaPage.'/detail/'.$qData['id']);
					}
					$this->assign('fbID',$FB['appID']);
				}
				if(array_key_exists(strip_tags($this->_g('page')),$SEO))$this->assign('currentpage',$SEO[strip_tags($this->_g('page'))]);
				if(array_key_exists(strip_tags($this->_g('act')),$SEO))$this->assign('currentType',$SEO[strip_tags($this->_g('act'))]);
				$this->assign('fbID',$FB['appID']);
				$currentPage = $this->Request->getParam("page");
				$this->assign('currentPage',$metaPage);
				$this->assign('assets_domain', $CONFIG['BASE_DOMAIN_PATH'].'assets/');				
				$this->assign('meta',$this->View->toString(APPLICATION . "/".MOBILE_APPS."/meta.html"));
				
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
				$this->assign('header',$this->View->toString(APPLICATION . "/".MOBILE_APPS."/header.html"));
				$this->assign('footer',$this->View->toString(APPLICATION . "/".MOBILE_APPS."/footer.html"));
				
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
					return $this->View->toString(APPLICATION.'/'.MOBILE_APPS.'/widgets/'.$path. $class .'.html');
				}
			}else{
				require_once $APP_PATH . APPLICATION .'/'.MOBILE_APPS. '/widgets/'. $path. $class .'.php';
				$widgetsContent = new $class($this);
				return $widgetsContent->main();
			}
	}
	
	
	function useHelper($class=null,$path=null){
		GLOBAL $APP_PATH,$DEVELOPMENT_MODE;
		if($class==null) return false;
		if(file_exists($APP_PATH . APPLICATION .'/helper/'. $path. $class .'.php')){
			require_once $APP_PATH . APPLICATION .'/helper/'. $path. $class .'.php';
			$helper = new $class($this);
			return $helper;
		}else{
			if($DEVELOPMENT_MODE){
				print "please define : ".$APP_PATH . APPLICATION . '/helper/'. $path. $class .'.php';
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
			if( !is_file( $APP_PATH . MOBILE_APPS . '/modules/'. $page . '.php' ) ){
				if( is_file( '../templates/'. APPLICATION .'/'.MOBILE_APPS. '/'. $page . '.html' ) ){
					return $this->View->toString(APPLICATION.'/'.MOBILE_APPS.'/'.$page.'.html');
				}else{
					sendRedirect($CONFIG['MOBILE_SITE']);
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