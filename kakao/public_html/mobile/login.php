<?php
include_once "common.php";
include_once $APP_PATH. APPLICATION ."/helper/loginHelper.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName('applogin');
$logger->setDirectory('../logs/');
$app = new loginHelper();
$app->assign('assets_domain', $CONFIG['ASSETS_DOMAIN']);
print $app->loginSession(true);

?>