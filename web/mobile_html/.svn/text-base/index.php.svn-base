<?php
	
include_once "common.php";

/** DEVICE TRACKING **/
	include_once "deviceTrack.php";
	/** END **/
	/** MOBILE REDIRECTION **/
		include_once  $ENGINE_PATH."Utility/Mobile_Detect.php";
		$detect = new Mobile_Detect();
		// pr($detect->isMobile());
	
				
		if ($detect->isMobile()==true && $detect->mobileGrade()=="C") {
			if($detect->is('MobileBot') == false){
				header("Location: {$CONFIG['WAP_DOMAIN']}");
			}
		}

		if(!preg_match('/preview.kanadigital/i',$CONFIG['BASE_DOMAIN_PATH'])){
			if($detect->isMobile()==false && $detect->mobileGrade()!="C"){
				if($detect->is('MobileBot') == false){
					header("Location: {$CONFIG['BASE_DOMAIN_PATH']}");
				}
			}
		}
	/** END **/

include_once "../com/mobile/App.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$thisMobile = true;
$logger = new Debugger();
$logger->setAppName(MOBILE_APPS);
$logger->setDirectory($CONFIG['LOG_DIR']);
$app = new App();
if(!preg_match('/preview.kanadigital/i',$CONFIG['BASE_DOMAIN_PATH'])){
if($LAUNCHING_DATE <time()){
	$app->main();
	print $app;
}else{
	$launchdate = array('day'=>intval(date("d",$LAUNCHING_DATE)),
						'month'=>intval(date("m",$LAUNCHING_DATE)),
						'year'=>intval(date("Y",$LAUNCHING_DATE)),
						'hour'=>intval(date("H",$LAUNCHING_DATE)),
						'min'=>intval(date("i",$LAUNCHING_DATE)),
						'sec'=>intval(date("s",$LAUNCHING_DATE))
						);
	$app->assign("launchdate",json_encode($launchdate));
	$app->assign("ts",time());
	$app->assign("launchts",$LAUNCHING_DATE);
	$app->assign("assets_domain",$CONFIG['BASE_DOMAIN_PATH']."assets/");
	//print $app->out(APPLICATION.'/countdown/countdown.html');
	 print $app->out(APPLICATION.'/countdown/splash-wap.html');
}
}else{
	$app->main();
	print $app;
}
die();
?>
