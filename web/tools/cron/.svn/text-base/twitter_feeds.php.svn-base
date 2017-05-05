<?php
/**
 * these bot will retrieve a twitter account's feeds from SMAC.
 */
include "../../config/config.inc.php";
include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include "db.php";
include_once "smac.php";
class twitter_feeds extends db{
	protected $smac;
	protected $access_token;
	function init(){
		global $SMAC;
		$this->smac = new smac($SMAC['API_KEY'],$SMAC['SECRET']);
		$this->smac->authenticate();
	}
	function get_feeds(){
		global $SMAC;
		foreach($SMAC['twitter_id'] as $twitter_id){
			$sql = "INSERT IGNORE INTO `axis_report_2012`.`tbl_twitter_feeds_job` 
					(
					`twitter_id`, 
					`last_id`
					)
					VALUES
					(
					'{$twitter_id}', 
					0
					);";
			$this->query($sql);
				
			$this->retrieve_feeds($twitter_id);
			
		}
	}
	function retrieve_feeds($twitter_id){
		global $SMAC;
		$sql = "SELECT
				`twitter_id`, 
				`last_id`
				FROM 
				`axis_report_2012`.`tbl_twitter_feeds_job`
				WHERE twitter_id='{$twitter_id}'
				LIMIT 1";
		$job = $this->fetch($sql);
		$last_id = $job->last_id;
	
		print "Processing {$twitter_id} - last_id : {$last_id}".PHP_EOL;
		print "-----------------------------------------------".PHP_EOL;
		if($last_id!=null){
			$param = array("method"=>"channel",
							"action"=>"feeds",
							"campaign_id"=>$SMAC['topic_id'],
							"twitter_id"=>$twitter_id,
							"last_id"=>$last_id);
			$rs = $this->smac->api($param);
			print_r($rs);
			if(sizeof($rs['data'])==0){
				return false;
			}
			while(sizeof($rs['data'])>0){
				$d = array_shift($rs['data']);
				$d['author_id'] = mysql_escape_string($d['author_id']);
				$d['summary'] = mysql_escape_string($d['summary']);
				$sql = "INSERT IGNORE INTO `axis_report_2012`.`tbl_twitter_author_feeds` 
						(
						`author_id`, 
						`feed_id`, 
						`post_date`, 
						`content`, 
						`impression`, 
						`rt`, 
						`rt_impression`
						)
						VALUES
						( 
						'{$d['author_id']}', 
						'{$d['feed_id']}', 
						'{$d['post_date']}', 
						'{$d['summary']}', 
						{$d['impression']}, 
						{$d['rt']}, 
						{$d['rt_impression']}
						);";
				$q = $this->query($sql);
				if($q){
					print "{$d['feed_id']} - OK".PHP_EOL;
				}else{
					print "{$d['feed_id']} - FAILED".PHP_EOL;
				}
				$last_id=intval($d['feed_id']);
			}
			print "-----------------------------------------------".PHP_EOL;
			$sql = "UPDATE `axis_report_2012`.`tbl_twitter_feeds_job` 
					SET
					`last_id` = {$last_id}
					WHERE
					twitter_id='{$twitter_id}'";
			$q = $this->query($sql);
			$this->retrieve_feeds($twitter_id);
		}
	}
	
}
$app = new twitter_feeds();
$app->init();
$app->get_feeds();
?>