<?php
	
include_once "common.php";

/** DEVICE TRACKING **/
	include_once "deviceTrack.php";
	/** END **/
	/** MOBILE REDIRECTION **/
		include_once  $ENGINE_PATH."Utility/Mobile_Detect.php";
		$detect = new Mobile_Detect();
		//ini yang gw enable
		if ($detect->isMobile()==true && $detect->mobileGrade()!="C") {
			header("Location: {$CONFIG['MOBILE_SITE']}");
		}
		if($detect->isMobile()==false && $detect->mobileGrade()!="C"){
			header("Location: {$CONFIG['BASE_DOMAIN_PATH']}");
		}
		//end -- ini yang gw enable

	/** END **/
include_once $APP_PATH.WAP_APPS."/App.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName(WAP_APPS);
$logger->setDirectory($CONFIG['LOG_DIR']);
$app = new App();
if(preg_match('/preview.kanadigital/i',$CONFIG['BASE_DOMAIN_PATH'])){
	if($LAUNCHING_DATE<time()){
		$app->main();
		print $app;
	}else{
		$app->assign("assets_domain",$CONFIG['BASE_DOMAIN_PATH']."assets/");
		print $app->out(APPLICATION.'/countdown/splash-wap.html');
	}
	}else {
		$app->main();
		print $app;
}
die();
?>
