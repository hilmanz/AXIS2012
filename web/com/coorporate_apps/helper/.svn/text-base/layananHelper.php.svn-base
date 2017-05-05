<?php 

class layananHelper {

	var $uid;
		
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		// if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;
		
		$this->server = $CONFIG['VIEW_ON'];
	
	}
	
	function getLayanan($start=0,$limit =50){
		
			$sql ="	SELECT id,title FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=4
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			$qData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			if(!$qData) return false;
			
			return $qData;
		

	}
	
	function getLatestLayanan($limit =1){
		
			$limit = intval($limit);
			$cid = intval($this->apps->_p('periodeid'));
			if($cid) $qIdContent = " AND id = {$cid} ";
			else $qIdContent = "";
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=4
					{$qIdContent}
					ORDER BY posted_date DESC LIMIT {$limit}
					";
			$qData = $this->apps->fetch($sql);
			$this->logger->log($sql);
			if(!$qData) return false;
			
			return $qData;
		

	}
	

	
}	

?>

