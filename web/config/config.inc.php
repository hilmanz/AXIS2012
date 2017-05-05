<?php
@include_once "locale.inc.php";
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

define('WIDGET_DOMAIN_WEB',APPLICATION."/widgets/");
define('WIDGET_DOMAIN_COORPORATE',COORPORATE_APPS."/widgets/");
define('WIDGET_DOMAIN_MOBILE',MOBILE_APPS."/widgets/");

define('HELPER_DOMAIN_WEB',APPLICATION."/helper/");
define('HELPER_DOMAIN_COORPORATE',COORPORATE_APPS."/helper/");
define('HELPER_DOMAIN_MOBILE',MOBILE_APPS."/helper/");

define('MODULES_DOMAIN_WEB',$APP_PATH.APPLICATION."/modules/");
define('MODULES_DOMAIN_COORPORATE',$APP_PATH.COORPORATE_APPS."/modules/");
define('MODULES_DOMAIN_MOBILE',$APP_PATH.MOBILE_APPS."/modules/");

define('TEMPLATE_DOMAIN_WEB',APPLICATION."/axisweb/");
define('TEMPLATE_DOMAIN_COORPORATE',APPLICATION."/coorporate/");
define('TEMPLATE_DOMAIN_MOBILE',APPLICATION."/mobile/");

define('SCHEMA_DATA','codebook');
//set TRUE jika dalam local
$local = true;
$DEVELOPMENT_MODE = true;
$CONFIG['DEFAULT_MODULES'] = "home.php";
$CONFIG['LOCAL_DEVELOPMENT'] = false;
$CONFIG['DELAYTIME'] = 0;
//WEB APP BASE DOMAIN
$CONFIG['CLOSED_WEB'] = false;
$CONFIG['TEASER_DOMAIN'] =  "http://localhost/AXIS2012/web/public_html/login.php";
$CONFIG['MAINTENANCE'] = false;
$CONFIG['BASE_DOMAIN'] = "http://localhost/AXIS2012/web/public_html/";
$CONFIG['COORPORATE_DOMAIN'] = "http://localhost/AXIS2012/web/coorporate_html/";

$CONFIG['ASSETS_DOMAIN_WEB'] = $CONFIG['BASE_DOMAIN']."assets/";
$CONFIG['ASSETS_DOMAIN_COORPORATE'] = $CONFIG['COORPORATE_DOMAIN']."assets/";

$CONFIG['PUBLIC_ASSET'] = "public_assets/";
$CONFIG['LANDING_BASE_DOMAIN'] = "http://localhost/AXIS2012/web/public_html/login.php";
$CONFIG['MOBILE_SITE'] =  "http://localhost/AXIS2012/web/public_html/mobile";

$CONFIG['VIEW_ON']  = 1;
//SOCIAL MEDIA
//testing
$FB['appID'] = "181586055282513";
$FB['appSecret'] = "d22971d06613820427e4e44cdfe1d67b";

// $FB['appID'] = "341380259214774";
// $FB['appSecret'] = "63685e1fd7db81fc51a04de0e2034ceb";

$TWITTER['CONSUMER_KEY'] = 'CeAeKQ6W2flJaiR7m5D3uQ';
$TWITTER['CONSUMER_SECRET'] = 'QS7jBlukxkXhN1bUqFAh5K3Z1pz84Z9fGjgoeJ5mxu8';
$TWITTER['LOGIN_CALLBACK'] = $CONFIG['BASE_DOMAIN'].'?loginType=twitter';

$GPLUS['client_id'] = "990314435829.apps.googleusercontent.com";
$GPLUS['client_secret'] = "c6TzeOJkdOJxtzr_TGMxv5xN";
$GPLUS['developer_key'] = "AIzaSyAWZTca5Nth3LPhlzI9dJUsG2kZUMhFB7I";
$GPLUS['redirect_url'] = 'http://preview.kanadigital.com/axis2012/public_html/?loginType=google';

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
	$CONFIG['DATABASE'][0]['USERNAME'] 	= "sample";
	$CONFIG['DATABASE'][0]['PASSWORD'] 	= "sample";
	$CONFIG['DATABASE'][0]['DATABASE'] 	= "axis2012";
}else{
	$CONFIG['DATABASE'][0]['HOST'] 		= "127.0.0.1";
	$CONFIG['DATABASE'][0]['USERNAME'] 	= "root";
	$CONFIG['DATABASE'][0]['PASSWORD'] 	= "";
	$CONFIG['DATABASE'][0]['DATABASE'] 	= "axis_web_2012";
	
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



?>
