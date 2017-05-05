<?php

function isTableExists($database, $tableName) {
$sql = "SHOW TABLES FROM {$database} like '{$tableName}'";
	$rs = mysql_query($sql, $con);
    $is_exists = false;
    if(mysql_fetch_array($rs))
    {
	$is_exists = true;
    }
	return $is_exists; 
    mysql_free_result($rs);		
}	

function convert_facebook_timestamp($facebook_timestamp){
    $tmp = str_replace("T"," ",$facebook_timestamp);
    $tmp = substr($tmp,  0,19);
    return strtotime($tmp);
}

function oauth($code,$app_id,$redirect_url,$app_secret){
    $access_token = "";
  if (isset($code)) {
    $token_url="https://graph.facebook.com/oauth/access_token?client_id={$app_id}&redirect_uri=" . urlencode($redirect_url)
	    ."&client_secret={$app_secret}&code={$code}";
    
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params["access_token"];
  }
    
  return $access_token;
}

  // note this wrapper function exists in order to circumvent PHP�s 
  //strict obeying of HTTP error codes.  In this case, Facebook 
  //returns error code 400 which PHP obeys and wipes out 
  //the response.

function curl_get_file_contents($log,$URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    $log->info("error: ".curl_getinfo($c,CURLINFO_HTTP_CODE));
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
}

?>
