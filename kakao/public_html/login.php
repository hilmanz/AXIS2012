<?php
include_once "common.php";
include_once $APP_PATH. HELPER_DOMAIN_WEB ."loginHelper.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName('applogin');
$logger->setDirectory('../logs/');
$app = new loginHelper();
$app->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
print $app->loginSession();

?>