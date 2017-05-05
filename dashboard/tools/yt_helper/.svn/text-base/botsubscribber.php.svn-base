<?php
	include "config.php";
	
	$data ="SELECT date from channel_subscribers order by date desc LIMIT 1";
	$qData = mysql_query($data);
	$lastDate = mysql_fetch_object($qData);
	
	
	$data ="SELECT channel_total_subscriber,date,date_ts from channel_stats WHERE date >= '{$lastDate->date}' order by date desc";

	$qData = mysql_query($data);
		$i = 0;
	while($row = mysql_fetch_object($qData)){
	$arr[] = $row;
	}
	if(count($arr) <= 1 ) {
		echo "no data submission, wait for record have gt 2 data";
		mysql_close($con);
		exit;
	}
	foreach($arr as $key => $val){
			
			$subscribe = $val->channel_total_subscriber - $arr[$key+1]->channel_total_subscriber;
			
			$values[]  = "('AXISGSM Yang Baik','AXISGSM', '{$subscribe}', '{$val->date}', '{$val->date_ts}')";
			
	}
			$strValues = implode(",",$values);
			
			if($strValues=="") {
			mysql_close($con);
			exit;
			}
			$q = "INSERT IGNORE INTO channel_subscribers (channel_name,channel_id,subscribe,date,date_ts) 
			VALUES {$strValues} ";
			echo $q;

			mysql_query($q);
mysql_close($con);

	
?>


