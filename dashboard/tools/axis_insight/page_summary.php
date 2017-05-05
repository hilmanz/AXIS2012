<?php
set_time_limit(0);

require "feed_post_config.php";
require "common.php";
require "libs/Logger.php";

$JOB_ID = "axis_facebook";
$log = new Logger($JOB_ID);
$log->logger_namespace($JOB_ID);
$log->verbose(false);

// SETTING PARAMETER
$metrix = "page_summary";
// SETTING PARAMETER

$log->info("{$metrix} started at ".date('Y-m-d H:i:s'));
$redirect_url = CANVAS_URL.$metrix.".php"; //=> set your redirect url
     
  // known valid access token stored in a database 
  // $access_token = "YOUR_STORED_ACCESS_TOKEN";
  // If we get a code, it means that we have re-authed the user 
  //and can get a valid access_token. 
  $access_token = oauth($_REQUEST["code"],APP_ID,$redirect_url,APP_SECRET);

  if(empty($access_token)){
      $log->info("warning: \"code\" parameter is empty or not valid");
  }      
  
  // Attempt to query the graph:
  $graph_url = "https://graph.facebook.com/me?access_token={$access_token}";
  $response = curl_get_file_contents($log,$graph_url);
  $decoded_response = json_decode($response);
  
  //Check for errors 
  if ($decoded_response->error){
  // check to see if this is an oAuth error:
    if ($decoded_response->error->type== "OAuthException") {
      // Retrieving a valid access token. 
      $dialog_url= "https://www.facebook.com/dialog/oauth?client_id=".APP_ID."&redirect_uri=".urlencode($redirect_url)."&scope=read_insights";
      echo("<script> top.location.href='{$dialog_url}'</script>");
    }
    else {
      $log->info("An error occured after decode with type: {$decoded_response->error->type}");
    }
  } 
  else {
    echo("Access Token = ".$access_token."<br>");
    $pagesID = FACEBOOK_PAGE_ID;
    $urlFeed = "https://graph.facebook.com/".$pagesID."?access_token=".$access_token."&since=".SINCE."&until=".UNTIL;
    $log->info("info: URL FEED: {$urlFeed}");
    $content = file_get_contents($urlFeed);
    $summary = json_decode($content);
    
    $page_like_count = $summary->likes;
    $page_talking_about_count = $summary->talking_about_count;
    $query = "INSERT IGNORE INTO fb_page_summary (page_date,page_like_count,page_talking_about_count) 
		    VALUES (NOW(),{$page_like_count},{$page_talking_about_count})";
    if(!mysql_query($query)){
	$log->info($query." => GAGAL");
     }
	echo "OK";
	exit;
  }
?>