<?php 

class lifeInAxisHelper {

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
	
	
	
	function getContent($start=0, $limit=4, $type="footer",$content=1){
		
		$start = intval($start);
		$limit = intval($limit);
		
		$sql ="SELECT * FROM axis_news_content_banner_type WHERE type ='{$type}' AND n_status=1 LIMIT 1 "; 
		$bannerType = $this->apps->fetch($sql);	
		if(!$bannerType) return false;
		$sql = "SELECT * FROM axis_news_content_banner WHERE type={$bannerType['id']} AND n_status = 1 ";
		$banner = $this->apps->fetch($sql,1);
		if(!$banner) return false;
		foreach($banner as $val){
			$arrBannerID[] = $val['parentid'];
		}
		$bannerId = implode(",",$arrBannerID) ;
		
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid,ancc.category
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		WHERE anc.parentid IN ({$bannerId}) AND anc.lid={$this->lid}
		AND anc.n_status = {$this->server} ORDER BY posted_date DESC LIMIT {$start},{$limit}
		";

		$qData = $this->apps->fetch($sql,1);
		
		$this->logger->log($sql);
		
		$totalRow = "	
				SELECT COUNT(anc.id) AS total_rows
				FROM axis_news_content anc
				LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
				WHERE anc.parentid IN ({$bannerId}) AND anc.lid={$this->lid}
				AND anc.n_status = {$this->server} ORDER BY posted_date DESC
				";
		$total = $this->apps->fetch($totalRow);
		
		$qData[0]['total_rows'] = $total['total_rows'];
		
		if(!$qData) return false;
		return $qData;
		

	}
	
	
}	

?>

