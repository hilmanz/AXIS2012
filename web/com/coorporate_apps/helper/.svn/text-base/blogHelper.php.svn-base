<?php 

class blogHelper {

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
	
	
	
	function getBlog($start=0,$limit =4){
	
			$start = intval($start);
			$limit = intval($limit);
			
			
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=0
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			$qData = $this->apps->fetch($sql,1);
			
			$row ="	SELECT COUNT(id) as total_rows FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=0
					";
			$qRow = $this->apps->fetch($row);
			if($qRow['total_rows'] != '0'){
				$qData[0]['total_rows'] = $qRow['total_rows'];
			}
			
			$this->logger->log($sql);
			if(!$qData) return false;
			$n=0;
			foreach($qData as  $val){
				$arrAuthorId[] = $val['authorid'];
				$qData[$n]['posted_date'] = date("d-m-Y",strtotime($qData[$n]['posted_date']));
				$n++;
			}	
			
			$author = $this->getAuthor($arrAuthorId);
			if($author){
				foreach($qData as $key => $val){
					if(array_key_exists($val['authorid'],$author))$qData[$key]['author'] = $author[$val['authorid']];
					else $qData[$key]['author'] = false;
				}
			}
			return $qData;
		

	}
	
	function getLatestBlog($limit=1){
			$limit = intval($limit);
			if($this->apps->_g('page')=='blog') 	$cid = intval($this->apps->_g('id'));
			else $cid = false;
			if($cid) $qIdContent = " AND parentid = {$cid} ";
			else $qIdContent = "";
			
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=0
					{$qIdContent}
					ORDER BY posted_date DESC LIMIT {$limit}
					";
		
			$qData = $this->apps->fetch($sql);
			$this->logger->log($sql);
			if(!$qData) return false;
			
			$qData['posted_date'] = date("d-m-Y",strtotime($qData['posted_date']));
			
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

