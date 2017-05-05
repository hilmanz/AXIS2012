<?php
/**
 * generating the top keyword for gplus data
 * the bot is run under cronjob daily.
 */
include_once "../../config/config.inc.php";
include_once "common.php";
include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include "db.php";
class fb_wordcloud extends db{
	protected $last_id;
	protected $found_last_id = true;
	protected $next_url = "";
	protected $debug;
	public function init(){
		$this->debug = new Debugger();
		$this->debug->setAppName('fb_wordcloud');
		$this->debug->setDirectory("../../logs/");
		$this->debug->log('bot started at '.date("Y-m-d H:i:s").' in process #'.getmypid());
		//test purpose only
		/*
		$sql = "UPDATE `axis_report_2012`.`gplus_bot` 
					SET
					`last_id` = 0 , 
					`dt_update` = NOW()
					WHERE
					job='fb_wordcloud';";
		$this->query($sql);
		//---> test purpose
		 * 
		 */
	}
	public function update_wordcloud(){
		do{
			$last_id = $this->get_last_id();
			$this->debug->log('last_id : '.$last_id);
			$rs = $this->retrieve_feeds($last_id);
			$this->debug->log("retrieving feeds, {$rs['total']} feeds, new last_id : {$rs['last_id']}");
			$this->populate_wordlist($rs['feeds']);
			
		}while($rs['total']>0);
	}
	private function retrieve_feeds($last_id){
		$sql = "SELECT 
				id, 
				message as content	 
				FROM 
				axis_report_2012.fb_page_posts
				WHERE id > {$last_id} ORDER BY id ASC
				LIMIT 0, 10;";
		$rs = $this->fetch($sql,1);
		$n = sizeof($rs);
		if($n>0){
			$last_id = intval($rs[$n-1]->id);			
			$this->set_last_id($last_id);
		}
		return array("last_id"=>$last_id,'feeds'=>$rs,'total'=>$n);
	}
	private function populate_wordlist($data){
		foreach($data as $d){
			$words = explode(',',extract_words(strip_tags($d->content)));
			$this->add_keyword($words);
			unset($words);
		}
		
	}
	private function add_keyword($words){
		if(is_array($words)){
			foreach($words as $keyword){
				$keyword = mysql_escape_string($keyword);
				if(strlen($keyword)>2){
					$sql = "INSERT INTO `axis_report_2012`.`tbl_fb_wordcloud` 
							( 
							`keyword`, 
							`total`
							)
							VALUES
							( 
							'{$keyword}', 
							1
							)
							ON DUPLICATE KEY UPDATE
							total = total + VALUES(total);";
					$q = $this->query($sql);
					$this->debug->status("Insert Keyword '{$keyword}'",$q);
				}
			}
		}
	}
	private function get_last_id(){
		$sql = "SELECT last_id
				FROM 
				`axis_report_2012`.`gplus_bot` 
				WHERE job = 'fb_wordcloud'
				LIMIT 1;";
		$rs = $this->fetch($sql);
		return intval($rs->last_id);
	}
	private function set_last_id($last_id){
		if($last_id>0){
			$sql = "UPDATE `axis_report_2012`.`gplus_bot` 
					SET
					`last_id` = {$last_id} , 
					`dt_update` = NOW()
					WHERE
					job='fb_wordcloud';";
			return $this->query($sql);
		}
	}
}
$bot = new fb_wordcloud();
$bot->init();
$bot->update_wordcloud();
?>