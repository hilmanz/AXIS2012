<?php
/**
 * GPLUS Activity Daily Report
 * @author Hapsoro Renaldy <hapsoro.renaldy@kana.co.id>
 */
include "../../config/config.inc.php";
include_once "../../engines/functions.php";
include_once '../../engines/Utility/Debugger.php';
include "db.php";
class gplus_activity_report extends db{
	protected $last_id;
	protected $found_last_id = true;
	protected $next_url = "";
	protected $debug;
	public function init(){
	
		$this->debug = new Debugger();
		$this->debug->setAppName('gplus_activity_report');
		$this->debug->setDirectory("../../logs/");
		//$this->setLastId(0); //remove it in production
	}
	private function getLastId(){
		$sql = "SELECT last_id 
				FROM axis_report_2012.gplus_bot 
				WHERE job = 'gplus_daily_report' 
				LIMIT 1";
		$rs = $this->fetch($sql);
		return $rs->last_id;
	}
	private function setLastId($id){
		$sql = "UPDATE axis_report_2012.gplus_bot SET last_id='{$id}',dt_update=NOW()
				WHERE job = 'gplus_daily_report'";
		$this->query($sql);
	}
	public function generate_top_post(){
		
		$sql = "TRUNCATE TABLE axis_report_2012.tbl_gplus_top_post;";
		$q = $this->query($sql);
		$sql = "INSERT INTO `axis_report_2012`.`tbl_gplus_top_post` 
				(
				`gplus_feeds_id`, 
				`num`, 
				`n_status`
				)
				SELECT id,total_plusoners AS num,1 AS n_status 
				FROM axis_report_2012.tbl_gplus_feed 
				ORDER BY total_plusoners DESC LIMIT 100;";
		$q = $this->query($sql);
		if($q){
			$this->debug->log('regen top post --> OK');
		}else{
			$this->debug->log('regen top post --> FAILED');
		}
	}
	public function generate(){
		if($last_id==NULL){
			$last_id = intval($this->getLastId());
		}
		$this->debug->log("last_id : {$last_id}");
		$start_id = $last_id+1;
		$sql = "SELECT id,DATE(FROM_UNIXTIME(published_ts)) AS tgl,
				total_plusoners AS plusone,
				total_resharers AS resharers,
				total_replies AS replies
				FROM axis_report_2012.tbl_gplus_feed 
				WHERE id > {$last_id} 
				ORDER BY id ASC
				LIMIT 10;";
		$rs = $this->fetch($sql,1);
		if(sizeof($rs)>0){
			foreach($rs as $r){
				$last_id = $r->id;
				$sql = "INSERT INTO axis_report_2012.tbl_gplus_daily
						(date,plusone,share,comment,n_status)
						VALUES('{$r->tgl}',{$r->plusone},{$r->resharers},{$r->replies},1)
						ON DUPLICATE KEY UPDATE
						plusone=plusone+VALUES(plusone),
						share=share+VALUES(share),
						comment=comment+VALUES(comment);
						";
				$this->debug->log($sql);
				$q = $this->query($sql);
				if($q){
					$this->debug->log("{$r->tgl}',{$r->plusone},{$r->resharers},{$r->replies},1 --> OK");
				}else{
					$this->debug->log("{$r->tgl}',{$r->plusone},{$r->resharers},{$r->replies},1 --> FAILED");
				}
			}
			$this->setLastId($last_id);
			$this->generate();
		}
	}
	
}
$bot = new gplus_activity_report();
$bot->init();
$bot->generate();
$bot->generate_top_post();
?>