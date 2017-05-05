<?php
@include_once "locale.inc.php";
@include_once "locale_corporate.inc.php";
@include_once "seo_name.php";

$CONFIG['LOG_DIR'] = "../logs/";
$GLOBAL_PATH = "../";
$APP_PATH = "../com/";
$ENGINE_PATH = "../engines/";
$WEBROOT = "../public_html/";

error_reporting(E_ALL);
//set aplikasi yang digunakan
define('APPLICATION','application');
define('COORPORATE_APPS','coorporate_apps');
define('MOBILE_APPS','mobile');
define('WAP_APPS','wap_apps'); //new

define('WIDGET_DOMAIN_WEB',APPLICATION."/widgets/");
define('WIDGET_DOMAIN_COORPORATE',COORPORATE_APPS."/widgets/");
define('WIDGET_DOMAIN_MOBILE',MOBILE_APPS."/widgets/");
define('WIDGET_DOMAIN_WAP',WAP_APPS."/widgets/"); //new


define('HELPER_DOMAIN_WEB',APPLICATION."/helper/");
define('HELPER_DOMAIN_COORPORATE',COORPORATE_APPS."/helper/");
define('HELPER_DOMAIN_MOBILE',MOBILE_APPS."/helper/");
define('HELPER_DOMAIN_WAP',WAP_APPS."/helper/"); //new


define('MODULES_DOMAIN_WEB',$APP_PATH.APPLICATION."/modules/");
define('MODULES_DOMAIN_COORPORATE',$APP_PATH.COORPORATE_APPS."/modules/");
define('MODULES_DOMAIN_MOBILE',$APP_PATH.MOBILE_APPS."/modules/");
define('MODULES_DOMAIN_WAP',$APP_PATH.WAP_APPS."/modules/"); //new


define('TEMPLATE_DOMAIN_WEB',APPLICATION."/axisweb/");
define('TEMPLATE_DOMAIN_COORPORATE',APPLICATION."/coorporate/");
define('TEMPLATE_DOMAIN_MOBILE',APPLICATION."/mobile/");
define('TEMPLATE_DOMAIN_WAP',APPLICATION."/wap/"); //new


define('SCHEMA_DATA','codebook');
//set TRUE jika dalam local
$local = true;
$DEVELOPMENT_MODE = true;
$CONFIG['DEFAULT_MODULES'] = "home.php";
$CONFIG['LOCAL_DEVELOPMENT'] = false;
$CONFIG['DELAYTIME'] = 0;
//WEB APP BASE DOMAIN

if(preg_match("/203.54.78.111/i",gethostbyname($_SERVER['HTTP_HOST']))){
	$DOMAIN = "http://{$_SERVER['HTTP_HOST']}/";
}else{
	
	$DOMAIN = "http://".gethostbyname($_SERVER['HTTP_HOST'])."/";

}

$CONFIG['CLOSED_WEB'] = false;
$CONFIG['TEASER_DOMAIN'] =  "{$DOMAIN}public_html/login.php";
$CONFIG['MAINTENANCE'] = false;
$CONFIG['BASE_DOMAIN'] = "{$DOMAIN}public_html/";
$CONFIG['BASE_DOMAIN_PATH'] = "{$DOMAIN}public_html/";
$CONFIG['COORPORATE_DOMAIN'] = "{$DOMAIN}coorporate_html/";
$CONFIG['WAP_DOMAIN'] =  "{$DOMAIN}wap_html/"; //new
$CONFIG['Postpaid_OnlineRegistration'] = "{$DOMAIN}Postpaid_OnlineRegistration/";
$CONFIG['Prepaid_Registrations'] = "{$DOMAIN}Prepaid_Registrations/";

$CONFIG['ASSETS_DOMAIN_WEB'] = $CONFIG['BASE_DOMAIN']."assets/";
$CONFIG['ASSETS_DOMAIN_COORPORATE'] = $CONFIG['COORPORATE_DOMAIN']."assets/";
$CONFIG['ASSETS_DOMAIN_WAP'] = $CONFIG['WAP_DOMAIN']."assets/"; //new

$CONFIG['PUBLIC_ASSET'] = "public_assets/";
$CONFIG['LOCAL_PUBLIC_ASSET'] = "/home/kana/kanadigital/preview/axis2012/public_html/public_assets/";

$CONFIG['LANDING_BASE_DOMAIN'] = "{$DOMAIN}public_html/login.php";
$CONFIG['MOBILE_SITE'] =  "{$DOMAIN}public_html/mobile";


$CONFIG['VIEW_ON']  = 1;
$CONFIG['log_session'] = false;
$CONFIG['userpage'] = 'myworld';

$CONFIG['BASE_DOMAIN_LINK'] = "http://axis-web.kanadigital.com/";
 
//LAUNCH DATE AXIS 
$LAUNCHING_DATE = strtotime("2012-12-12 20:50:10");
 
//SOCIAL MEDIA
//testing
$FB['appID'] = "197394540385726";
$FB['appSecret'] = "274ec6cd8cb83e63698e53a92ad5f407";

$TWITTER['CONSUMER_KEY'] = 'jSdiPfB9opZNZ59jYhIkw';
$TWITTER['CONSUMER_SECRET'] = 'Q1YHJGkfA8x3ozG2o5wPorNdng66V15TQojdHWKRPZ8';
$TWITTER['LOGIN_CALLBACK'] = "{$CONFIG['BASE_DOMAIN']}?loginType=twitter";
$TWITTER['LOGIN_CALLBACK_MOBILE'] = "{$CONFIG['MOBILE_SITE']}?loginType=twitter";

$GPLUS['client_id'] = "453768818495-c53gmngrubgsmbeflhnv49llc4g89ue2.apps.googleusercontent.com";
$GPLUS['client_secret'] = "LcYdrqJQnOon9aSrUuQwxpQJ";
$GPLUS['developer_key'] = "AIzaSyCGnM-efInRjbbAPxwF38HlEim_e97aE78";
$GPLUS['redirect_url'] = $CONFIG['BASE_DOMAIN']."?loginType=google";
$GPLUS['redirect_url_mobile'] = $CONFIG['MOBILE_SITE']."?loginType=google";

$VIKI['application_id'] ="4fd917c27e2e3f464ebee73fea5abab9f42607887a7f5d705361c4e1dec3fdd8";
$VIKI['application_secret'] = "f59f2126673bf7b629a2867d9dc02e6dcff1e9896fa1b25be6e9ba2eb4003bdb";
$VIKI['callback'] =  "http://viki.com";

/**
 * memcache setting
 */
 $CONFIG['memcache_host'] = "127.0.0.1";
 $CONFIG['memcache_port'] = 11211;


/**
 * GPlus Bot Configuration
 */
$GPLUSBOT['target_id'] = "111091089527727420853";
$GPLUSBOT['maxResults'] = 10;
$GPLUSBOT['bot_sleep_time'] = 60;

if($local){
	$CONFIG['DATABASE'][0]['HOST'] 		= "localhost";
	$CONFIG['DATABASE'][0]['USERNAME'] 	= "root";
	$CONFIG['DATABASE'][0]['PASSWORD'] 	= "coppermine";
	$CONFIG['DATABASE'][0]['DATABASE'] 	= "axis_web_2012";
	
	$CONFIG['DATABASE'][1]['HOST'] 		= "localhost";
	$CONFIG['DATABASE'][1]['USERNAME'] 	= "root";
	$CONFIG['DATABASE'][1]['PASSWORD'] 	= "coppermine";
	$CONFIG['DATABASE'][1]['DATABASE'] 	= "axis_credential_2012";
}else{
	$CONFIG['DATABASE'][0]['HOST'] 		= "127.0.0.1";
	$CONFIG['DATABASE'][0]['USERNAME'] 	= "root";
	$CONFIG['DATABASE'][0]['PASSWORD'] 	= "";
	$CONFIG['DATABASE'][0]['DATABASE'] 	= "axis_web_2012";
	
	$CONFIG['DATABASE'][1]['HOST'] 		= "127.0.0.1";
	$CONFIG['DATABASE'][1]['USERNAME'] 	= "root";
	$CONFIG['DATABASE'][1]['PASSWORD'] 	= "";
	$CONFIG['DATABASE'][1]['DATABASE'] 	= "axis_credential_2012";
}

$CONFIG['SERVICE_URL'] = "service/";
$CONFIG['salt'] = '12345678';
/* DATETIME SET */
$timeZone = 'Asia/Jakarta';
date_default_timezone_set($timeZone);


$SMAC_SECRET = sha1("harveyspecterssuits");
$SMAC_HASH = sha1("mikerosssuits");

$CONFIG['SERVICE_KEY'] = sha1("axis2012");


/**
 * Email settings
 */
$CONFIG['EMAIL_FROM_DEFAULT'] = "noreply-axis2012@codebook.com";
$CONFIG['EMAIL_SMTP_HOST'] = "localhost";
$CONFIG['EMAIL_SMTP_PORT'] = 25;
$CONFIG['EMAIL_SMTP_USER'] = "";
$CONFIG['EMAIL_SMTP_PASSWORD'] = "";
$CONFIG['EMAIL_SMTP_SSL'] = 0;
$CONFIG['EMAIL_AXIS'][0] = 'cendiqkrn@gmail.com';
$CONFIG['EMAIL_AXIS'][1] = 'kia_krn@yahoo.com';


?>
