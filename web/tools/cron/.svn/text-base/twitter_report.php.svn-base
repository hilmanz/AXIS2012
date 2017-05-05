<?php
include "../../config/config.inc.php";
include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include "db.php";
include_once "smac.php";

class twitter_report extends db{
	protected $smac;
	protected $access_token;
	function init(){
		global $SMAC;
		$this->smac = new smac($SMAC['API_KEY'],$SMAC['SECRET']);
		$this->smac->authenticate();
	}
	function report(){
		global $SMAC;
		foreach($SMAC['twitter_id'] as $twitter_id){
			$param = array("method"=>"channel",
							"action"=>"summary",
							"campaign_id"=>$SMAC['topic_id'],
							"twitter_id"=>$twitter_id);
			$rs = $this->smac->api($param);
			while(sizeof($rs['data'])>0){
				$d = array_shift($rs['data']);
				$sql = "INSERT INTO `axis_report_2012`.`tbl_twitter_daily_stats` 
				(
				`topic_id`, 
				`author_id`, 
				`post_date`, 
				`mentions`, 
				`impressions`, 
				`rt_impressions`, 
				`rt`, 
				`sentiment`
				)
				VALUES
				(
				'{$SMAC['topic_id']}', 
				'{$d['author_id']}', 
				'{$d['post_date']}', 
				{$d['mentions']}, 
				{$d['impression']}, 
				{$d['rt_impression']}, 
				{$d['rt_mentions']}, 
				{$d['sentiment']}
				)
				ON DUPLICATE KEY UPDATE
				mentions = VALUES(mentions),
				impressions = VALUES(impressions),
				rt_impressions = VALUES(rt_impressions),
				rt = VALUES(rt),
				sentiment = VALUES(sentiment);";
				$q = $this->query($sql);
				if($q){
					print "{$d['post_date']} - OK".PHP_EOL;
				}else{
					print "{$d['post_date']} - FAILED".PHP_EOL;
				}
			}
		}
	}
	function wordcloud(){
		global $SMAC;
		foreach($SMAC['twitter_id'] as $twitter_id){
			$param = array("method"=>"channel",
							"action"=>"wordcloud",
							"campaign_id"=>$SMAC['topic_id'],
							"twitter_id"=>$twitter_id);
			$rs = $this->smac->api($param);
			while(sizeof($rs['data'])>0){
				$d = array_shift($rs['data']);
				$keyword = mysql_escape_string(cleanXSS($d['keyword']));
				$total = intval($d['total']);
				$sql = "INSERT INTO `axis_report_2012`.`tbl_twitter_wordcloud` 
						(
						`twitter_id`, 
						`keyword`, 
						`total`, 
						`last_update`
						)
						VALUES
						(
						'{$twitter_id}', 
						'{$keyword}', 
						{$total}, 
						NOW()
						)
						ON DUPLICATE KEY UPDATE
						total=VALUES(total),
						last_update = VALUES(last_update)";
				
				$q = $this->query($sql);
				if($q){
					print "{$twitter_id} - {$d['keyword']} - OK".PHP_EOL;
				}else{
					print "{$twitter_id} - {$d['keyword']} - FAILED".PHP_EOL;
				}
				
			}
		}
	}
}
$app = new twitter_report();
$app->init();
$app->report();
$app->wordcloud();
?>