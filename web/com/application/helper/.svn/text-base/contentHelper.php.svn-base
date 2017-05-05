<?php 
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Mobile_Detect.php";
class contentHelper {

	var $uid;
	var $osDetect;
	
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;

		$this->apps = $apps;
		if($this->apps->isUserOnline())  {
			if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
			
		}
		
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;
		if($this->lid=='')$this->lid=1;
		$this->server = strip_tags($CONFIG['VIEW_ON']);
		$this->osDetect = new Mobile_Detect;
	}
	
	function getPublicContent($start=null,$limit=2, $category=null){
		if($start==null)$start = intval($this->apps->_p('start'));
		
		if($category == null){
			$category = intval($this->apps->_request('cid'));
		}
		$limit = intval($limit);
		
		
		$acts = strip_tags($this->apps->_g('act'));
		$cid = intval($this->apps->_g('id'));
		$qContentCid = "";
		$qSocialCid = "";
		if($acts=='detail'){
				if($cid!=0) $qContentCid = " AND anc.id <> {$cid}"; 
				
		}else{
				if($cid!=0) $qSocialCid = " AND snc.id <> {$cid}"; 				
		}
		
		if($category!=0) $qCategory = " AND categoryid={$category} ";
		else $qCategory = "";
		
		$sql ="
		SELECT count(*) total
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE 
		anc.articleType IN (2) AND
		anc.n_status IN ({$this->server}) AND anc.lid = 1	
		{$qCategory}
		ORDER BY posted_date DESC ";
		
	
		$this->logger->log($sql);
		$contenttotal = $this->apps->fetch($sql);
	
		$sql ="
		SELECT  count(*) total
		FROM social_news_content snc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
		WHERE n_status IN ({$this->server})  {$qCategory}";
		$this->logger->log($sql);
		$usercontenttotal = $this->apps->fetch($sql);
		
		//count total record
		if(array_key_exists('total',$contenttotal)) $totalcontent = intval($contenttotal['total']);
		else $totalcontent = 0;
		if(array_key_exists('total',$usercontenttotal)) $totalusercontent = intval($usercontenttotal['total']);
		else $totalusercontent = 0;
		
		$totals = $totalcontent + $totalusercontent;
		$total['total']  = intval($totals);
		
		if(intval($total['total'])<=$limit) $start = 0;
		
		//get the limit both of you
		if($totalusercontent<$start) $contentLimit = $limit + $limit;
		else  $contentLimit = $limit;
		if($totalcontent<$start) $socialContentLimit = $limit + $limit;
		else  $socialContentLimit = $limit;
		$sql ="
		(
		SELECT anc.id,ancc.category,anc.title,anc.image,anc.posted_date ,anc.categoryid, anc.online,anc.url,anc.parentid,anc.authorid,anc.brief, 'content' as articlefrom
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE 
		anc.articleType IN (2) AND
		anc.n_status IN ({$this->server}) AND anc.lid = 1 	{$qContentCid}
		{$qCategory}
			ORDER BY posted_date DESC LIMIT {$start},{$contentLimit}
		)
		UNION 
		(
			SELECT snc.id,ancc.category,snc.title,snc.image,snc.posted_date ,snc.categoryid,'' as online, snc.url,snc.id as parentid,snc.userid as authorid,snc.brief, 'social' as articlefrom
			FROM social_news_content snc
			LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
			WHERE n_status IN ({$this->server})  {$qCategory} {$qSocialCid}
			ORDER BY posted_date DESC LIMIT {$start},{$socialContentLimit}
		)
			ORDER BY posted_date DESC 
		
		";
		$this->logger->log($sql);
		// pr($sql);
		$rqData= $this->apps->fetch($sql,1);
			$cidArr=false;
			$rawDataSocial = false;
		
		if($rqData) {
		
			foreach($rqData as $key => $val){
				if($val['articlefrom']=='content'){
					$cidArr[] = $val['parentid'];
					$authorArr[] = $val['authorid'];
					$qData["0_{$key}"] = $val;
					$qData["0_{$key}"]['ts'] = strtotime($val['posted_date']);
					$qData["0_{$key}"]['user'] = false;
					$qData["0_{$key}"]['comment'] = false;
					$qData["0_{$key}"]['rating'] = false;
					$qData["0_{$key}"]['author'] = false;
				}else{
					$rawDataSocial[$key] = $val;
				}
			}
		}	
			
			if($cidArr){
				$cidStr = implode(",",$cidArr);
				$ratingData = $this->getRating($cidStr);
				$authorStr = implode(",",$authorArr);
				$authorprofile = $this->getAuthorProfile($authorStr);
				
				if($ratingData){
					
					foreach($qData as $key => $val){
						if(array_key_exists($val['parentid'],$ratingData)) $qData[$key]['rating'] = $ratingData[$val['parentid']];
						
					
					}
				
				}
				
				//comment di list article di takeout dulu
				$commentsData = $this->getComment($cidStr);
				if($commentsData){
					foreach($qData as $key => $val){
						if(array_key_exists($val['parentid'],$commentsData)) $qData[$key]['comment'] = count($commentsData[$val['parentid']]);
						
					
					}
					
				}
				
				if($authorprofile){
					foreach($qData as $key => $val){
								if(array_key_exists($val['authorid'],$authorprofile)) $qData[$key]['author'] = $authorprofile[$val['authorid']];
							
					}
				}
			}
		
		//get User Article (MY article)
		if($rawDataSocial){
		$sData = $this->apps->sharePostHelper->getSocialStatArticle($rawDataSocial);
		}else $sData = false;
		if($sData){
			foreach($sData as $key => $val){
				$qData["1_{$key}"] = $val;		
			}
		}
			
		if(!$qData) return false;
		
		//parseurl for video thumb
		foreach($qData as $key => $val){
		
			if($val['categoryid']==18)	{
			//parser url and get param data
				$parseUrl = parse_url($val['url']);
				if(array_key_exists('query',$parseUrl)) parse_str($parseUrl['query'],$parseQuery);
				else $parseQuery = false;
				if($parseQuery) {
					if(array_key_exists('v',$parseQuery))$video_thumbnail = $parseQuery['v'];
					else $video_thumbnail= false;
				}else $video_thumbnail = false;
				$qData[$key]['video_thumbnail'] = $video_thumbnail;
			}else $qData[$key]['video_thumbnail'] = false;
		}
		// pr($qData);
		//sortings-----------------------
		//popular,terbaru,terbaik
		$typeFilter = intval($this->apps->_request('type'));
		
		//popular:default
		if($commentsData){
			usort($qData, function($a, $b) {
				return $b['comment'] - $a['comment'];
			});
		}
		//terbaru	
		if($typeFilter==2) {
			usort($qData, function($a, $b) {
				return $b['ts'] - $a['ts'];
			});
		}
		//terbaik
		if($ratingData){
			if($typeFilter==3) {
				usort($qData, function($a, $b) {
					return $b['rating'] - $a['rating'];
				});
			}
		}
		
		
		
		//total rows
		$qData[0]['total_rows'] = intval($total['total']);
		
		
		
		return $qData;
		
		
	}
	
		
	function getContent($start=null,$limit=2,$category=null){
		if($start==null)$start = intval($this->apps->_p('start'));
		if($category == null){
			$category = intval($this->apps->_request('cid'));
		}
		
		$limit = intval($limit);
		
		$acts = strip_tags($this->apps->_g('act'));
		$cid = intval($this->apps->_g('id'));
		$qContentCid = "";
		$qSocialCid = "";
		if($acts=='detail'){
				if($cid!=0) $qContentCid = " AND anc.id <> {$cid}"; 
				
		}else{
				if($cid!=0) $qSocialCid = " AND snc.id <> {$cid}"; 				
		}
		
				
		if($category!=0) $qCategory = " AND categoryid={$category} ";
		else $qCategory = "";
		
		
		
		$sql = "
		SELECT sum(point) rank,categoryid 
		FROM axis_news_content_rank 
		WHERE userid={$this->uid} 
		GROUP BY categoryid ORDER BY rank DESC LIMIT 10 ";
		$qData = $this->apps->fetch($sql,1);
		$priority = false;
			
		if($qData) {
			foreach($qData as $val){
				$priority[$val['categoryid']]['rank'] = $val['rank'];
				$priority[$val['categoryid']]['categoryid'] = $val['categoryid'];
			}
		}
		$qData = false;
		$this->logger->log($sql);
		
		$sql ="
		SELECT count(*) total
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE 
		anc.articleType IN (2) AND
		anc.n_status IN ({$this->server}) AND anc.lid = 1
		{$qCategory}
		ORDER BY posted_date DESC ";
		$this->logger->log($sql);	
		$contenttotal = $this->apps->fetch($sql);
	
		$sql ="
		SELECT  count(*) total
		FROM social_news_content snc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
		WHERE n_status IN ({$this->server})  {$qCategory}";
		$this->logger->log($sql);
		$usercontenttotal = $this->apps->fetch($sql);
		
		//count total record
		if(array_key_exists('total',$contenttotal)) $totalcontent = intval($contenttotal['total']);
		else $totalcontent = 0;
		if(array_key_exists('total',$usercontenttotal)) $totalusercontent = intval($usercontenttotal['total']);
		else $totalusercontent = 0;
		
		$totals = $totalcontent + $totalusercontent;
		$total['total']  = intval($totals);
		
		if(intval($total['total'])<=$limit) $start = 0;
		
		//get the limit both of you
		if($totalusercontent<$start) $contentLimit = $limit + $limit;
		else  $contentLimit = $limit;
		if($totalcontent<$start) $socialContentLimit = $limit + $limit;
		else  $socialContentLimit = $limit;
		
		$sql ="
		(
		SELECT anc.id,ancc.category,anc.title,anc.image,anc.posted_date ,anc.categoryid, anc.online,anc.url,anc.parentid,anc.authorid,anc.brief, 'content' as articlefrom
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE 
		anc.articleType IN (2) AND
		anc.n_status IN ({$this->server}) AND anc.lid = 1 	{$qContentCid}
		{$qCategory}
			ORDER BY posted_date DESC LIMIT {$start},{$contentLimit}
		)
		UNION 
		(
			SELECT snc.id,ancc.category,snc.title,snc.image,snc.posted_date ,snc.categoryid,'' as online, snc.url,snc.id as parentid,snc.userid as authorid,snc.brief, 'social' as articlefrom
			FROM social_news_content snc
			LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
			WHERE n_status IN ({$this->server})  {$qCategory} {$qSocialCid}
			ORDER BY posted_date DESC LIMIT {$start},{$socialContentLimit}
		)
			ORDER BY posted_date DESC 
		
		";
		
		$this->logger->log($sql);	
		
		$rqData = $this->apps->fetch($sql,1);
		$ratingData = false;
		$commentsData = false;
		$authorprofile = false;
		$rawDataSocial = false;
		$cidArr = false;
		if($rqData) {
		
		foreach($rqData as $key => $val){
			if($val['articlefrom']=='content'){
				$cidArr[] = $val['parentid'];
				$authorArr[] = $val['authorid'];
				$qData["0_{$key}"] = $val;
				$qData["0_{$key}"]['ts'] = strtotime($val['posted_date']);
				$qData["0_{$key}"]['rating'] = false;
				$qData["0_{$key}"]['comment'] = false;
				$qData["0_{$key}"]['author'] = false;
				$qData["0_{$key}"]['user'] = false;
				}else{
					$rawDataSocial[$key] = $val;
				}
			}
		}
			if($cidArr) {
				$cidStr = implode(",",$cidArr);
				$authorStr = implode(",",$authorArr);
				$ratingData = $this->getRating($cidStr);
				$authorprofile = $this->getAuthorProfile($authorStr);
				if($ratingData){
					
					foreach($qData as $key => $val){
						if(array_key_exists($val['parentid'],$ratingData)) $qData[$key]['rating'] = $ratingData[$val['parentid']];
				
					
					}
				
				}
				
				$commentsData = $this->getComment($cidStr);
				if($commentsData){
					foreach($qData as $key => $val){
						if(array_key_exists($val['parentid'],$commentsData)) $qData[$key]['comment'] = count($commentsData[$val['parentid']]);
					
					
					}
				}
				
				if($authorprofile){
					foreach($qData as $key => $val){
								if(array_key_exists($val['authorid'],$authorprofile)) $qData[$key]['author'] = $authorprofile[$val['authorid']];
								
					}
				}
			}
		
				
		/*
		foreach($qData as $key => $val){
			if($priority){
				if(array_key_exists($val['categoryid'],$priority)){
					if($val['categoryid']==$priority[$val['categoryid']]['categoryid']) {
						$getData[$priority[$val['categoryid']]['rank'].$val['parentid']] = $val;
					}else $getData[$val['parentid']]  = $val;
				}else $getData[$val['parentid']]  = $val;
			}else $getData[$val['parentid']]  = $val;
		}
		*/
		
		
		//get User Article (MY article)
		if($rawDataSocial){
		$sData = $this->apps->sharePostHelper->getSocialStatArticle($rawDataSocial);
		}else $sData = false;
	
		if($sData){
			foreach($sData as $key => $val){
				$qData["1_{$key}"] = $val;		
			}
		}
		if(!$qData) return false;
		

		// pr($qData);
		foreach($qData as $key => $val){
			if($priority){
				if(array_key_exists($val['categoryid'],$priority)){
					if($val['categoryid']==$priority[$val['categoryid']]['categoryid']) {
						$qData[$key]['priority'] = $priority[$val['categoryid']]['rank'];
					}else $qData[$key]['priority']  = false;
				}else  $qData[$key]['priority']  = false;
			}else $qData[$key]['priority']  = false;
			
					//parseurl for video thumb
			if($val['categoryid']==18)	{
			//parser url and get param data
				$parseUrl = parse_url($val['url']);
				if(array_key_exists('query',$parseUrl)) parse_str($parseUrl['query'],$parseQuery);
				else $parseQuery = false;
				if($parseQuery) {
					if(array_key_exists('v',$parseQuery))$video_thumbnail = $parseQuery['v'];
					else $video_thumbnail= false;
				}else $video_thumbnail = false;
				$qData[$key]['video_thumbnail'] = $video_thumbnail;
			}else $qData[$key]['video_thumbnail'] = false;
		}
		
		//priority/preferences user
		if($priority){
		
				usort($qData, function($a, $b) {
						return $b['priority'] - $a['priority'];
				});
			
			
		}
		//popular,terbaru,terbaik
		$typeFilter = intval($this->apps->_request('type'));
		
		//popular:default
		if($commentsData){
			if($typeFilter==1) {
			
				usort($qData, function($a, $b) {
						return $b['comment'] - $a['comment'];
				});
			// pr($qData);exit;
			}
		}
		//terbaru	
		if($typeFilter==2) {
			usort($qData, function($a, $b) {
				return $b['ts'] - $a['ts'];
			});
		}
		//terbaik
		if($ratingData){
			if($typeFilter==3) {
				usort($qData, function($a, $b) {
					return $b['rating'] - $a['rating'];
				});
			}
		}
		//total rows
		$qData[0]['total_rows'] = intval($total['total']);
		
		// pr($qData);
		
		return $qData;
		
	}
	

	
	function getAuthorProfile($aid=null){
		if($aid==null) return false;
		
		$sql = "SELECT position ,	name, 	email, 	emblem, userID,	username FROM gm_user WHERE userID IN ({$aid}) LIMIT 10 ";
		
		$data = $this->apps->fetch($sql,1);
		if(!$data) return false;
		
		foreach($data as $val){
			if(array_key_exists('userID',$val)) $arrData[$val['userID']] = $val;
		
		}
		if(!isset($arrData)) return false;
		return $arrData;
	}
		
	function getDetailAxisArticle(){
		$cid = intval($this->apps->Request->getParam('id'));
		$sql = "
		SELECT parentid FROM axis_news_content anc WHERE 
		anc.n_status IN ({$this->server}) AND anc.id={$cid} LIMIT 1 
		";
		
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		
		$sql = "
		SELECT anc.id,ancc.category,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,ancc.point,anc.prize,anc.url,anc.parentid,anc.sourceurl,anc.authorid
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		WHERE anc.n_status IN ({$this->server}) AND anc.parentid={$qData['parentid']} AND anc.lid = 1 LIMIT 1 ";
		// pr($sql);
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		if($this->uid && $qData){
		
				// $sql ="
				// INSERT INTO axis_news_content_rank (categoryid ,	point, 	userid ,	date) 
				// VALUES ({$qData['categoryid']},{$qData['point']},{$this->uid},NOW())
				
				// ";
				// $this->apps->query($sql);
				
				//job buat bot tracking user preference
				$sql ="
				INSERT INTO job_content_preference (user_id ,	content_id, 	n_status) 
				VALUES ({$this->uid},{$qData['id']},0)
				
				";
				
				$this->apps->query($sql);
		
	
		}
		
		if($qData){
			
				
		
				$cidStr = $qData['parentid'];
				$ratingData = $this->getRating($cidStr);
				$commentsData = $this->getComment($cidStr);
				$favoriteData = $this->getFavorite($cidStr);
				$authorprofile = $this->getAuthorProfile($qData['authorid']);
				$userRate = $this->getUserRating($cidStr,$this->uid);
				
				if($userRate){
					$qData['myRate'] = $userRate[$cidStr][$this->uid];
				}else $qData['myRate'] = false;
				
				if($ratingData){
					
					
						if(array_key_exists($qData['parentid'],$ratingData)) $qData['rating'] = $ratingData[$qData['parentid']];
						else $qData['rating'] = false;
					
				
				}
				
				if($commentsData){
		
					
						if(array_key_exists($qData['parentid'],$commentsData)) {
							$qData['comment'] = $commentsData[$qData['parentid']];
							$qData['total_comment'] = $this->getComment($cidStr,true);
						}else {
							$qData['comment'] = false;
							$qData['total_comment'] = false ;
						}
				}
				
				if($favoriteData){
						if(array_key_exists($qData['parentid'],$favoriteData)) $qData['favorite'] = $favoriteData[$qData['parentid']];
						else $qData['favorite'] = false;
				}
				
				if($authorprofile){
						if(array_key_exists($qData['authorid'],$authorprofile)) $qData['author'] = $authorprofile[$qData['authorid']];
						else $qData['author'] = false;
				}
				
				$arrSourceUrl = parse_url($qData['sourceurl']);
				if($arrSourceUrl) {
					if(array_key_exists('host',$arrSourceUrl))$qData['title_url'] = $arrSourceUrl['host'];
					else  $qData['title_url'] = false;
				}
		}
// pr($qData);exit;
		return $qData;
	
	}
	
	function getDetailContent(){
		$cid = intval($this->apps->Request->getParam('id'));
		$sql = "
		SELECT parentid FROM axis_news_content anc WHERE 
		anc.n_status IN ({$this->server}) AND anc.id={$cid} LIMIT 1 
		";
		
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		
		$sql = "
		SELECT anc.id,ancc.category,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,ancc.point,anc.prize,anc.url,anc.parentid,anc.authorid,anc.sourceurl
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		WHERE anc.n_status IN ({$this->server}) AND anc.parentid={$qData['parentid']} AND anc.lid = {$this->lid} LIMIT 1 ";
		// pr($sql);
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		if($this->uid && $qData){
		
				// $sql ="
				// INSERT INTO axis_news_content_rank (categoryid ,	point, 	userid ,	date) 
				// VALUES ({$qData['categoryid']},{$qData['point']},{$this->uid},NOW())
				
				// ";
				// $this->apps->query($sql);
				
				//job buat bot tracking user preference
				$sql ="
				INSERT INTO job_content_preference (user_id ,	content_id, 	n_status) 
				VALUES ({$this->uid},{$qData['id']},0)
				
				";
				
				$this->apps->query($sql);
		
	
		}
		
		if($qData){
			
		
				$cidStr = $qData['parentid'];
				$ratingData = $this->getRating($cidStr);
				$commentsData = $this->getComment($cidStr);
				$favoriteData = $this->getFavorite($cidStr);
				$authorprofile = $this->getAuthorProfile($qData['authorid']);
				$popuparticle = $this->getPopupArticle($cidStr);
				if($ratingData){
					
					
						if(array_key_exists($qData['parentid'],$ratingData)) $qData['rating'] = $ratingData[$qData['parentid']];
						else $qData['rating'] = false;
					
				
				}
				
				if($commentsData){
		
					
						if(array_key_exists($qData['parentid'],$commentsData)) {
							$qData['comment'] = $commentsData[$qData['parentid']];
							$qData['total_comment'] = $this->getComment($cidStr,true);
						}else {
							$qData['comment'] = false;
							$qData['total_comment'] = false ;
						}
				}
				
				if($favoriteData){
						if(array_key_exists($qData['parentid'],$favoriteData)) $qData['favorite'] = $favoriteData[$qData['parentid']];
						else $qData['favorite'] = false;
				}
				
				
				if($authorprofile){
						if(array_key_exists($qData['authorid'],$authorprofile)) $qData['author'] = $authorprofile[$qData['authorid']];
						else $qData['author'] = false;
				}
				if($popuparticle){
						if(array_key_exists($qData['parentid'],$popuparticle)) $qData['popuparticle'] = $popuparticle[$qData['parentid']];
						else $qData['popuparticle'] = false;
				}
				
				$arrSourceUrl = parse_url($qData['sourceurl']);
				if($arrSourceUrl) {
					if(array_key_exists('host',$arrSourceUrl))$qData['title_url'] = $arrSourceUrl['host'];
					else  $qData['title_url'] = false;
				}
		}

		return $qData;
	
	}
	
	function getFavorite($cid=null){
		if($cid==null) return false;
		$sql ="
		SELECT count(*) total, contentid FROM social_bookmark sb 
		WHERE content=0
		AND contentid IN ({$cid}) 
		GROUP BY contentid ";
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		foreach($qData as $val){
			$arrData[$val['contentid']] = $val['total'];
		}	
		if($arrData) return $arrData;
		return false;
	}
	
	function getFavoriteUrl($cid=null,$content=2){
		if($cid==null) return false;
		$sql="
		SELECT count(*) total, contentid,url FROM social_bookmark sb 
		WHERE content={$content}
		AND contentid IN ({$cid}) 
		GROUP BY contentid ";
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		foreach($qData as $val){
			$arrData[$val['contentid']] = $val['total'];
		}	
		if($arrData) return $arrData;
		return false;
	}
	
	
	function saveRating(){
	
		$cid = intval($this->apps->_p('cid'));
		$rate = intval($this->apps->_p('rate'));
		$uid = intval($this->uid);
		if($cid!=0 && $uid!=0){
			$sql ="
					INSERT INTO axis_news_content_rating (userid,contentid,rate,date,n_status) 
					VALUES ({$uid},{$cid},{$rate},NOW(),1)
					";
			$this->apps->query($sql);
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()>0) return true;
			
		}
		return false;
	}
	
	
	function saveRatingSocial(){
		$cid = intval($this->apps->_p('cid'));
		$rate = intval($this->apps->_p('rate'));
		$uid = intval($this->uid);
	
		if($cid!=0 && $uid!=0){
			$sql ="
					INSERT INTO social_news_content_rating (userid,contentid,rate,date,n_status) 
					VALUES ({$uid},{$cid},{$rate},NOW(),1)
					";
			$this->apps->query($sql);
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()>0) return true;
			
		}
		return false;
	}
	
	
	function getRating($cid=null){
		if($cid==null) $cid = $this->apps->_p('cid');
		if($cid){
			$cidin = " AND contentid IN ({$cid}) ";
		}
			$sql ="
					SELECT FLOOR(avg(rate)) avgtotal,contentid FROM axis_news_content_rating WHERE n_status=  1 {$cidin}  GROUP BY contentid
					";
				$qData = $this->apps->fetch($sql,1);
				if($qData) {
					$this->logger->log("have rate");
					foreach($qData as $val){
						$ratingData[$val['contentid']]=$val['avgtotal'];
					}
						return $ratingData;
				}
		return false;
			
			
	}
	
	function getUserRating($cid=null,$uid=null){
		if($cid==null) return false;
		if($uid==null) return false;
			$sql ="
					SELECT rate ,userid,contentid FROM axis_news_content_rating WHERE n_status=  1 AND contentid  IN ({$cid})  AND userid IN ({$uid}) ";
				$qData = $this->apps->fetch($sql,1);
				if($qData) {
					$this->logger->log("user have rate");
					foreach($qData as $val){
						$ratingData[$val['contentid']][$val['userid']]=$val['rate'];
					}
					return $ratingData;
				}
		return false;
			
			
	}
	
	function addComment($cid=null,$comment=null,$axisContent=1){
	
		if($cid==null) $cid = intval($this->apps->_p('cid'));
		if($comment==null) $comment = $this->apps->_p('comment');
		if(!$this->uid) return false;
		$uid = intval($this->uid);
		if($cid&&$comment){
		global $CONFIG;
			//bot system halt
			$sql = "SELECT id,date,count(id) total FROM axis_news_content_comment WHERE userid={$uid} ORDER BY id DESC LIMIT 1";
			$lastInsert = $this->apps->fetch($sql);
			$this->logger->log($lastInsert['total']);
			if($lastInsert['total']==0) $divTime = $CONFIG['DELAYTIME']+1;
			else $divTime = strtotime(date("Y-m-d H:i:s")) - strtotime($lastInsert['date']); 
			if($CONFIG['DELAYTIME']==0) $divTime = $CONFIG['DELAYTIME']+1;
			$this->logger->log(date("Y-m-d H:i:s").' .... '.$lastInsert['date']);
			if($divTime<=$CONFIG['DELAYTIME']) return false; 
			
			$sql ="
					INSERT INTO axis_news_content_comment (userid,contentid,comment,date,n_status) 
					VALUES ({$uid},{$cid},'{$comment}',NOW(),{$axisContent})
					";
			$this->apps->query($sql);
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()>0) return true;
			
		} else $this->logger->log($cid.'|'.$comment);
		return false;
	
	}
	
	function addCommentSocial($cid=null,$comment=null,$axisContent=1){
	
		if($cid==null) $cid = intval($this->apps->_p('cid'));
		if($comment==null) $comment = $this->apps->_p('comment');
		if(!$this->uid) return false;
			$uid = intval($this->uid);
		if($cid&&$comment){
		global $CONFIG;
			//bot system halt
			$sql = "SELECT id,date,count(id) total FROM social_news_content_comment WHERE userid={$uid} ORDER BY id DESC LIMIT 1";
			$lastInsert = $this->apps->fetch($sql);
			$this->logger->log($lastInsert['total']);
			if($lastInsert['total']==0) $divTime = $CONFIG['DELAYTIME']+1;
			else $divTime = strtotime(date("Y-m-d H:i:s")) - strtotime($lastInsert['date']); 
			if($CONFIG['DELAYTIME']==0) $divTime = $CONFIG['DELAYTIME']+1;
			$this->logger->log(date("Y-m-d H:i:s").' .... '.$lastInsert['date']);
			if($divTime<=$CONFIG['DELAYTIME']) return false; 
			
			$sql ="
					INSERT INTO social_news_content_comment (userid,contentid,comment,date,n_status) 
					VALUES ({$uid},{$cid},'{$comment}',NOW(),{$axisContent})
					";
			$this->apps->query($sql);
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()>0) return true;
			
		} else $this->logger->log($cid.'|'.$comment);
		return false;
	
	}
	
	function getComment($cid=null,$all=false,$start=0,$limit=5){
		if($cid==null) $cid = $this->apps->_p('cid');
		
		if(intval($this->apps->_p('start'))>=0)$start = intval($this->apps->_p('start'));
	
		if($cid){
			
			if($all==true) $qAllRecord = "";
			else  $qAllRecord = " LIMIT {$start},{$limit} ";
			
			$sql ="	SELECT * FROM axis_news_content_comment 
					WHERE contentid IN ({$cid}) AND n_status = 1
					ORDER BY date DESC {$qAllRecord}
					";
			$qData = $this->apps->fetch($sql,1);
			// pr($sql);exit;
			$this->logger->log($sql);
			if($qData) {
			
				if($all==true) return count($qData);
				
				
				foreach($qData as $val){
					$arrUserid[] = $val['userid'];				
				}
				
				$users = implode(",",$arrUserid);
				
				
				$sql = "SELECT id,name,fb_id,img,twitter_id,gplus_id FROM social_member WHERE id IN ({$users})  AND n_status = 1 ";
				$qDataUser = $this->apps->fetch($sql,1);
				if($qDataUser){
					$userRate = $this->getUserRating($cid,$users);
					
					foreach($qDataUser as $val){
						$userDetail[$val['id']]['name'] = $val['name'];
						$userDetail[$val['id']]['fb_id'] = $val['fb_id'];
						$userDetail[$val['id']]['img'] = $val['img'];
						
						//socialmedia img
						$profileImage='';
						if($val['twitter_id']) $profileImage = "https://api.twitter.com/1/users/profile_image/{$val['twitter_id']}";
						if($val['fb_id']) $profileImage = "https://graph.facebook.com/{$val['fb_id']}/picture?type=square&return_ssl_resources=1";	
						$userDetail[$val['id']]['socimg'] = $profileImage;
					}
					foreach($qData as $key => $val){
						$arrComment[$val['contentid']][$key] = $val;
						if(array_key_exists($val['userid'],$userDetail)){
							$arrComment[$val['contentid']][$key]['name'] = $userDetail[$val['userid']]['name'] ;
							$arrComment[$val['contentid']][$key]['fb_id'] = $userDetail[$val['userid']]['fb_id'] ;
							$arrComment[$val['contentid']][$key]['img'] = $userDetail[$val['userid']]['img'] ;
							$arrComment[$val['contentid']][$key]['socimg'] = $userDetail[$val['userid']]['socimg'];
							
							if($userRate){
								if(array_key_exists($val['contentid'],$userRate)) {
									if(array_key_exists($val['userid'],$userRate[$val['contentid']]))$arrComment[$val['contentid']][$key]['rate'] = $userRate[$val['contentid']][$val['userid']] ; 
									else $arrComment[$val['contentid']][$key]['rate'] = 0;
								}else $arrComment[$val['contentid']][$key]['rate'] = 0;
							}else  $arrComment[$val['contentid']][$key]['rate'] = 0;
						}
					}
				
					$qData = null;
					// pr($arrComment);exit;
					return $arrComment;
				}
			}
			
		}
		return false;
	
	}
	
	function getBanner($page="home",$type="header",$content=1,$limit=5){
	
		//Mobile OS detection
		// if($this->osDetect->isBlackBerryOS()){
			// $osType = 3;
		// }else if($this->osDetect->isiOS()){
			// $osType = 1;
		// }else if($this->osDetect->isAndroidOS()){
			// $osType = 2;
		// }else{
			// $osType = 4;
		// }
		
		//mobile os detect, imploder
		$arrMobileDevice[] =  " ancdg.deviceid like '%0%'  ";
		if($this->osDetect->isBlackBerryOS()) $arrMobileDevice[] = " ancdg.deviceid like '%3%' ";
		if($this->osDetect->isiOS()) $arrMobileDevice[] = " ancdg.deviceid like '%1%' ";
		if($this->osDetect->isAndroidOS()) $arrMobileDevice[] = " ancdg.deviceid like '%2%' ";
		if($this->osDetect->mobileGrade()=='C') $arrMobileDevice[] = " ancdg.deviceid like '%4%' ";
		
		//Mobile or Tablet device check
		$deviceType = ($this->osDetect->isMobile() ? ($this->osDetect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if($deviceType == 'computer'){
			$deviceFilter = "";
		}else{
			if($arrMobileDevice) {
				$mobileDeviecString = implode(' OR ', $arrMobileDevice);
				$deviceFilter = "AND ( {$mobileDeviecString} ) ";
			}else $deviceFilter = "";
		}
	
		$sql ="SELECT * FROM axis_news_content_banner_type WHERE type ='{$type}' AND n_status=1 LIMIT 1 "; 
		$this->logger->log($sql);
		$bannerType = $this->apps->fetch($sql);	
		if(!$bannerType) return false;
		$sql ="SELECT * FROM axis_news_content_page WHERE pagename = '{$page}' AND n_status = 1 LIMIT 1"; 
		$this->logger->log($sql);
		$bannerPage = $this->apps->fetch($sql);
		
		if(!$bannerPage) return false;	
		
		if($bannerType['id']==2) $bannerTypeID = "{$bannerType['id']},1";
		else $bannerTypeID = "{$bannerType['id']}"; 
		$sql = "SELECT * FROM axis_news_content_banner WHERE page LIKE '%{$bannerPage['id']}%' AND type IN ({$bannerTypeID}) AND n_status IN ({$this->server}) ";
		$this->logger->log($sql);
		$banner = $this->apps->fetch($sql,1);
		
		if(!$banner) return false;
		foreach($banner as $val){
			$arrBannerID[] = $val['parentid'];
			$banners[$val['parentid']] = $val;
		}
		$bannerId = implode(",",$arrBannerID) ;
		
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid,ancc.category,anc.articleType,anc.parentid,anc.slider_image,anc.thumbnail_image,anc.url
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_device_group ancdg ON ancdg.parentid = anc.parentid
		WHERE anc.parentid IN ({$bannerId}) AND anc.lid={$this->lid}
		{$deviceFilter}
		AND anc.n_status IN ({$this->server}) ORDER BY posted_date DESC  LIMIT {$limit}
		";
		$this->logger->log($sql);

		$qData = $this->apps->fetch($sql,1);	
		if(!$qData) return false;
		foreach($qData as $key => $val){
			if(array_key_exists($val['parentid'],$banners)) $qData[$key]['banner'] = $banners[$val['parentid']];
		}
	// pr($qData);exit;
		return $qData;
	}	
	

	function getPromo($start=0, $limit=6, $type="footer",$content=1){
		
		
		//Mobile OS detection
		// if($this->osDetect->isBlackBerryOS()){
			// $osType = 3;
		// }else if($this->osDetect->isiOS()){
			// $osType = 1;
		// }else if($this->osDetect->isAndroidOS()){
			// $osType = 2;
		// }else{
			// $osType = 4;
		// }
		
		//mobile os detect, imploder
		$arrMobileDevice[] =  " ancdg.deviceid like '%0%'  ";
		if($this->osDetect->isBlackBerryOS()) $arrMobileDevice[] = " ancdg.deviceid like '%3%' ";
		if($this->osDetect->isiOS()) $arrMobileDevice[] = " ancdg.deviceid like '%1%' ";
		if($this->osDetect->isAndroidOS()) $arrMobileDevice[] = " ancdg.deviceid like '%2%' ";
		if($this->osDetect->mobileGrade()=='C') $arrMobileDevice[] = " ancdg.deviceid like '%4%' ";
		
		//Mobile or Tablet device check
		$deviceType = ($this->osDetect->isMobile() ? ($this->osDetect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if($deviceType == 'computer'){
			$deviceFilter = "";
		}else{
			if($arrMobileDevice) {
				$mobileDeviecString = implode(' OR ', $arrMobileDevice);
				$deviceFilter = "AND ( {$mobileDeviecString} ) ";
			}else $deviceFilter = "";
		}
		
		$sql ="SELECT * FROM axis_news_content_type "; 
		$this->logger->log($sql);
		$contentType = $this->apps->fetch($sql,1);	
		if(!$contentType) return false;
		foreach($contentType as $val){
			$arrContentType[$val['id']] = $val['content_name'];
		}
		if(!$arrContentType) return false;
	
		// $sql ="SELECT * FROM axis_news_content_banner_type WHERE type ='{$type}' AND n_status=1 LIMIT 1 "; 
		// $bannerType = $this->apps->fetch($sql);	
		// if(!$bannerType) return false;
		// $sql = "SELECT * FROM axis_news_content_banner WHERE type={$bannerType['id']} AND n_status = 1 ";
		
		$sql = "SELECT * FROM axis_news_content_banner WHERE  n_status IN ({$this->server}) ";
		$this->logger->log($sql);
		$banner = $this->apps->fetch($sql,1);
		if(!$banner) return false;
		foreach($banner as $val){
			$arrBannerID[] = $val['parentid'];
		}
		$bannerId = implode(",",$arrBannerID) ;
		
		$sql = "	
		SELECT anc.id,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid,ancc.category,anc.articleType,anc.slider_image,anc.parentid,anc.thumbnail_image 
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		LEFT JOIN axis_news_content_device_group ancdg ON ancdg.parentid = anc.parentid
		WHERE anc.parentid IN ({$bannerId}) AND anc.lid={$this->lid} AND anc.articleType IN (2,3) AND anc.posted_date <= NOW()
		{$deviceFilter}
		AND anc.n_status IN ({$this->server}) ORDER BY posted_date DESC LIMIT {$start},{$limit}
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		
		$totalRow = "	
				SELECT COUNT(anc.id) AS total_rows
				FROM axis_news_content anc
				LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
				LEFT JOIN axis_news_content_device_group ancdg ON ancdg.parentid = anc.parentid
				WHERE anc.parentid IN ({$bannerId}) AND anc.lid={$this->lid} AND anc.articleType IN (2,3)
				{$deviceFilter}
				AND anc.n_status IN ({$this->server}) ORDER BY posted_date DESC
				";
		$this->logger->log($totalRow);
		$total = $this->apps->fetch($totalRow);
		
		if(!$qData) return false;
		
		foreach($qData as $key => $val){
			if(array_key_exists($val['articleType'],$arrContentType)) $qData[$key]['content_name'] = $arrContentType[$val['articleType']];
			else $qData[$key]['content_name'] = 'banner';
			
		}
		$qData[0]['total_rows'] = $total['total_rows'];
		// pr($qData);
		
		return $qData;
	}
	
	function getPopupArticle($strCid=null,$limit=5){
		if($strCid==null) return false;
		
		$sql = "SELECT * FROM axis_news_content_popup_description WHERE contentid IN ({$strCid}) AND n_status <> 3 LIMIT {$limit} ";
		$qData = $this->apps->fetch($sql,1);
		
		if(!$qData) return false;
			$rsData = false;
		foreach($qData as $key => $val){
				$rsData[$val['contentid']][] = $val;
		}
		if(!$rsData) return false;
		return $rsData;
		
		
		
	}
	
	function getMContentPreference(){

		$sql = "	
		SELECT *
		FROM axis_news_content anc
		WHERE anc.articleType = 1 AND anc.lid={$this->lid}
		AND anc.n_status IN ({$this->server}) ORDER BY posted_date DESC LIMIT 10
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);	
		if(!$qData) return false;
		return $qData;
	}
	
	function getAxisHot($start=0, $limit=5, $article=null){
		if($article){$detail="AND anc.id={$article}";}
		else{$detail="";}
		
		//tanya sarat nya dulu.. sementara pake query lastest
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,anc.parentid,ancc.category
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		WHERE anc.articleType IN (2) {$detail}  AND
		anc.n_status IN ({$this->server}) AND anc.lid = {$this->lid} 	
		 ORDER BY anc.posted_date DESC LIMIT 4
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		foreach($qData as $val){
			$cidArr[] = $val['parentid'];
		}
		if(!$cidArr) return false;
		$cidStr = implode(",",$cidArr);
		$ratingData = $this->getRating($cidStr);
		
		if($ratingData){
			
			foreach($qData as $key => $val){
				if(array_key_exists($val['parentid'],$ratingData)) $qData[$key]['rating'] = $ratingData[$val['parentid']];
				else $qData[$key]['rating'] = false;
			
			}
		
		}
		
		//comment di list article di takeout dulu
		$commentsData = $this->getComment($cidStr);
		if($commentsData){
			foreach($qData as $key => $val){
				if(array_key_exists($val['parentid'],$commentsData)) $qData[$key]['comment'] = count($commentsData[$val['parentid']]);
				else $qData[$key]['comment'] = false;
			
			}
			
		}
		
		if($commentsData){
			usort($qData, function($a, $b) {
						return $b['comment'] - $a['comment'];
				});
		
		}
		
		
		return $qData;
	
	}
	
	function getAxisLatest($limit=1){
		
		$limit = intval($limit);
		
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,anc.parentid,ancc.category,anc.thumbnail_image,anc.url
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
		WHERE anc.articleType IN (2)  AND
		anc.n_status IN ({$this->server}) AND anc.lid = {$this->lid} 	
		ORDER BY anc.posted_date DESC LIMIT {$limit}
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
	
		if(!$qData) return false;
		foreach($qData as $val){
			$cidArr[] = $val['parentid'];
		}
		if(!$cidArr) return false;
		$cidStr = implode(",",$cidArr);
		
		$commentsData = $this->getComment($cidStr);
		if($commentsData){
			foreach($qData as $key => $val){
				if(array_key_exists($val['parentid'],$commentsData)) $qData[$key]['comment'] = count($commentsData[$val['parentid']]);
				else $qData[$key]['comment'] = 0;
			
			}
		}
		
		
		return $qData;
	
	}
	
	
	function getAxisProduct($type='kartu',$limit=10,$idDetail=null){
		
		//Mobile OS detection
		// if($this->osDetect->isBlackBerryOS()){
			// $osType = 3;
		// }else if($this->osDetect->isiOS()){
			// $osType = 1;
		// }else if($this->osDetect->isAndroidOS()){
			// $osType = 2;
		// }else{
			// $osType = 4;
		// }
		
		//mobile os detect, imploder
		$arrMobileDevice[] =  " ancdg.deviceid like '%0%'  ";
		if($this->osDetect->isBlackBerryOS()) $arrMobileDevice[] = " ancdg.deviceid like '%3%' ";
		if($this->osDetect->isiOS()) $arrMobileDevice[] = " ancdg.deviceid like '%1%' ";
		if($this->osDetect->isAndroidOS()) $arrMobileDevice[] = " ancdg.deviceid like '%2%' ";
		if($this->osDetect->mobileGrade()=='C') $arrMobileDevice[] = " ancdg.deviceid like '%4%' ";
		
		//Mobile or Tablet device check
		$deviceType = ($this->osDetect->isMobile() ? ($this->osDetect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if($deviceType == 'computer'){
			$deviceFilter = "";
		}else{
			if($arrMobileDevice) {
				$mobileDeviecString = implode(' OR ', $arrMobileDevice);
				$deviceFilter = "AND ( {$mobileDeviecString} ) ";
			}else $deviceFilter = "";
		}
		
		$gtype = strip_tags($this->apps->_g("type"));
		if($gtype) $type = $gtype;
		
		$parentid = intval($this->apps->_g("id"));
		if($parentid)$qParentid = " AND anc.parentid = {$parentid} ";
		else $qParentid = "";
	
		if($idDetail)$detailProduct = "AND anc.id = {$idDetail}";
		else $detailProduct = "";
		
		$sql = "	
		SELECT anc.id,anc.parentid,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid,anc.url,anc.parentid,anct.type
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		LEFT JOIN axis_news_content_device_group ancdg ON ancdg.parentid = anc.parentid
		WHERE 
		anct.type='{$type}' AND anct.content=5 AND
		anc.n_status IN ({$this->server}) AND anc.lid = {$this->lid} 	
		{$qParentid}
		{$deviceFilter}
		ORDER BY posted_date DESC LIMIT {$limit}
		";
		// pr($sql);exit;
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		
		if(!$qData) return false;
		foreach($qData as $val){
			$cidArr[] = $val['id'];
		}
		if(!$cidArr) return false;
		$cidStr = implode(",",$cidArr);
	
		$productDesc = $this->getProductDescription($cidStr);
		
		if($productDesc){
			foreach($qData as $key => $val){
				if(array_key_exists($val['id'],$productDesc)) $qData[$key]['desc'] = $productDesc[$val['id']];
				else $qData[$key]['desc'] = false;
			
			}
		
		}
		return $qData;
		
	}
	
	function getRoamingCountry(){
		$sql ="SELECT * FROM axis_roaming_country";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		return $qData;
	}
	
	function getRoamingData($country=null){
		$sql ="SELECT * FROM axis_roaming_data WHERE country='{$country}'";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		return $qData;
	}
	
	function getProductDescription($cid=null,$getparent=false){
		if($cid==null) return false;
			
		if($cid){
			if($getparent){
				$cid = intval($cid);
				$sql =" SELECT parentid FROM axis_news_content WHERE id = {$cid} LIMIT 1";
				$qData = $this->apps->fetch($sql);
				if($qData) {
					$sql =" SELECT id FROM axis_news_content WHERE parentid = {$qData['parentid']}  AND lid= {$this->lid} LIMIT 1";
					$qData = $this->apps->fetch($sql);
					if(!$qData)return false;
					$cid = $qData['id'];					
				}else return false;
			}
		
			$sql ="	SELECT * FROM axis_news_content_product 
					WHERE contentid IN ({$cid}) AND n_status IN ({$this->server})
					ORDER BY date ASC 
					";
			$this->logger->log($sql);
			$qData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			if(!$qData) return false;
			foreach($qData as $val){
						$descProductData[$val['contentid']][$val['id']]=$val;
			}
			return $descProductData;
		}
		return false;
	}
	
	function getCoverageArea($start=0,$limit=3,$id=null,$provinceID=3){
		$provinceID = intval($provinceID);
		$start = intval($start);
		$limit = intval($limit);
		$id = intval($id);
		$province = "SELECT id FROM axis_city_reference WHERE provinceid ={$provinceID}";
		$qProvince = $this->apps->fetch($province,1);
		if(!$qProvince) return false;
		foreach($qProvince as $val){
			$cidArr[] = $val['id'];
		}
		$prov = implode(",",$cidArr);
		
		
		if($id!=null) $qId = " AND anc.id = {$id} "; 
		else $qId = "";
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,anc.parentid
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE anc.articleType IN (22)  AND
		anc.n_status IN ({$this->server}) AND anc.lid = {$this->lid} AND anc.cityid IN ({$prov})
		 {$qId} ORDER BY parentid DESC LIMIT {$start},{$limit}
		";
		$this->logger->log($sql);
		
		$qData = $this->apps->fetch($sql,1);
		//total
		$sql = "	
		SELECT count(*) total
		FROM axis_news_content anc
		WHERE anc.articleType IN (22)  AND
		anc.n_status IN ({$this->server}) AND anc.lid = {$this->lid} AND anc.cityid IN ({$prov})
		 {$qId} ORDER BY parentid  DESC
		";
		$this->logger->log($sql);
		$tData = $this->apps->fetch($sql);
		$total = $tData['total'];
		
		if(!$qData) return false;
		//script buat jadiin 1 image juga iframe googlemap nya coverage per area
		foreach($qData as $val){
			$arrPid[] = $val['parentid'];
		}
		if($arrPid){
			$pid = implode(',',$arrPid);
			$sql = "SELECT parentid,image,content FROM axis_news_content WHERE parentid IN ({$pid}) AND lid=1 ";
			$mapData = $this->apps->fetch($sql,1);
			if($mapData){
				foreach($mapData as $val){
					$arrMapData[$val['parentid']] = $val;
				}
			}
		}else $arrMapData = false;
		
		foreach($qData as $key => $val){
			$qData[$key]['total_rows'] = $total;
			if($arrMapData){
				if(array_key_exists($val['parentid'],$arrMapData)) {
					$qData[$key]['image'] = $arrMapData[$val['parentid']]['image'];
					$qData[$key]['content'] = $arrMapData[$val['parentid']]['content'];
				}
			}
		}
		
		return $qData;
	}
	
	function getOnlineStore($search=null,$start=0,$limit=7,$id=null,$cityID=null){
		$start = intval($start);
		$limit = intval($limit);
		$id = intval($id);
		$cityID = intval($cityID);
		if($id!=null) $qId = " AND anc.id = {$id} "; 
		else $qId = "";
		if($search!=null) $qSearch = " AND brief like '%{$search}%' ";
		else $qSearch = "";
		if($cityID!=null) $cityAdd = " AND cityid = {$cityID}";
		else $cityAdd = "";
		
		
		$sql = "	
		SELECT anc.id,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid ,anc.parentid
		FROM axis_news_content anc
		LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
		WHERE anc.articleType IN (23)  AND
		anc.n_status IN (0) AND anc.lid = 1	
		{$qId} {$qSearch} {$cityAdd} ORDER BY parentid DESC LIMIT {$start},{$limit}
		";
		// pr($sql);
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		
		if($qData){
			//total
			$sql = "	
			SELECT count(id) total_rows
			FROM axis_news_content anc
			WHERE anc.articleType IN (23)  AND
			anc.n_status IN (0) AND anc.lid = 1	
			{$cityAdd}
			";
			$this->logger->log($sql);
			$tData = $this->apps->fetch($sql);
			$qData[0]['total_rows'] = $tData['total_rows'];
		}
		if(!$qData) return false;
		
		return $qData;
	}
	
	function getCity($province, $type=null, $cityID=null){
		if($cityID){
			$filter = 'AND id <> '.$cityID;
			$default = "SELECT * FROM axis_city_reference WHERE id =".$cityID;
			$qDefault = $this->apps->fetch($default);
		}else{
			$filter = '';
		}
		
		$sql ="SELECT * FROM axis_city_reference WHERE provinceid={$province} {$filter}";
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		if($type=='topup'){
			array_unshift($qData, $qDefault);
		}
		
		
		if(!$qData) return false;
		return $qData;
	}
	
	function getProvince($type=null,$id=null){
		if($id){
			$filter = 'WHERE id <> '.$id;
			$default = 'SELECT * FROM axis_province_reference WHERE id = '.$id;
			$qDefault = $this->apps->fetch($default);
		}else{
			$filter = '  ';
		}
		// pr($id);
		if($type=='topup'){$filterProvince = 'AND id NOT IN (3,15,23,7,33,34,31,35,29,36,1) ';}
		else if($type=='coverage'){$filterProvince = ' AND id NOT IN (3,15,23,7,33,34,31,35,29,36,1) ';}
		else if($type=='coveragemap'){$filterProvince = ' WHERE n <> 0 AND 
		w <> 0 AND 
		s <> 0 AND 
		e <> 0  ';}
		else{$filterProvince = '';}
	
		$sql ="SELECT * FROM axis_province_reference {$filter} {$filterProvince} ORDER BY province ASC ";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		
		if($type=='coverage' || $type=='topup'){
			array_unshift($qData, $qDefault);
		}
		
		
		if(!$qData) return false;
		
		return $qData;
	}
	
	function getCoverageAreaMaps(){
		global $CONFIG;
		$provinceid = intval($this->apps->_p('provinceid'));
		if($provinceid) $qProvince = "AND  id = {$provinceid} ";
		else  $qProvince = "";
		
		$sql = "	
		SELECT *
		FROM axis_province_reference 
		WHERE 
		n <> 0 AND 
		w <> 0 AND 
		s <> 0 AND 
		e <> 0  
		{$qProvince}
		
		
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		
		//3g
		$n = 0;
		foreach($qData as $key => $val){
			$allData[$n] = $val;
			$allData[$n]['url_image'] = "{$CONFIG['BASE_DOMAIN']}public_assets/coverage/maps/{$val['image']}_{$val['cover']}.png";
			$allData[$n]['signal'] = "3g";
			$n++;
		}
		
		//edge
		foreach($qData as $key => $val){
			if($val['cover']=='edge'||$val['cover']=='3g') {
				$allData[$n] = $val;
				$allData[$n]['url_image'] = "{$CONFIG['BASE_DOMAIN']}public_assets/coverage/maps/{$val['image']}_edge.png";
				$allData[$n]['signal'] = "2g";
				$n++;
			}
		}
		if(!$allData) return false;
		// pr($qData);
		return $allData;
	}
	
	
	function getMsgType(){
		$sql = "SELECT * FROM axis_message_type WHERE web_type=1 AND lid = {$this->lid}";
		$this->logger->log($sql);
		$rs = $this->apps->fetch($sql, 1);
		
		return $rs;
	}
	
	function getCategoryType($start=0,$limit=5,$type=null,$currentcategory=true){
		if($type==null) {
			if($currentcategory){
				$type = '';
				$sql = " SELECT categoryid FROM axis_news_content WHERE n_status IN ({$this->server}) AND articleType IN  (2) AND categoryid <>0 GROUP BY categoryid";
					
				$rs = $this->apps->fetch($sql, 1);
				if($rs){
					foreach($rs as $val){
						$arrType[] = $val['categoryid'];
					}
					
				}
				
				
				
				$sql = " SELECT categoryid FROM social_news_content WHERE n_status IN ({$this->server}) AND categoryid <>0 GROUP BY categoryid";
					
				$rs = $this->apps->fetch($sql, 1);
				if($rs){
					foreach($rs as $val){
						$arrType[] = $val['categoryid'];
					}
					$type = implode(',',$arrType);
				}
				
			}
		}
		
		if($type)$filter = "AND id IN ({$type})";
		else $filter = "";
		
		$lang = $this->lid;
		
		$sql = "SELECT * FROM axis_news_content_category WHERE used=0 {$filter} LIMIT {$start},{$limit}";
		$this->logger->log($sql);
		$rs = $this->apps->fetch($sql, 1);
		// pr($sql);
		
		if($rs){
			$sql_total = "SELECT COUNT(id) AS total_rows FROM axis_news_content_category WHERE used=0 {$filter}";
			$rs_total = $this->apps->fetch($sql_total);
			
			foreach($rs as $k => $v){
					$rs[$k]['cssname'] = strtolower(substr($v['category'],0,3));
					$rs[$k]['naming'] = unserialize($v['naming']);
				if(is_array($rs[$k]['naming'])){
					$rs[$k]['category'] = $rs[$k]['naming'][$this->lid];
				}
			}
			
			$rs[0]['total_rows'] = $rs_total['total_rows'];
		}
		return $rs;
	}
}	

?>

