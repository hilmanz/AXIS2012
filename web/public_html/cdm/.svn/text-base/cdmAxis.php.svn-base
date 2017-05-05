<?php
error_reporting(0);

require_once('nusoap/nusoap.php');

//cek user device data in DB
/* 
http://www.axisworld.co.id/device_setting/index.php?call=provisioning&username=newportal&password=newportal123&msisdn=6283891122801&feature=All&language=0&handset=All&handset_type=All
*/
$call = @$_GET['call'];

if($call=='') exit;

$authdata['username'] = $_GET['username'];
$authdata['password'] =  $_GET['password'];

//testing
$code =  $_GET['code'];
$number =  $_GET['number'];
$authdata['msisdn'] = $code.$number;
$authdata['feature'] = $_GET['feature'];
$authdata['language'] = $_GET['language'];
$authdata['handset'] = $_GET['handset'];
$authdata['handset_type'] =$_GET['handset_type'];

//cek user device data in DB
/*
$authdata['username'] = 'newportal';
$authdata['password'] = 'newportal123';
*/

//testing
/*
$authdata['msisdn'] = '6283891122801';
$authdata['feature'] = 'All';
$authdata['language'] = '0';
$authdata['handset'] = 'Auto';
$authdata['handset_type'] = 'Auto';
*/

$url = "http://10.9.11.173:8080/provisioning.php";
	
$client = new nusoap_client($url);
$err = $client->getError();
if ($err) {

    print '<p><b>error on construct : ' . $err . '</b></p>';
   
}

$data = $client->call($call,array('data'=>$authdata));

// print $client->getError();
print json_encode($data);
exit;
?>