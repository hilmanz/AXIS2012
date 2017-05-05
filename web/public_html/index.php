<?php
	 
include_once "common.php";

/** DEVICE TRACKING **/
include_once "deviceTrack.php";
/** END **/
/** MOBILE REDIRECTION **/
include_once  $ENGINE_PATH."Utility/Mobile_Detect.php";
$detect = new Mobile_Detect();

if($detect->mobileGrade()=="C" && $detect->is('Bot') == false){
	header("Location: {$CONFIG['WAP_DOMAIN']}");
}

$fullsite=false;
if(strip_tags(intval(@$_GET['fullsite']))==1) {
	$fullsite = true;
	$_SESSION['fullsite'] = true;
}
if(array_key_exists('fullsite',$_SESSION)) $fullsite = $_SESSION['fullsite'];
if(!$fullsite){
	if ($detect->isMobile() && $detect->is('Bot') == false ) {
		// header("Location: {$CONFIG['MOBILE_SITE']}");
		$request_uri = substr(@$_SERVER['REQUEST_URI'],1);
		header("Location: {$CONFIG['MOBILE_SITE']}{$request_uri}");
	}
}

/** END **/
include_once $APP_PATH.APPLICATION."/App.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName(APPLICATION);
$logger->setDirectory($CONFIG['LOG_DIR']);
$app = new App();
if($LAUNCHING_DATE<time()){
	$app->main();
	print $app;
}else{
	/**
	 * {
						'day': 		12,
						'month': 	12,
						'year': 	2012,
						'hour': 	12,
						'min': 		12,
						'sec': 		12
					}
	 */
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
	$app->assign("assets_domain",$CONFIG['ASSETS_DOMAIN_WEB']);
	print $app->out(APPLICATION.'/countdown/countdown.html');
}
die();
?>
