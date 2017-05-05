<?php 

class divisiHelper {
	var $uid;
	
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		// if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;		
		$this->server = intval($CONFIG['VIEW_ON']);	
	}
	
	function getBlogCoorporate($start=0,$limit =20){
		$start = intval($start);
		$limit = intval($limit);
		$sql ="	SELECT * FROM  axis_coorporate_blog WHERE type=6 AND lid={$this->lid} ORDER BY posted_date DESC LIMIT {$start},{$limit}";
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		if(!$qData) return false;	
		return $qData;
	}
}
?>

