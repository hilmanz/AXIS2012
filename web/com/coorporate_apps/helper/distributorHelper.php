<?php 

class distributorHelper {

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
	
	
	
	function getDistributorResmi($start=0,$limit =4,$arrData=null){
			
			if($arrData==null) $qArea  = "";
			else {
			
			$provinceid = intval($arrData['province']);
			$cityid = intval($arrData['city']);
			
			$start = intval($start);
			$limit = intval($limit);
			
			if($provinceid!=0) $sql = " SELECT * FROM axis_city_reference WHERE provinceid = {$provinceid} ";
			$qData = $this->apps->fetch($sql,1);
				if($qData) {
					foreach($qData as $val){
						$arrCity[] = $val['id'];
					}
					
					$cityid = implode(',',$arrCity);
					$qArea = " AND  cityid IN ({$cityid}) ";
				}else $qArea = "";
			}
		
			$sql ="	SELECT * FROM  axis_news_content 
					WHERE n_status = 1 AND lid={$this->lid} AND articleType=24
					{$qArea}
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			
			$qData = $this->apps->fetch($sql,1);
			// pr($qData);
			$this->logger->log($sql);
			if(!$qData) return false;
			
			return $qData;
		

	}
	
	function getProvince($type=null){
		if($type=='default'){
			$filter = 'WHERE id <> 3';
			$default = "SELECT * FROM axis_province_reference WHERE id = 3";
			$qDefault = $this->apps->fetch($default);
		}else{
			$filter = '';
		}
		
		if($type=='default'){$filterProvince = 'AND id NOT IN (8,11,15,12,17,18,20,21,22,23,25,26,27,28)';}
		else{$filterProvince = '';}
		
		
		$sql ="SELECT * FROM axis_province_reference {$filter} {$filterProvince}";
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		if($type=='default'){
			array_unshift($qData, $qDefault);
		}
		
		if(!$qData) return false;
		return $qData;
	}
	function getCity($province, $type=null){
		if($type=='default'){
			$filter = 'AND id <> (71,72,73,73)';
		}else{
			$filter = '';
		}
		if($type=='default' || $province == 3){
			$sql = "SELECT * FROM axis_city_reference WHERE id = 13";
			$qData = $this->apps->fetch($sql,1);
		}else{
			$sql ="SELECT * FROM axis_city_reference WHERE provinceid={$province} {$filter}";
			$qData = $this->apps->fetch($sql,1);
		}
		$this->logger->log($sql);
		
		
		
		if(!$qData) return false;
		return $qData;
	}
	
	function getDistributor($search=null,$start=0,$limit=7,$id=null,$cityID=null){
	
		if($cityID!=null) $cityAdd = " AND cityid = {$cityID}";
		else $cityAdd = "";
		$start = intval($start);
		$limit = intval($limit);
		
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid 
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE anc.articleType IN (24)  AND
		anc.n_status = 0 AND anc.lid = 1	
		{$cityAdd} ORDER BY parentid LIMIT {$start},{$limit}
		";
		// pr($sql);
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		//total
		$sql = "	
		SELECT count(*) total
		FROM axis_news_content anc
		WHERE anc.articleType IN (24)  AND
		anc.n_status = {$this->server} AND anc.lid = {$this->lid} 	
		{$cityAdd} ORDER BY parentid 
		";
		
		$tData = $this->apps->fetch($sql);
		$total = $tData['total'];
		if(!$qData) return false;
		
		foreach($qData as $key => $val){
			$qData[$key]['total_rows'] = $total;
		}
		return $qData;
	}
	
	function getLatestBlog($limit=1){
			
			$limit = intval($limit);
			
			$cid = intval($this->apps->_g('id'));
			if($cid) $qIdContent = " AND id = {$cid} ";
			else $qIdContent = "";
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=0
					{$qIdContent}
					ORDER BY posted_date DESC LIMIT {$limit}
					";
			$qData = $this->apps->fetch($sql);
			$this->logger->log($sql);
			if(!$qData) return false;
					
			$author = $this->getAuthor($qData['authorid']);
			if($author){
				
				if(array_key_exists($qData['authorid'],$author))$qData['author'] = $author[$qData['authorid']];
				else $qData['author'] = false;
				
			}
			return $qData;
	
	}
	
	
	function getAuthor($aid=null){
		if($aid== null) return false;
		if(is_array($aid)) $strAid = implode(',',$aid);
		else $strAid = $aid;
		if($strAid=='') return false;
		$sql = "SELECT * FROM gm_user WHERE userID IN ({$strAid}) ";
	
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		if(!$qData) return false;	
			foreach($qData as $val){
				$arrAuthor[$val['userID']]= $val;
			}
			return $arrAuthor;
		
	}
	
}	

?>

