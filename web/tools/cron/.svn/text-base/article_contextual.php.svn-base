<?php
/**
 * this is the bot to analyze the contextual category of the article.
 * 
 */
include "../../config/config.inc.php";
// include_once "common.php";
session_start();

include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include_once 'ngram.php';
include "db.php";
class article_contextual extends db{
	protected $last_id;
	protected $next_url = "";
	protected $debug;
	protected $ngram;
	protected $phrases;
	protected $categories;
	public function init(){
		$this->debug = new Debugger();
		$this->debug->setAppName('article_contextual');
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
				WHERE job_id='article_contextual' 
				LIMIT 1";
		$rs = $this->fetch($sql);
		return intval($rs->last_id);
	}
	private function set_last_id($last_id){
		$sql = "UPDATE axis_web_2012.bot_job
				SET last_id={$last_id} 
				WHERE job_id='article_contextual';";
		return $this->query($sql);
	}
	public function run(){
		//$content = $this->getSample("sample.txt");
		while(1){
			$last_id = $this->get_last_id();
			$this->debug->log("last_id : {$last_id}");
			$sql = "SELECT id,title,brief,content FROM axis_web_2012.axis_news_content WHERE id > {$last_id} ORDER BY id ASC LIMIT 50";
			$posts = $this->fetch($sql,1);
			if(sizeof($posts)>0){
				foreach($posts as $p){
					$content = $p->title." ".$p->brief." ".$p->content;
					//$this->debug->log($content);
					$this->ngram->analyze($content);
					$this->phrases = $this->ngram->getResults();
					$this->get_category();
					$this->assign_category($p->id);
					$this->clear_everything();
					$last_id = $p->id;
				}
			}else{
				break;
			}
			//update last_id
			$this->set_last_id($last_id);
		}
	}
	private function clear_everything(){
		unset($this->categories);
	}
	private function assign_category($content_id){
		if(is_array($this->categories)){
			foreach($this->categories as $n=>$v){
				$sql = "INSERT IGNORE INTO axis_web_2012.article_contextual_category
						(content_id,category_id,weight)
						VALUES
						({$content_id},{$n},{$v})";
				$q = $this->query($sql);
				$this->debug->status("inserting {$content_id}#{$n}#{$v}",$q);
			}
		}
	}
	private function get_category_id(){
		$category_id=0;
		$occurance = 0;
		if(is_array($this->categories)){
			foreach($this->categories as $c=>$v){
				$v = intval($v);
				if($v>$occurance){
					$occurance = $v;
					$category_id = $c;
				}
			}
		}
		return $category_id;
	}
	private function get_category(){
		if(is_array($this->phrases)){
			$s = "";
			$n=0;
			$n_total = sizeof($this->phrases);
			foreach($this->phrases as $kw=>$occurance){
				if($n>0){
					$s.=",";
				}
				$n=1;
				$s.="'{$kw}'";
			}
			$sql = "SELECT keyword,category_id,category_name FROM axis_web_2012.category_keywords 
					WHERE keyword IN ({$s}) LIMIT {$n_total}";
					// pr($sql);
			$result = $this->fetch($sql,1);
			if(is_array($result)){
				foreach($result as $r){
					$word = trim($r->keyword);
					$category_id = $r->category_id;
					if(!isset($this->categories[$category_id])){
						$this->categories[$category_id] = 0;
					}	
					foreach($this->phrases as $kw=>$occurance){
						if(strcmp(trim($kw),$word)==0){
							$chunk = explode(" ",$word);
							$this->categories[$category_id]+=$occurance*sizeof($chunk);
						}
					}
				}
			}
			
			unset($result);
			unset($this->phrases);
		}
	}
}
$bot = new article_contextual();
$bot->init();
$bot->run();
?>