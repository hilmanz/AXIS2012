<?php
error_reporting(E_ALL);
$CONFIG['LOG_DIR'] = "../logs/";
$GLOBAL_PATH = "../";
$APP_PATH = "../com/";
$ENGINE_PATH = "../engines/";
$WEBROOT = "../html/";

//DEFINE VARIABLE
define('APPLICATION','Dashboard');        //set aplikasi yang digunakan
define('DB_PREFIX','rr');        //set DB prefix for frontend
define('BASEURL','http://localhost/Mindshare-dev/public_html/');        //set BASEURL frontend
define('BASEURL_ADMIN','http://localhost/Mindshare-dev/admin/');        //set BASEURL admin
define('APP_PATH',$APP_PATH);
//set TRUE jika dalam local
$local = true;
$DEVELOPMENT_MODE = true;
$CONFIG['DEFAULT_MODULES'] = "home.php";
$CONFIG['LOCAL_DEVELOPMENT'] = false;
$CONFIG['DELAYTIME'] = 0;
//WEB APP BASE DOMAIN
$CONFIG['CLOSED_WEB'] = false;
$CONFIG['TEASER_DOMAIN'] =  "http://preview.kanadigital.com/axis2012/public_html/login.php";
$CONFIG['MAINTENANCE'] = false;
$CONFIG['BASE_DOMAIN'] = "http://preview.kanadigital.com/axis2012/public_html/";
$CONFIG['ASSETS_DOMAIN'] = "http://preview.kanadigital.com/axis2012/public_html/assets/";
$CONFIG['PUBLIC_ASSET'] = "public_assets/";
$CONFIG['LANDING_BASE_DOMAIN'] = "http://preview.kanadigital.com/axis2012/public_html/login.php";
$CONFIG['MOBILE_SITE'] =  "http://preview.kanadigital.com/axis2012/public_html/mobile";



//set database
$CONFIG['DEVELOPMENT'] = true;
if($CONFIG['DEVELOPMENT']){
        $CONFIG['DATABASE'][0]['HOST']             = "119.81.1.130";
        $CONFIG['DATABASE'][0]['USERNAME']         = "root";
        $CONFIG['DATABASE'][0]['PASSWORD']         = "coppermine";
        $CONFIG['DATABASE'][0]['DATABASE']         = "axis_report";
        error_reporting(E_ALL);
}else{
        $CONFIG['DATABASE'][0]['HOST']             = "119.81.1.130";
        $CONFIG['DATABASE'][0]['USERNAME']         = "root";
        $CONFIG['DATABASE'][0]['PASSWORD']         = "coppermine";
        $CONFIG['DATABASE'][0]['DATABASE']         = "axis_report";
}

		$CONFIG['DATABASE'][2]['HOST']             = "localhost";
        $CONFIG['DATABASE'][2]['USERNAME']         = "root";
        $CONFIG['DATABASE'][2]['PASSWORD']         = "coppermine";

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


$CONFIG['GA']['da4b9237bacccdf19c0760cab7aec4a8359010b0']['username'] = 'beranikotoritubaik@gmail.com';
$CONFIG['GA']['da4b9237bacccdf19c0760cab7aec4a8359010b0']['password'] = 'rinsoindonesia';
$CONFIG['GA']['da4b9237bacccdf19c0760cab7aec4a8359010b0']['profileid'] = '52558708';


$CONFIG['GA'][2]['username'] = '';
$CONFIG['GA'][2]['password'] = '';
$CONFIG['GA'][2]['profileid'] = '';


$CONFIG['GA'][3]['username'] = '';
$CONFIG['GA'][3]['password'] = '';
$CONFIG['GA'][3]['profileid'] = '';

/**
 * memcache setting
 */
 $CONFIG['memcache_host'] = "127.0.0.1";
 $CONFIG['memcache_port'] = 11211;


//SOCIAL MEDIA
//testing
$FB['appID'] = "181586055282513";
$FB['appSecret'] = "d22971d06613820427e4e44cdfe1d67b";

/**
 * GPlus Bot Configuration
 */
$GPLUSBOT['target_id'] = "111091089527727420853";
$GPLUSBOT['maxResults'] = 10;
$GPLUSBOT['bot_sleep_time'] = 60;

$TWITTER['CONSUMER_KEY'] = 'CeAeKQ6W2flJaiR7m5D3uQ';
$TWITTER['CONSUMER_SECRET'] = 'QS7jBlukxkXhN1bUqFAh5K3Z1pz84Z9fGjgoeJ5mxu8';
$TWITTER['LOGIN_CALLBACK'] = $CONFIG['BASE_DOMAIN'].'?loginType=twitter';

$GPLUS['client_id'] = "990314435829.apps.googleusercontent.com";
$GPLUS['client_secret'] = "c6TzeOJkdOJxtzr_TGMxv5xN";
$GPLUS['developer_key'] = "AIzaSyAWZTca5Nth3LPhlzI9dJUsG2kZUMhFB7I";
$GPLUS['redirect_url'] = 'http://preview.kanadigital.com/axis2012/public_html/?loginType=google';



$GPLUSBOT['target_id'] = "111091089527727420853";
$GPLUSBOT['maxResults'] = 10;
$GPLUSBOT['bot_sleep_time'] = 60;

/**
 * SMAC API 
 */
$SMAC['API_KEY'] = "ee4dd87cd1e09e256f7979b35860ea6ae5f44b04";
$SMAC['SECRET'] = "DwRvr-OrNfGkiM5_oFpeJ9sJOGCxYfSHLP5JhnOSFvlhtFIGphAT80KSQ1FC4WMQ0thuU9iefrTZ5HtwGTbG61UKhkFDF-Bz";
$SMAC['callback'] = "http://localhost/smac_trunk/web/service/";
$SMAC['topic_id'] = 16;
$SMAC['twitter_id'] = array("javasoulnation","vidialdiano","detikcom","kompas");

?>
