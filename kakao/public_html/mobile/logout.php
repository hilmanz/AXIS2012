<?php
include_once "common.php";
include_once $ENGINE_PATH."Utility/Debugger.php";
$logger = new Debugger();
$logger->setAppName('applogin');
$logger->setDirectory('../logs/');
$application = new Application();
$application->log('logout');
session_destroy();
$application->assign("msg","Logout.. please wait");
$application->assign("link","logout.php");
sendRedirect('login.php');
print $application->out(APPLICATION . '/message.html');
die();

?>