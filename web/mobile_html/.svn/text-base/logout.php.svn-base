<?php
include_once "common.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName('applogin');
$logger->setDirectory('../logs/');
$application = new Application();
$application->log('logout');

$application->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_MOBILE']);
$application->assign("msg","Logout.. please wait");
$application->assign("link","logout.php");
	if(isset($_SESSION['lid'])) $lid = $_SESSION['lid'];
	else $lid = 1;
	if($lid=='')$lid=1;
	$application->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
	$application->assign('nexturl',urlencode($_SERVER['REQUEST_URI']));
	$application->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
	$application->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
	$application->assign('locale',$LOCALE[$lid]);
// pr($application);
$application->assign('meta',$application->View->toString(TEMPLATE_DOMAIN_MOBILE . "/meta.html"));
$application->assign('header',$application->View->toString(TEMPLATE_DOMAIN_MOBILE . "/header.html"));
$application->assign('footer',$application->View->toString(TEMPLATE_DOMAIN_MOBILE . "/footer.html"));
$application->assign('mainContent',$application->View->toString(TEMPLATE_DOMAIN_MOBILE . '/message.html'));
session_destroy();
sendRedirect("{$CONFIG['MOBILE_SITE']}");
print $application->out(TEMPLATE_DOMAIN_MOBILE . '/master.html');

die();

?>