<?php
/**
 * The purpose of the script is to hit googleplus api to retrieve
 * the targeted user's activity list
 * we store the new feeds until the id reach last_id
 * 
 */
include "../../config/config.inc.php";
include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include "db.php";
class gplus_activity extends db{
	protected $last_id;
	protected $found_last_id = true;
	protected $next_url = "";
	protected $debug;
	public function init(){
		$this->debug = new Debugger();
		$this->debug->setAppName('gplus_activity');
		$this->debug->setDirectory("../../logs/");
	}
	private function getLastId(){
		$sql = "SELECT last_id 
				FROM axis_report_2012.gplus_bot 
				WHERE job = 'gplus_activities' 
				LIMIT 1";
		$rs = $this->fetch($sql);		
		return $rs->last_id;
	}
	private function setLastId($last_id){
		$sql = "UPDATE axis_report_2012.gplus_bot
				SET last_id='{$last_id}',dt_update = NOW()
				WHERE job = 'gplus_activities'";
		$q = $this->query($sql);
		if($q){
			return $last_id;
		}
	}
	public function get_feeds(){
		global $GPLUSBOT;
		$this->last_id = $this->getLastId();
		if($this->last_id==NULL){
			//insert everything, and take first result's last_id as the new last_id
			$this->saveEverything();
		}else{
			$this->saveUntilLastId();
		}
		//uncomment 2 lines below to make the bot works continously
		//sleep($GPLUSBOT['bot_sleep_time']); 
		//$this->get_feeds();
		$this->debug->log("Finished.");
	}
	/**
	 * since we not provide any last_id, we take everything we got from the api returns.
	 * and then use the first entry's id as the new last_id
	 */
	private function saveEverything(){
		global $GPLUS,$GPLUSBOT;
		$url = "https://www.googleapis.com/plus/v1/people/{$GPLUSBOT['target_id']}/activities/public?maxResults={$GPLUSBOT['maxResults']}&key={$GPLUS['developer_key']}";
		$response = json_decode(curlGet($url),true);
		$items = $response['items'];
		$n_items = sizeof($items);
		for($i=0;$i<$n_items;$i++){
			$feed_id = $items[$i]['id'];
			$url = $items[$i]['url'];
			$published = $items[$i]['published'];
			$published_ts = strtotime($published);
			$published_datetime = date("Y/m/d H:i:s",$published_ts);
			$title = $items[$i]['title'];
			$kind = $items[$i]['kind'];
			$activity_owner_id = $GPLUSBOT['target_id'];
			$actor_id = $items[$i]['actor']['id'];
			$actor_displayname = $items[$i]['actor']['displayName'];
			$actor_url = $items[$i]['actor']['url'];
			$actor_image = $items[$i]['actor']['image']['url'];
			$content = $items[$i]['object']['content'];
			$total_replies = $items[$i]['object']['replies']['totalItems'];
			$total_replies_api_url = $items[$i]['object']['replies']['selfLink'];
			$total_plusoners =$items[$i]['object']['plusoners']['totalItems'];
			$total_plusoners_api_url = $items[$i]['object']['plusoners']['selfLink'];
			$total_resharers = $items[$i]['object']['resharers']['totalItems'];
			$total_resharers_api_url = $items[$i]['object']['resharers']['selfLink'];
			$sql = "INSERT IGNORE INTO `axis_report_2012`.`tbl_gplus_feed` 
					(
					`feed_id`, 
					`url`, 
					`published`, 
					`published_ts`,
					published_date_time,
					`title`, 
					`kind`, 
					`activity_owner_id`, 
					`actor_id`, 
					`actor_displayname`, 
					`actor_url`, 
					`actor_image`, 
					`content`, 
					`total_replies`, 
					`total_replies_api_url`, 
					`total_plusoners`, 
					`total_plusoners_api_url`, 
					`total_resharers`, 
					`total_resharers_api_url`, 
					`retrieved_date`, 
					`n_status`
					)
					VALUES
					( 
					'{$feed_id}', 
					'{$url}', 
					'{$published}', 
					{$published_ts}, 
					'{$published_datetime}',
					'{$title}', 
					'{$kind}', 
					'{$activity_owner_id}', 
					'{$actor_id}', 
					'{$actor_displayname}', 
					'{$actor_url}', 
					'{$actor_image}', 
					'{$content}', 
					'{$total_replies}', 
					'{$total_replies_api_url}', 
					'{$total_plusoners}', 
					'{$total_plusoners_api_url}', 
					'{$total_resharers}', 
					'{$total_resharers_api_url}', 
					NOW(), 
					1
					);";
			$q = $this->query($sql);
			
		}
		if(($n_items)>0){
			//print "retrieved {$n_items} feeds".PHP_EOL;
			$this->debug->log("retrieved {$n_items} feeds");
			$this->setLastId($items[0]['id']);
		}else{
			//print "no item retrieved".PHP_EOL;
			$this->debug->log( "no item retrieved");
		}
	}
	private function saveUntilLastId(){
		//print "saveUntilLastId : {$this->last_id}".PHP_EOL;
		$this->debug->log("saveUntilLastId : {$this->last_id}");
		global $GPLUS,$GPLUSBOT;
		if($this->found_last_id){
			$url = "https://www.googleapis.com/plus/v1/people/{$GPLUSBOT['target_id']}/activities/public?maxResults={$GPLUSBOT['maxResults']}&key={$GPLUS['developer_key']}";
		}else{
			$url = "{$this->next_url}&key={$GPLUS['developer_key']}";
		}
		//print "API : ".$url.PHP_EOL;
		$this->debug->log("API : ".$url);
		$response = json_decode(curlGet($url),true);
		//print "Response : ".json_encode($response).PHP_EOL.PHP_EOL."------".PHP_EOL;
		$this->debug->log("Response : ".json_encode($response));
		$items = $response['items'];
		$this->next_url = $response['nextLink'];
		$n_items = sizeof($items);
		$found_last_id= false;
		$n_item_saved = 0;
		for($i=0;$i<$n_items;$i++){
			$feed_id = $items[$i]['id'];
			if($feed_id!=$this->last_id){
				$url = $items[$i]['url'];
				$published = $items[$i]['published'];
				$published_ts = strtotime($published);
				$published_datetime = date("Y/m/d H:i:s",$published_ts);
				$title = $items[$i]['title'];
				$kind = $items[$i]['kind'];
				$activity_owner_id = $GPLUSBOT['target_id'];
				$actor_id = $items[$i]['actor']['id'];
				$actor_displayname = $items[$i]['actor']['displayName'];
				$actor_url = $items[$i]['actor']['url'];
				$actor_image = $items[$i]['actor']['image']['url'];
				$content = $items[$i]['object']['content'];
				$total_replies = $items[$i]['object']['replies']['totalItems'];
				$total_replies_api_url = $items[$i]['object']['replies']['selfLink'];
				$total_plusoners =$items[$i]['object']['plusoners']['totalItems'];
				$total_plusoners_api_url = $items[$i]['object']['plusoners']['selfLink'];
				$total_resharers = $items[$i]['object']['resharers']['totalItems'];
				$total_resharers_api_url = $items[$i]['object']['resharers']['selfLink'];
				$sql = "INSERT IGNORE INTO `axis_report_2012`.`tbl_gplus_feed` 
						(
						`feed_id`, 
						`url`, 
						`published`, 
						`published_ts`,
						published_date_time,
						`title`, 
						`kind`, 
						`activity_owner_id`, 
						`actor_id`, 
						`actor_displayname`, 
						`actor_url`, 
						`actor_image`, 
						`content`, 
						`total_replies`, 
						`total_replies_api_url`, 
						`total_plusoners`, 
						`total_plusoners_api_url`, 
						`total_resharers`, 
						`total_resharers_api_url`, 
						`retrieved_date`, 
						`n_status`
						)
						VALUES
						( 
						'{$feed_id}', 
						'{$url}', 
						'{$published}', 
						{$published_ts}, 
						'{$published_datetime}',
						'{$title}', 
						'{$kind}', 
						'{$activity_owner_id}', 
						'{$actor_id}', 
						'{$actor_displayname}', 
						'{$actor_url}', 
						'{$actor_image}', 
						'{$content}', 
						'{$total_replies}', 
						'{$total_replies_api_url}', 
						'{$total_plusoners}', 
						'{$total_plusoners_api_url}', 
						'{$total_resharers}', 
						'{$total_resharers_api_url}', 
						NOW(), 
						1
						);";
				$q = $this->query($sql);
				if($q){
					$n_item_saved++;
				}
			}else{
				$found_last_id = true;
				break;
			}
		}
		
		if(($n_items)>0){
			//print "retrieved {$n_items} feeds".PHP_EOL;
			$this->debug->log("retrieved {$n_items} feeds");
			if($found_last_id){
				//print "{$n_item_saved} feeds saved.".PHP_EOL;
				$this->debug->log("{$n_item_saved} feeds saved.");
				$this->found_last_id = true;
				$this->setLastId($items[0]['id']);
			}else{
				//print "last_id not found, so we dig deeper".PHP_EOL;
				$this->debug->log("last_id not found, so we dig deeper");
				$this->found_last_id = false;
				$this->saveUntilLastId();
			}
		}else{
			//print "no item retrieved".PHP_EOL;
			$this->debug->log("no item retrieved");
		}
	}
}
$bot = new gplus_activity();
$bot->init();
$bot->get_feeds();
?>