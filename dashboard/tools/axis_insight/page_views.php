<?php
set_time_limit(0);

require "config.php";
require "libs/Logger.php";

$JOB_ID = "axis_facebook";
$log = new Logger($JOB_ID);
$log->logger_namespace($JOB_ID);
$log->verbose(false);

// SETTING PARAMETER
$metrix = "page_views";
// SETTING PARAMETER


$log->info("{$metrix} started at ".date('Y-m-d H:i:s'));
$my_url = $canvas_url.$metrix.".php"; //=> set your redirect url
     
  // known valid access token stored in a database 
  // $access_token = "YOUR_STORED_ACCESS_TOKEN";

  $code = $_REQUEST["code"];
    
  // If we get a code, it means that we have re-authed the user 
  //and can get a valid access_token. 
  if (isset($code)) {
	
    $token_url="https://graph.facebook.com/oauth/access_token?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url) ."&client_secret=" . $app_secret 
      . "&code=" . $code;
    
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params['access_token'];
  }

        
  // Attempt to query the graph:
  $graph_url = "https://graph.facebook.com/me?"
    . "access_token=" . $access_token;
  $response = curl_get_file_contents($graph_url);
  $decoded_response = json_decode($response);
    
  //Check for errors 
  if ($decoded_response->error) {
  // check to see if this is an oAuth error:
    if ($decoded_response->error->type== "OAuthException") {
      // Retrieving a valid access token. 
      $dialog_url= "https://www.facebook.com/dialog/oauth?"
        . "client_id=" . $app_id 
        . "&redirect_uri=" . urlencode($my_url)."&scope=read_insights";
      echo("<script> top.location.href='" . $dialog_url 
      . "'</script>");
    }
    else {
      $log->info("An error occured after decode with type: {$decoded_response->error->type}");
    }
  } 
  else {
  // success
    // echo("success" . $decoded_response->name);
    echo("Access Token = ".$access_token."<br>");
	$pagesID = $FACEBOOK_PAGE_ID;
	// $urlInsight = "https://graph.facebook.com/".$pagesID."/insights?access_token=".$access_token; //=> LINK ALL INSIGHTS
	
	
	$urlInsight = "https://graph.facebook.com/".$pagesID."/insights/".$metrix."?access_token=".$access_token."&since=".$since."&until=".$until;
	$log->info("{$metrix} URL INSIGHT: {$urlInsight}");
	$var = json_decode(file_get_contents($urlInsight));
	// print_r($var);
	$data1 = $var->data[0]->values;
	$data2 = $var->data[1]->values;
	foreach($data1 as $dt1){
		$day = date("Y-m-d",strtotime($dt1->end_time));
		$q = "INSERT IGNORE INTO fb_".$metrix."_day (proID,value,day) 
				VALUES ('".$proID."','".$dt1->value."','".$day."')";
		if(mysql_query($q)){
		   $log->info($q." => SUKSES");
		}else{
		   $log->info($q." => GAGAL");
		}
	}	
	echo "OK";
	exit;
  }

  // note this wrapper function exists in order to circumvent PHP�s 
  //strict obeying of HTTP error codes.  In this case, Facebook 
  //returns error code 400 which PHP obeys and wipes out 
  //the response.
  function curl_get_file_contents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
  }
?>