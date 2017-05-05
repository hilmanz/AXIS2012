<?php 

class bookmarkHelper {

	var $uid;	
	function __construct($apps){
		global $CONFIG;
		$this->apps = $apps;
		if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
		if(isset($_SESSION['lid'])) $this->lid = $_SESSION['lid'];
		else $this->lid = 1;
		$this->server = $CONFIG['VIEW_ON'];
		
		
	}
	
	
	function getBookmark($start=0,$limit =4){
	
		$sql ="
		SELECT * FROM social_bookmark sb WHERE userid={$this->uid} 
		ORDER BY date DESC LIMIT {$start},{$limit}";
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;		
		$n=0;
		foreach($qData as $val){
			if( $val['content'] == 0 ) $content[] = $val['contentid'];
			else $social[] =  $val['contentid'];
			
			$groupArrContent["{$val['content']}_{$val['contentid']}"]=$n;
			$n++;
		}
		
		if(isset($content)) {
			$cindicate = 0;
			$arrContentStr = implode(",",$content);
			
			$sql ="
			SELECT anc.id,ancc.category,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid, anc.online,anct.type as ctype
			FROM axis_news_content anc
			LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
			LEFT JOIN axis_news_content_type anct ON anct.id = anc.articleType
			WHERE 
			anc.n_status = {$this->server} AND anc.lid = {$this->lid} 	
			AND anc.id IN ({$arrContentStr})
			ORDER BY posted_date DESC LIMIT 30";
			$cData = $this->apps->fetch($sql,1);
			if(!$cData) return false;
			foreach($cData as $val){
					$cidArr[] = $val['id'];
				}
				if(!$cidArr) return false;
				$cidStr = implode(",",$cidArr);
				$ratingData = $this->apps->contentHelper->getRating($cidStr);
				
				if($ratingData){
					
					foreach($cData as $key => $val){
						if(array_key_exists($val['id'],$ratingData)) $cData[$key]['rating'] = $ratingData[$val['id']];
						else $cData[$key]['rating'] = false;
						$cData[$key]['content'] = $cindicate;
					}
				
				}
				
			foreach($cData as $val){
				$newArr[$groupArrContent["{$cindicate}_{$val['id']}"]] = $val;
			}
		}
		if(isset($social)) {
			$sindicate = 1;
			$arrSocialStr = implode(",",$social); 
			
			$sql ="
			SELECT snc.id,ancc.category,snc.content,snc.brief,snc.title,snc.image,snc.posted_date ,snc.categoryid
			FROM social_news_content snc
			LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
			WHERE n_status = 1 
			AND snc.id IN ({$arrSocialStr})
			ORDER BY posted_date DESC LIMIT 30";
			
			$sData = $this->apps->fetch($sql,1);
			foreach($sData as $key => $val){
				$sData[$key]['content'] = $sindicate;
				$newArr[$groupArrContent["{$sindicate}_{$val['id']}"]] = $val;
				
			}
		}
		sort($newArr);
		return $newArr;
	}
	
	
	
	function saveBookmark(){
		
		if(!$this->uid) return false;
		$content = $this->apps->Request->getParam('content');
		if($content==null) $content=0;
		$url = $this->apps->Request->getParam('url');
		$contentid = $this->apps->Request->getParam('id');
					
		$sql =" INSERT INTO social_bookmark 
		(userid,url,content,contentid,date,n_status) 
		VALUES 
		({$this->uid},'{$url}',{$content},{$contentid},NOW(),1)
		";
		$this->apps->query($sql);
		if($this->apps->getLastInsertId())	return true;
		else return false;
		
		
	}
	
	
			
}	

?>

