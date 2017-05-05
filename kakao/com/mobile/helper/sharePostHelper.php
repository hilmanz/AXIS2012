<?php 

class sharePostHelper {

		
	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if($this->apps->isUserOnline()) $this->uid = $this->apps->user->id;
	
	}
	
	function getUrlContent(){
		$arrData['img']="";
		$arrData['title']="";
		$arrData['content']="";
		$url = $this->apps->Request->getPost("url");
		if(!$url) return $arrData;
		$data = strip_tags(curlGet($url),'<div><p><title><img><image>');
		if(!$data) return $arrData;
		$paragraphData = strip_tags($data,'<p>');
	
			

		if (preg_match_all("/<p>(.*?)<\/p>/s", $paragraphData , $cont_matches )) {
		
			foreach($cont_matches[1]  as $val){
				 if($this->countWord($val,5)) $arrData['content'] =  strip_tags($val);
			}
		
		}
					
		
		if (preg_match('/<title>(.*?)<\/title>/', $data, $title_matches)) {
			$arrData['title'] = $title_matches[1];
		}	
		
		$data = strip_tags($data,'<img><image>');
		if (preg_match_all('/(<img[^>]*src=".*?(?:\.jpg|\.jpeg|\.png)"[^>]*>)/i', $data, $img_matches)) {
			foreach($img_matches[1] as $val){
				if(preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i',  $val,$trueMatchImage)) $tempImg[$trueMatchImage[1]] = $trueMatchImage[1];
			}
			foreach($tempImg as $val){
				if(@file_get_contents($val)) $arrData['img'][] = $val;	
				else continue;				
			}
						
		}
		// if (preg_match('/< *link rel="shortcut icon" [^>]*href *= *["\']?([^"\']*)/i', $data, $matches)) {
			// $arrData['favicon'] = $matches[1];
		// }
		
	
		return $arrData;
		
	}
	
	
	function sharePosting(){
		
		$content = $this->apps->Request->getPost('myPosting');

		if($content==''||$content==null) return false;
		
		$title =$this->apps->Request->getPost('myTitle');
		$url =$this->apps->Request->getPost('myUrl');
		$categoryid = $this->apps->Request->getPost('myCategory');
		$tag =  $this->apps->Request->getPost('myTag');
		$rate =  $this->apps->Request->getPost('myRate');
		$filename="";
		if($_FILES['myImage']['error']==0)	{
			$image = $this->uploadThisImage(@$_FILES['myImage']);
			$filename = @$image['filename'];
		}
		
		$sql ="INSERT INTO social_news_content 
		(categoryid,userid 	,url ,	title ,	brief ,	content ,	image,	created_date,n_status )
		VALUES
		({$categoryid},{$this->uid},'{$url}','{$title}','{$tag}','{$content}','{$filename}',NOW(),1)
		";
	
		$this->apps->query($sql);

		if($this->apps->getLastInsertId()){
			$this->saveRating($this->apps->getLastInsertId(),$rate);
			return true;
		}
		
		else return false;
	}
	
	function shareUrl(){
		$url = $this->apps->Request->getPost('url');
	}
	
	
	function uploadThisImage($files=null){
		global $CONFIG;
		$arrImageData['filename'] ="";
		if($files==null) return false;

		$path = $CONFIG['PUBLIC_ASSET']."user/content/";
		$filename = sha1(date('ymdhis').$files['name']);
		$type = explode('/',$files['type']);
		// tambahin resizer.. sama kondisi
		
		if(move_uploaded_file($files['tmp_name'],$path.$filename.'.'.$type[1])){
				$arrImageData['filename'] =$filename.'.'.$type[1];
		
		}

			
		return $arrImageData;
	}
	
	function countWord($text,$limit=20){
    $explode = explode(' ',$text);
		if($explode){
			if(count($explode) <= $limit){
				return false;
			}
			
			return true;
		}else 	return false;
	} 
	
	function WordLimiter($text,$limit=10){
    $explode = explode(' ',$text);
	if($explode){
		$string  = '';
		   
		$dots = '...';
		if(count($explode) <= $limit){
			$dots = ' ';
		}
		foreach($explode as $val){
			$string .= $val." ";
		}
		
		return $string.$dots;
	}else 	return false;
	}


	function saveRating($cid=null,$rate=null){
		if($cid==null) $this->apps->_p('cid');
		if($rate==null) $this->apps->_p('rate');
		
		if($cid && $this->uid){
			$sql ="
					INSERT INTO social_news_content_rating (userid,contentid,rate,date,n_status) 
					VALUES ({$this->uid},{$cid},{$rate},NOW(),1)
					";
			$this->apps->query($sql);
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()>0) return true;
			
		}
		return false;
	}

	function getContent($start=null,$limit=10){
		if($start==null)$start = intval($this->apps->_p('start'));
			
		if($this->uid) $qUserContent = " AND userid = {$this->uid} ";
		else $qUserContent="" ;
		$sql ="
		SELECT snc.id,snc.url,ancc.category,snc.content,snc.brief,snc.title,snc.image,snc.posted_date ,snc.categoryid
		FROM social_news_content snc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
		WHERE n_status = 1 {$qUserContent} ORDER BY posted_date DESC LIMIT {$start},{$limit}";
		
		$qData = $this->apps->fetch($sql,1);
		$this->logger->log($sql);
		if(!$qData) return false;
		return $qData;
		
		
	}
	
	
	function getRating($cid=null){
		if($cid==null) $cid = $this->apps->_p('cid');
		if($cid){
			$cidin = " AND contentid IN ({$cid}) ";
		}
			$sql ="
					SELECT FLOOR(avg(rate)) avgtotal,contentid FROM social_news_content_rating WHERE n_status=  1 {$cidin}  GROUP BY contentid
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
	function getComment($cid=null){
		if($cid==null) $cid = $this->apps->_p('cid');
		
		if($cid){
			$sql ="	SELECT * FROM social_news_content_comment 
					WHERE contentid IN ({$cid}) AND n_status = 1
					ORDER BY date DESC LIMIT 100
					";
			$qData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			if($qData) {
				foreach($qData as $val){
					$arrUserid[] = $val['userid'];				
				}
				
				$users = implode(",",$arrUserid);
				
				
				$sql = "SELECT id,name,fb_id,img FROM social_member WHERE id IN ({$users})  AND n_status = 1 ";
				$qDataUser = $this->apps->fetch($sql,1);
				if($qDataUser){
					$userRate = $this->getUserRating($cid,$users);
				
					foreach($qDataUser as $val){
						$userDetail[$val['id']]['name'] = $val['name'];
						$userDetail[$val['id']]['fb_id'] = $val['fb_id'];
						$userDetail[$val['id']]['img'] = $val['img'];
					}
					foreach($qData as $key => $val){
						$arrComment[$val['contentid']][$key] = $val;
						if(array_key_exists($val['userid'],$userDetail)){
							$arrComment[$val['contentid']][$key]['name'] = $userDetail[$val['userid']]['name'] ;
							$arrComment[$val['contentid']][$key]['fb_id'] = $userDetail[$val['userid']]['fb_id'] ;
							$arrComment[$val['contentid']][$key]['img'] = $userDetail[$val['userid']]['img'] ;
							if($userRate){
								if(array_key_exists($val['contentid'],$userRate)) $arrComment[$val['contentid']][$key]['rate'] = $userRate[$val['contentid']][$val['userid']] ; 
								else $arrComment[$val['contentid']][$key]['rate'] = 0;
							}else  $arrComment[$val['contentid']][$key]['rate'] = 0;
						}
					}
				
					$qData = null;
					return $arrComment;
				}
			}
			
		}
		return false;
	
	}
	
	
	
	function getCommentList($start=0,$limit=10){
	
			$sql ="	SELECT * FROM social_news_content_comment 
					WHERE userid={$this->uid} AND n_status = 1
					ORDER BY date DESC LIMIT {$start},{$limit}
					";
			
			$sData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			
			$sql ="	SELECT * FROM axis_news_content_comment 
					WHERE userid={$this->uid} AND n_status = 1
					ORDER BY date DESC LIMIT {$start},{$limit}
					";
			
			$cData = $this->apps->fetch($sql,1);
			
			$this->logger->log($sql);
			if($sData){
				
				foreach($sData as $val){
					$arrCid[] = $val['contentid'];
					$arrCommentSocialData[$val['contentid']][$val['id']] = $val;
				}				
			
				$strCid = implode(",",$arrCid);
			
				$contentData = 	$this->getSocialListContent($strCid);
				if($contentData){
					foreach($contentData as $key => $val){
						$contentData[$key]['social'] = true;
						if(array_key_exists($val['id'],$arrCommentSocialData))$contentData[$key]['comment'] = $arrCommentSocialData[$val['id']];
						
						
					}							
				}
				
				foreach($contentData as $val){
					$arrData[strtotime($val['posted_date'])][] = $val;				
				}
			
			}
			
			if($cData){
				foreach($cData as $val){
					$arrCid[] = $val['contentid'];
					$arrCommentData[$val['contentid']][$val['id']] = $val;
				}				
			
				$strCid = implode(",",$arrCid);
				// pr($strCid);
				$contentData = 	$this->getListContent($strCid);
				if($contentData){
					foreach($contentData as $key => $val){
						$contentData[$key]['social'] = false;
						if(array_key_exists($val['id'],$arrCommentData))$contentData[$key]['comment'] = $arrCommentData[$val['id']];
						
						
					}								
				}
				foreach($contentData as $val){
					$arrData[strtotime($val['posted_date'])][] = $val;				
				}
			}
			
		
			if($arrData) {
		
			sort($arrData);
			
			foreach($arrData as $val){
				foreach($val as $childVal){
					$qData[] = $childVal;
				}
			}
			// pr($qData);
			return $qData;
			}
			return false;
	
	}
	
	
	function getDetailContent(){
	
		$sql = "
		SELECT snc.id,ancc.category,snc.content,snc.brief,snc.title,snc.image,snc.posted_date ,snc.categoryid ,ancc.point
		FROM social_news_content snc
		LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
		WHERE snc.id={$this->apps->Request->getParam('id')} LIMIT 1 ";
		
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		if($this->uid && $qData){
		
				$sql ="
				INSERT INTO axis_news_content_rank (categoryid ,	point, 	userid ,	date) 
				VALUES ({$qData['categoryid']},{$qData['point']},{$this->uid},NOW())
				ON DUPLICATE KEY UPDATE
				POINT = POINT + VALUES(POINT);				
				";
				$this->apps->query($sql);
	
		
	
		}
		
		if($qData){
			
		
				$cidStr = $qData['id'];
				$ratingData = $this->getRating($cidStr);
				$commentsData = $this->getComment($cidStr);
			
				if($ratingData){
					
					
						if(array_key_exists($qData['id'],$ratingData)) $qData['rating'] = $ratingData[$qData['id']];
						else $qData['rating'] = false;
					
				
				}
				
				if($commentsData){
		
					
						if(array_key_exists($qData['id'],$commentsData)) $qData['comment'] = $commentsData[$qData['id']];
						else $qData['comment'] = false;
				}
				
		}

		return $qData;
	
	}
	
 	function getSocialListContent($cid=null){
		if($cid==null) return false;
			$sql ="
					SELECT snc.id,snc.url,ancc.category,snc.content,snc.brief,snc.title,snc.image,snc.posted_date ,snc.categoryid
					FROM social_news_content snc
					LEFT JOIN axis_news_content_category ancc ON ancc.id = snc.categoryid
					WHERE n_status = 1 AND snc.id IN ({$cid}) ORDER BY posted_date DESC ";
			$qData =  $this->apps->fetch($sql,1);
				
			foreach($qData as $val){
				$arrData[$val['id']] = $val;
			}	

			return $arrData;
	}
	
	function getListContent($cid=null){
		if($cid==null)return false;
			$sql ="	SELECT anc.id,anc.url,ancc.category,anc.content,anc.brief,anc.title,anc.image,anc.posted_date ,anc.categoryid
					FROM axis_news_content anc
					LEFT JOIN axis_news_content_category ancc ON ancc.id = anc.categoryid
					WHERE n_status = 1 AND anc.id IN ({$cid}) ORDER BY posted_date DESC ";
			$qData =  $this->apps->fetch($sql,1);
		
			foreach($qData as $val){
				$arrData[$val['id']] = $val;
			}	
		
			return $arrData;
			
			
	}
	
	function getUserRating($cid=null,$uid=null){
		if($cid==null) return false;
		if($uid==null) return false;
			$sql ="
					SELECT rate ,userid,contentid FROM social_news_content_rating WHERE n_status=  1 AND contentid  IN ({$cid})  AND userid IN ({$uid}) ";
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
}	

?>

