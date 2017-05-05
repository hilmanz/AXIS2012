<?php 

class userHelper {

		
	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
	
	}
	
	function getUserProfile(){
		if($this->uid!=0 || $this->uid!=null) {
		$sql = "SELECT * FROM social_member WHERE id = {$this->uid} LIMIT 1";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		
		return $qData;
		}
		return false;
	
	}
	
	function getUserAttribute(){
		
		$sql = "
		SELECT sum(ancr.point) rank,categoryid ,category
		FROM axis_news_content_rank ancr
		LEFT JOIN axis_news_content_category ancc ON ancc.id= ancr.categoryid
		WHERE userid={$this->uid} 
		GROUP BY categoryid ORDER BY rank DESC LIMIT 5 ";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
	
		if($qData){
			$mostLike = null;
			foreach($qData as $val){
				$mostLike[] = $val['category'];		
			}
			$userLikeCategory = implode(' , ',$mostLike);
		}
		$sql = "
			SELECT art.rank titleRank,art.id levelRank FROM social_rank sr
			LEFT JOIN social_media_account sma ON sma.userid=sr.userid
			LEFT JOIN axis_rank_table art ON art.id=sr.rank
			WHERE sr.userid = {$this->uid} AND sr.n_status = 1 limit 1		
		";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		if(isset($userLikeCategory)) $qData['userlike'] = $userLikeCategory;
		if($qData)	return $qData;
		else return false;
	
	}
	
	function getRankUser(){
		$sql ="
			SELECT * 
			FROM social_rank 
			WHERE userid = {$this->uid} 
			AND n_status = 1 LIMIT 1		
			";
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);	
	
		if($qData){
			$lastPoint = $qData['point'];
			$lastDate  = $qData['date'];
	
			$qData = null;
			//cek new point // > tanggal
			$sql ="
				SELECT SUM(score) total 
				FROM tbl_exp_point 
				WHERE user_id = {$this->uid} AND date_time > '{$lastDate}'
				";
			$this->logger->log($sql);
			$qData = $this->apps->fetch($sql);	
			$point = $qData['total'];
			$qData = null;
					
			//klo ada point baru, setelah penginsert-an point sebelum nya , tambah point nya
			if($point==0)	return false;
				
			$newPoint = $lastPoint+$point;
					
			$sql = "
				SELECT id FROM axis_rank_table 
				WHERE minPoint <= {$newPoint} AND maxPoint > {$newPoint} LIMIT 1";
			$this->logger->log($sql);
			$qData = $this->apps->fetch($sql);	
			$rank = $qData['id'];
			$qData = null;
			
			if($rank){
				$sql="INSERT INTO social_rank (userid,date,date_ts,rank,point,n_status) VALUES ({$this->uid},NOW(),".time().",{$rank},{$newPoint},1) ";
				$this->logger->log($sql);
				$qData = $this->apps->query($sql);
				$lastID = $this->apps->getLastInsertId();
				$qData = null;
				if($lastID!=0 || $lastID!=null){
				
					$sql="UPDATE social_rank SET n_status = 0 WHERE userid={$this->uid} AND id <> {$lastID}  ";
					$this->logger->log($sql);
					$qData = $this->apps->query($sql);
					$qData = null;
				}else {
					//cek data if n_status 1 have duplicate value
					$sql = "
						SELECT count(*) total, id FROM social_rank 
						WHERE n_status = 1 AND userid={$this->uid} ORDER BY id DESC LIMIT 2";
						$this->logger->log($sql);
					$qData = $this->apps->fetch($sql);	
					
					if($qData['total']>=2){
						$qData = null;
						$sql = "
						SELECT id FROM social_rank 
						WHERE n_status = 1 AND userid={$this->uid} ORDER BY id DESC LIMIT 1";
						$this->logger->log($sql);
						$qData = $this->apps->fetch($sql);	
						$usingIDRank = intval($qData['id']);
						$qData = null;
						if($usingIDRank!=0){
							$sql="UPDATE social_rank SET n_status = 0 WHERE id <> {$usingIDRank} AND userid={$this->uid} ";
							$this->logger->log($sql);
							$qData = $this->apps->query($sql);
							$qData = null;
						} 
					}else return true;
				
				
				}
			}
			return false;
			
		}else{
			
			//cek klo uda ada activity brarti rollback rank nya
			$sql ="
					SELECT count(*) total 
					FROM tbl_exp_point 
					WHERE user_id = {$this->uid} 
					LIMIT 1	
					";
				$this->logger->log($sql);
			$qData = $this->apps->fetch($sql);	
			
			if($qData['total']<=0){
				//klo ga ada. insert ke social rank newbie
				$sql="INSERT INTO social_rank (userid,date,date_ts,rank,point,n_status) VALUES ({$this->uid},NOW(),".time().",1,0,1) ";
				$this->logger->log($sql);
				$qData = $this->apps->query($sql);	
			}else{
				$qData = null;
				$sql ="
					SELECT SUM(score) total 
					FROM tbl_exp_point 
					WHERE user_id = {$this->uid} 
					";
					$this->logger->log($sql);
				$qData = $this->apps->fetch($sql);	
				$point = intval($qData['total']);
				$qData = null;
			
				$sql = "
					SELECT id FROM axis_rank_table 
					WHERE minPoint <= {$point} AND maxPoint >= {$point} LIMIT 1";
					$this->logger->log($sql);
				$qData = $this->apps->fetch($sql);	
				$rank = $qData['id'];
					
				if($rank!=0|| $rank!=null){
					$sql="INSERT INTO social_rank (userid,date,date_ts,rank,point,n_status) VALUES ({$this->uid},NOW(),".time().",{$rank},{$point},1) ";
					$this->logger->log($sql);
					$qData = $this->apps->query($sql);		
					return true;					
				}
			}
		return false;
		}
		
	
	}
	
	
	function getPreferenceThemeUser(){
		$sql =" SELECT * FROM social_preference_page WHERE userid={$this->uid} AND n_status=1 LIMIT 1";
			
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql);
		// print_r( unserialize($qData['apperances']));exit;
		if($qData) return unserialize($qData['apperances']);
		else return false;
	}
	
	function savePreferenceThemeUser(){
		$data = $this->getPreferenceThemeUser();
	
		$themetype = strip_tags($this->apps->_p('themetype'));
		if($themetype) $data['themetype'] = $themetype;
		else $data['themetype'] = '';
				
		$dataPreference = serialize($data);
		
		$sql="INSERT INTO 
		social_preference_page (userid,apperances,date,n_status) VALUES ({$this->uid},'{$dataPreference}',NOW(),1) 
		ON DUPLICATE KEY UPDATE
		apperances = VALUES(apperances)
		";
		// pr($sql);exit;
		$this->logger->log($sql);
		$qData = $this->apps->query($sql);	
		return true;
		
	}
	
	
	function updateUserProfile(){
	
		$this->logger->log('can update profile');
		$oldpass = $this->apps->Request->getPost('oldpassword');
		$newpass =$this->apps->Request->getPost('password');
		$repass = $this->apps->Request->getPost('repassword');
		
	
		$sql = "SELECT * FROM social_member WHERE n_status=1 AND id={$this->uid} LIMIT 1";
		$this->logger->log($sql);
		$rs = $this->apps->fetch($sql);
		

		$oldpasshash = sha1($oldpass.$rs['phone_number'].$rs['salt']);
		$newpasshash = sha1($newpass.$rs['phone_number'].$rs['salt']);	
		
			$arrQuery='';
			if($oldpasshash==$rs['password']){
				
				if($newpass == $repass) {
					$acceptPass = $newpasshash;
					$arrQuery[] = " password='{$acceptPass}' ";
				}
			}
			
		
			
			$name = $this->apps->Request->getPost('name');
			$phonenumber = $this->apps->Request->getPost('phonenumber');
			if($phonenumber!='') $arrQuery[] = " phone_number='{$phonenumber}' ";
		
			if($name!='') $arrQuery[] = " name='{$name}' ";
	
		
			
			$strQuery = implode(',',$arrQuery);
			if(!$strQuery) return false;
			$this->logger->log($strQuery);
			
			$sql = "
			UPDATE social_member 
			SET {$strQuery} 
			WHERE id={$this->uid} LIMIT 1
			";
			$this->logger->log($sql);
			$this->logger->log($sql);
			$qData = $this->apps->query($sql);
			if($qData) {
					$sql = "
					SELECT id,name,nickname,email,register_date,sex,birthday,phone_number,fb_id,twitter_id,gplus_id 
					FROM social_member 
					WHERE 
					n_status=1 AND 
					id={$this->uid}
					LIMIT 1";
				$this->logger->log($sql);
				$rs = $this->apps->fetch($sql);
				if($rs) $this->apps->session->set('user',urlencode64(json_encode($rs)));
				else return false;
				return true;
			}else return false;
		
			
	
			
		}	
	
	function saveImage(){
			$filename="";
			if($_FILES['myImage']['error']==0)	{
				$image = $this->uploadThisImage(@$_FILES['myImage']);
				$filename = @$image['filename'];
			}
			return $filename;
	}
	
	function uploadThisImage($files=null){
		global $CONFIG;
		$arrImageData['filename'] ="";
		if($files==null) return false;

		$path = $CONFIG['PUBLIC_ASSET']."user/photo/";
		// $path = "D:/xampp/htdocs/axis2012/trunk/web/public_html/public_assets/user/profile/";
		$filename = sha1(date('ymdhis').$files['name']);
		$type = explode('/',$files['type']);
		// tambahin resizer.. sama kondisi
		
		if(move_uploaded_file($files['tmp_name'],$path.$filename.'.'.$type[1])){
			$sql = "
			UPDATE social_member 
			SET  img = '{$filename}'
			WHERE id={$this->uid} LIMIT 1
			";
			$this->logger->log($sql);
			
			$qData = $this->apps->query($sql);
			
			$arrImageData['filename'] =$filename.'.'.$type[1];	
			
				
		}			
		return $arrImageData;
	}
	
	function saveCropImage(){
				global $CONFIG;
				$files['source_file'] = $this->apps->_p("imageFilename");
				$files['url'] = $this->apps->_p("imageUrl");
				$files['url'] = $CONFIG['LOCAL_PUBLIC_ASSET'].'user/photo/';
				$arrFilename = explode('.',$files['source_file']);
				if($files==null) return false;
				$targ_w = $this->apps->_p('w');
				$targ_h =$this->apps->_p('h');
				$jpeg_quality = 90;
				
				if($files['source_file']=='') return false;
				
				$src = 	$files['url'].$files['source_file'];
				try{
					$img_r = false;
					if($arrFilename[1]=='jpg' || $arrFilename[1]=='jpeg' ) $img_r = imagecreatefromjpeg($src);
					if($arrFilename[1]=='png' ) $img_r = imagecreatefrompng($src);
					if($arrFilename[1]=='gif' ) $img_r = imagecreatefromgif($src);
					if(!$img_r) return false;
					$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

					imagecopyresampled($dst_r,$img_r,0,0,$this->apps->_p('x'),$this->apps->_p('y'),	$targ_w,$targ_h,$this->apps->_p('w'),$this->apps->_p('h'));

					// header('Content-type: image/jpeg');
					if($arrFilename[1]=='jpg' || $arrFilename[1]=='jpeg' ) imagejpeg($dst_r,$files['url'].$files['source_file'],$jpeg_quality);
					if($arrFilename[1]=='png' ) imagepng($dst_r,$files['url'].$files['source_file']);
					if($arrFilename[1]=='gif' ) imagegif($dst_r,$files['url'].$files['source_file']);
					
				}catch (Exception $e){
					return false;
				}
				include_once '../engines/Utility/phpthumb/ThumbLib.inc.php';
					
				try{
					$thumb = PhpThumbFactory::create($files['url'].$files['source_file']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				list($width, $height, $type, $attr) = getimagesize($files['url'].$files['source_file']);
				$maxSize = 400;
				if($width>=$maxSize){
					if($width>=$height) {
						$subs = $width - $maxSize;
						$percentageSubs = $subs/$width;
					}
				}
				if($height>=$maxSize) {
					if($height>=$width) {
						$subs = $height - $maxSize;
						$percentageSubs = $subs/$height;
					}
				}
				if(isset($percentageSubs)) {
				 $width = $width - ($width * $percentageSubs);
				 $height =  $height - ($height * $percentageSubs);
				}
				
				$w_small = $width - ($width * 0.5);
				$h_small = $height - ($height * 0.5);
				$w_tiny = $width - ($width * 0.7);
				$h_tiny = $height - ($height * 0.7);
				
				//resize the image
				$thumb->adaptiveResize($width,$height);
				$big = $thumb->save(  "{$files['url']}".$files['source_file']);
				$thumb->adaptiveResize($width,$height);
				$prev = $thumb->save(  "{$files['url']}prev_".$files['source_file']);
				$thumb->adaptiveResize($w_small,$h_small);
				$small = $thumb->save( "{$files['url']}small_".$files['source_file'] );
				$thumb->adaptiveResize($w_tiny,$h_tiny);
				$tiny = $thumb->save( "{$files['url']}tiny_".$files['source_file']);
								
				if(file_exists($files['url'].$files['source_file'])){
					//saveit
					$sql = "
					UPDATE social_member 
					SET  img = '{$files['source_file']}'
					WHERE id={$this->uid} LIMIT 1
					";
					$this->logger->log($sql);
					
					$qData = $this->apps->query($sql);
					if($qData){
							$sql = "
							SELECT id,name,nickname,email,register_date,sex,birthday,phone_number,fb_id,twitter_id,gplus_id,img
							FROM social_member 
							WHERE 
							n_status=1 AND id={$this->uid} LIMIT 1 ";
						$rs = $this->apps->fetch($sql);	
						if(!$rs)return false;
						$rs['img'] = $files['source_file'];
						$this->apps->session->set('user',urlencode64(json_encode($rs)));
						return "prev_".$files['source_file'];
					}else return false;
					
				}else return false;
				
	}

	
	}

?>

