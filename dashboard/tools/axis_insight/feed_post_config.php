<?php
define("DATABASE_HOST","localhost");
//define("DATABASE_HOST","119.81.1.130");
define("DATABASE_USER","root");
define("DATABASE_PASSWORD","coppermine");
define("APP_ID","181586055282513");
define("APP_SECRET","d22971d06613820427e4e44cdfe1d67b");
define("CANVAS_URL","http://preview.kanadigital.com/axis2012-dashboard/tools/axis_insight/");
//define("CANVAS_URL","http://preview.kanadigital.com/axis2012-dashboard/tools/axis_insight/");
define("FACEBOOK_PAGE_ID","186172338083633");
define("SINCE",mktime(0,0,0,date("n"),date("d")-1,date("Y")));
define("UNTIL",mktime(23,59,59,date("n"),date("d")-1,date("Y")));

//define("SINCE",strtotime("2012-07-23"));
//define("UNTIL",strtotime("2012-08-10"));
//
date_default_timezone_set("Asia/Jakarta");

$con  =  mysql_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD);
if($con){
    mysql_select_db("axis_report_2012");
}else{
    echo "CANNOT CONNECT TO DB!";
}

	
	// DB CONNECTION PARAMETER
	
//	$app_id = "341251225961082"; // => set your app id
//	$app_secret = "be06c3d7b3f270e412e4e492f71a0c12"; //=> set your app secret
//	$canvas_url = "http://dashboard.tangkapberkahaxis.com/axis_insight/";
//	$FACEBOOK_PAGE_ID = "186172338083633";
	
	//Global Settings
	
	// SETTING PARAMETER
//	$since = strtotime("2012-07-23");
//	$until = time();
//	$proID = 10;
	// SETTING PARAMETER
	
	
	
?>
