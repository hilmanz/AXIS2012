<?php
session_start();
set_time_limit(0);

require "feed_post_config.php";
require "common.php";
require "libs/Logger.php";

$JOB_ID = "axis_facebook";
$log = new Logger($JOB_ID);
$log->logger_namespace($JOB_ID);
$log->verbose(false);
$STOP = FALSE;
// SETTING PARAMETER
$metrix = "page_feeds";
// SETTING PARAMETER

$log->info("{$metrix} started at ".date('Y-m-d H:i:s'));
$redirect_url = CANVAS_URL.$metrix.".php"; //=> set your redirect url
$paging = "";     
//$since = "";
$until = "";

$request_feed_url = $_GET["feed"];
if(!empty($request_feed_url)){
    //Store it in session
    $_SESSION["feed"] = $request_feed_url; 
    $log->info("info: stored next url in session");
}

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
    //Retrieve it from session
    $log->info("info: retrieve next url in session");
    $request_feed_url = $_SESSION["feed"];
    
    if(!empty($request_feed_url)){
	$urlFeed = $request_feed_url;
	$log->info("Getting feed url from request");

    }
    else{
	$urlFeed = "https://graph.facebook.com/".$pagesID."/feed?access_token=".$access_token."&since=".SINCE."&until=".UNTIL;
	$log->info("Getting initial feed url");
    }
    
    $log->info("info: URL FEED: {$urlFeed}");
    $params = null;
    parse_str($urlFeed, $params);
    $until = date("d-m-Y H:i:s",$params["until"]);
    $log->info("processing feed from {$until}");
    $content = file_get_contents($urlFeed);
    $var = json_decode($content);
    $feeds = $var->data;
    $paging = $var->paging;
    
    foreach($feeds as $feed){
	    $page_like_count = $feed->id;
	    $from_name = $feed->from->name;
	    $from_category = $feed->from->category;
	    $from_id = $feed->from->id;
	    $message = $feed->message;
	    $comment_count = $feed->comments->count;
	    $like_count = $feed->likes->count;
	    if(empty($like_count)){$like_count = 0;}
	    $created_time = convert_facebook_timestamp($feed->created_time);
	    $STOP = $created_time < SINCE;
	    $created_time = date("Y-m-d H:i:s",$created_time);
	    if($STOP){ 
	    $log->info("Reached date limit: ".date("d-m-Y H:i:s",SINCE));
    ?>
	<!DOCTYPE html>
	<html>
	    <head>
		<title>BOT List</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    </head>
	    <body>
		<h3>Reached date limit: <?=date("d-m-Y H:i:s",SINCE)?></h3>
	    </body>
	</html>
    <?php    
    }
	    
	if(!$STOP){    
	    $query = "INSERT IGNORE INTO fb_page_feeds (feed_id,from_name,from_category,from_id,message,comment_count,like_count,created_time) 
			    VALUES ('{$page_like_count}','{$from_name}','{$from_category}','{$from_id}','{$message}',{$comment_count}
			    ,{$like_count},'{$created_time}')";
	    if(!mysql_query($query)){
		$log->info($query." => GAGAL");
		$log->info(mysql_errno($con) . ": " . mysql_error($con));
	    }
	}
    }	
    $log->info("info: next url: {$paging->next}");
    $log->info("Last feed processed: ".date("d-m-Y H:i:s",$params["until"]));
    $query = "SELECT DATE_FORMAT(created_time,'%Y-%m-%d') as feed_date, COUNT(id) as feed_count FROM fb_page_feeds GROUP BY DATE_FORMAT(created_time,'%Y-%m-%d')";
	$result = mysql_query($query);
	while($row=  mysql_fetch_array($result)){
	    $insert = "INSERT INTO fb_page_feeds_summary (feed_date,feed_count) VALUES('{$row["feed_date"]}',{$row["feed_count"]}) ON DUPLICATE KEY UPDATE feed_count={$row["feed_count"]}";
	    if(!mysql_query($insert)){
		$log->info($query." => SUMMARY GAGAL");
		$log->info(mysql_errno($con) . ": " . mysql_error($con));
	    }
	}
	if($STOP){
	    exit;
	}
	
  }
?>
<!DOCTYPE html>
<html>
    <head>
	<title>BOT List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript">
	    
	    var next_url = "<?=$_SERVER["PHP_SELF"]."?feed=".urlencode($paging->next)?>";
	    var go_to_next_page = function(url){
		location.href = url;
	    }
	    var url_hitter_interval;
	    <?php
	    if($STOP){
	    ?>
		clearInterval(url_hitter_interval);
	    <?php
	    }else{
	    ?>
		url_hitter_interval = setInterval(function(){go_to_next_page(next_url);},5000);
	     <?php
	    }
		?>
	</script>
	
    </head>
    <body>
	<h3>Next Feed URL on <?=$until?> will be executed in 10 seconds</h3>
    </body>
</html>
