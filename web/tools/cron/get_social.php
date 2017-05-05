<?php
include "../../config/config.inc.php";
include "db.php";
error_reporting(E_ALL);
set_time_limit(0);
print_r('<pre>');
class get_social extends db{
/* Return object of shared counts */


function generatedata(){
	//setting date minus 10 hari after get all data
	$sql = "select parentid,articleType from axis_web_2012.axis_news_content WHERE articleType IN (2,3) AND created_date >= DATE_SUB(NOW(), INTERVAL 100 DAY)";
	
	$qData = $this->fetch($sql,1);
	
	$n=0;
	if(!$qData) return false;
	foreach($qData as $val){
		if($val->articleType==2) $link = "http://www.axisworld.co.id/index.php?page=content&act=detail&id=";
		else $link = "http://www.axisworld.co.id/index.php?page=promo&act=detail&id=";
		$data[$val->parentid] = $this->get_social_count($link.$val->parentid);
		if($n>10) {
			sleep(30);	
			$n=0;
		}else $n++;
		
	}
	// [3] => stdClass Object
        // (
            // [facebook] => 0
            // [twitter] => 0
            // [gplus] => 0
    // )
	if(!$data) return false;
		$n=0;
	foreach($data as $key => $val){
		$sql = " 
			INSERT INTO axis_web_2012.tbl_summary_share_content (contentid,facebook,twitter,gplus,datetimes)
			VALUES ({$key},{$val->facebook},{$val->twitter},{$val->gplus},NOW()) 
			ON DUPLICATE KEY UPDATE facebook = {$val->facebook},twitter={$val->twitter} , gplus = {$val->gplus} ,datetimes = NOW()
		";
		$qsqlData[] = $sql;
		$qData = $this->query($sql);
		if($n>50) {
			sleep(5);	
			$n=0;
		}else $n++;
	}
	print '<pre>';
		print_r($qsqlData);
	print '</pre>';
}

function get_social_count( $link ) {

	$r = (object)array();
	$r->facebook = $this->get_social_count_facebook($link);
	$r->twitter = $this->get_social_count_twitter($link);
	$r->gplus = $this->get_social_count_gplus($link);
	return $r;
}

/* Return shared counts */
function get_social_count_facebook( $link ) {
	$link = urlencode($link);
	// print_r($link);exit;
	$data = simplexml_load_file("http://api.facebook.com/restserver.php?method=links.getStats&urls={$link}");
	$count = intval(@$data->link_stat->share_count);
	
	return $count ? $count : 0;
}

/* Return retweet counts */
function get_social_count_twitter( $link ) {
	$link = urlencode($link);
	$data = file_get_contents("http://urls.api.twitter.com/1/urls/count.json?url={$link}");
	$json = json_decode($data, true);
	$count = $json["count"];
	return $count ? $count : 0;
}

/* Return shared counts */
function get_social_count_gplus( $link ) {
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.$link.'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$data = curl_exec ($ch);
	curl_close ($ch);
	$json = json_decode($data, true);
 	$count = $json[0]['result']['metadata']['globalCounts']['count'];
 	return $count ? $count : 0;
}
}



$class = new get_social;
$class->generatedata();

die();

?>