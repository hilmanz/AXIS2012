<?php
session_start();

include_once "../engines/Gummy.php";

include_once "../engines/functions.php";

include_once "../com/Application.php";

$MAIN_TEMPLATE = "sample/default.html";
/**
 * profiler
 */
if($CONFIG['PROFILER']){
	include_once "../engines/Utility/Debugger.php";
	$profiler = new Debugger();
	$profiler->setAppName("profiler");
	$profiler->setDirectory($CONFIG['LOG_DIR']);
	$profiler->info("FROM : {$_SERVER['REQUEST_URI']}\n--------------------------------------------------------------------------------");
	$profiler->info("\n--------------------------------------------------------------------------------\n");
}
?>
