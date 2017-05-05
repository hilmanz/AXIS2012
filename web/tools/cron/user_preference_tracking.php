<?php
/**
 * this is the bot to analyze the contextual category of the article.
 * 
 */
include "../../config/config.inc.php";
session_start();

include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include_once 'ngram.php';
include "db.php";
class user_preference_tracking extends db{
	protected $last_id;
	protected $next_url = "";
	protected $debug;
	protected $ngram;
	protected $phrases;
	protected $categories;
	public function init(){
		$this->debug = new Debugger();
		$this->debug->setAppName('user_preference_tracking');
		$this->debug->setDirectory("../../logs/");
		// $this->debug->setVerbose(true);
		$this->ngram = new ngram(3);
		
	}
	private function getSample($filename){
		$str = file_get_contents($filename);
		return $str;
	}
	private function get_last_id(){
		$sql = "SELECT last_id 
				FROM axis_web_2012.bot_job 
				WHERE job_id='user_preference_tracking' 
				LIMIT 1";
		$rs = $this->fetch($sql);
		return intval($rs->last_id);
	}
	private function set_last_id($last_id){
		$sql = "UPDATE axis_web_2012.bot_job
				SET last_id={$last_id} 
				WHERE job_id='user_preference_tracking';";
		return $this->query($sql);
	}
	public function run(){
		//$content = $this->getSample("sample.txt");
		while(1){
			$last_id = $this->get_last_id();
			$this->debug->log("last_id : {$last_id}");
			$sql = "SELECT id,user_id,content_id FROM axis_web_2012.job_content_preference 
					WHERE id > {$last_id} AND n_status=0 ORDER BY id ASC LIMIT 50";
				// pr($sql);exit;
			$job = $this->fetch($sql,1);
			if(sizeof($job)>0){
				foreach($job as $j){
					$cat = $this->getCategory($j->content_id);
					if($cat->category_id!=null){
						$this->update_tracking($j->user_id,$j->content_id,$cat->category_id,$cat->weight);
					}else{
						$this->debug->info("no category id available for content #{$j->content_id}");
					}
					$this->flag_done($j->id);
					$last_id = $j->id;
				}
			}else{
				break;
			}
			//update last_id
			$this->set_last_id($last_id);
		}
	}
	private function flag_done($job_id){
		$job_id = intval($job_id);	
		$sql = "UPDATE `axis_web_2012`.`job_content_preference` 
				SET
				
				`n_status` = 1
				WHERE
				`id` = {$job_id};";
		return $this->query($sql);
	}
	private function update_tracking($user_id,$content_id,$category_id,$weight){
		$sql = "
				INSERT INTO `axis_web_2012`.`axis_news_content_rank` 
				(
				categoryid, 
				POINT, 
				userid, 
				DATE
				)
				VALUES
				(
				{$category_id}, 
				{$weight}, 
				{$user_id}, 
				NOW()
				)
				ON DUPLICATE KEY UPDATE
				POINT = POINT + VALUES(POINT);
				";
		
		$q = $this->query($sql);
		$this->debug->status("Update Preference #{$user_id}#{$category_id}#{$weight}",$q);
	}
	private function getCategory($content_id){
		$content_id = intval($content_id);
		$sql = "SELECT category_id,weight 
				FROM axis_web_2012.article_contextual_category 
				WHERE content_id={$content_id} 
				ORDER BY weight DESC LIMIT 1;";
		return $this->fetch($sql);
	}
}
$bot = new user_preference_tracking();
$bot->init();
$bot->run();
?>