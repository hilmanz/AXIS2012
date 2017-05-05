<?php
error_reporting(E_ALL);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class galeri extends Admin{
	function __construct(){	
		parent::__construct();	
		$this->type = 5;
	}
	
	function admin(){
		if($this->_g("lid")) $this->lid = $this->_g("lid");
		else  $this->lid = 1;
		
		//helper
		$this->language = $this->getLanguageList();
		$this->View->assign('language',$this->language);
			global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN']);
		
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$filter = '';
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;
	
		/* list article */
		$sql = "
			SELECT *
			FROM axis_kakao_emoticon con
			WHERE n_status<>3
			{$filter}
			ORDER BY con.created_date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
	
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total
			FROM axis_kakao_emoticon con
			WHERE n_status<>3 ");
		
		
		$total = intval($totalList['total']);
				
		// pr($list);
		$this->View->assign('list',$list);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=galeri"));	
		return $this->View->toString("application/admin/galeri/galeri_list.html");
	}
	
	
	function add(){
		global $CONFIG;
	
		$name 			= $this->_p('name');
		$owner 			= $this->_p('owner');
		$email 			= $this->_p('email');
		$n_status 		= $this->_p('n_status');
		$publish_date 	= $this->_p('publish_date');
		$expired_date 	= $this->_p('expired_date');
		
	
		if($this->_p('save')){
			if( $owner=='' ){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/galeri/galeri_new.html");
			}
			$sql = "INSERT INTO axis_kakao_emoticon 
				(email,name,owner,n_status,publish_date,expired_date,created_date) 
				VALUES 
				('{$email}','{$name}','{$owner}','{$n_status}','{$publish_date}','{$expired_date}',NOW())";
			$this->query($sql);
			
			$last_id = $this->getLastInsertId();
			if(!$last_id){
				$this->View->assign("msg","Add process failure");
				return $this->View->toString("application/admin/galeri/galeri_new.html");
			}else{
				
				if ($_FILES['image']['name']!=NULL) {
					include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					list($file_name,$ext) = explode('.',$_FILES['image']['name']);
					$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
					try{
						$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
					}catch (Exception $e){
						// handle error here however you'd like
					}
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/{$img}")){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/{$img}");
						$maxSize = 1000;
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
						// $thumb->adaptiveResize($width,$height);
						// $big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=galeri");
			}
		}
		return $this->View->toString("application/admin/galeri/galeri_new.html");
	}
	
	
	function edit(){
		global $CONFIG;
		$id 			= $this->_g('id');
		
	
		if(! $this->_p('save')){
			$sql = "SELECT * FROM axis_kakao_emoticon WHERE id={$id} LIMIT 1";
			$qData = $this->fetch($sql);
			foreach($qData as $key => $val){
				$this->View->assign($key,$val);
			}
			
		}else{
		
			$id 			= $this->_p('id');
			$name 			= $this->_p('name');
			$owner 			= $this->_p('owner');
			$email 			= $this->_p('email');
			$n_status 		= $this->_p('n_status');
			$publish_date 	= $this->_p('publish_date');
			$expired_date 	= $this->_p('expired_date');
		
		
			if(  $owner=='' ){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/galeri/galeri_edit.html");
			}
			$sql = "UPDATE axis_kakao_emoticon SET name='{$name}',owner='{$owner}',email='{$email}',
														n_status={$n_status},
														publish_date='{$publish_date}',
														expired_date='{$expired_date}'
														
														WHERE id={$id} LIMIT 1";
			;

			$last_id = $id;
			// pr($sql);exit;
			if(!$this->query($sql)){
				$this->View->assign("msg","edit process failure");
				return $this->View->toString("application/admin/galeri/galeri_edit.html");
			}else{
						
				if ($_FILES['image']['name']!=NULL) {
					include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					list($file_name,$ext) = explode('.',$_FILES['image']['name']);
					$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
					try{
						$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
					}catch (Exception $e){
						// handle error here however you'd like
					}
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/{$img}")){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/{$img}");
						$maxSize = 1000;
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
						// $thumb->adaptiveResize($width,$height);
						// $big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=galeri");
			}
		}
		
		return $this->View->toString("application/admin/galeri/galeri_edit.html");
	}
	
	function delete(){
		$id = $this->_g('id');
		if( !$this->query("UPDATE axis_kakao_emoticon SET n_status=3 WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=galeri");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=galeri");
		}
	}
	

	
	
	
	function downloadreport(){
		return false;
		$lid = $this->Request->getParam('lid');
		$id_cat = $this->Request->getParam('id_cat');
		$id_type = $this->Request->getParam('id_type');
		$filter = $lid=='' ? "" : " AND con.lid = {$lid} ";
		$filter .= $id_cat=='' ? "" : " AND con.categoryid = {$id_cat} ";
		$filter .= $id_type=='' ? "" : " AND con.articleType = {$id_type} ";
		$sql = "
		SELECT '' as no,con.id,con.parentid,con.lid,con.title,con.brief,con.content,con.prize,con.categoryid,con.articleType,con.created_date,con.posted_date,con.online,con.n_status 
		FROM axis_kakao_emoticon con 
		LEFT JOIN axis_kakao_emoticon_type typ ON con.articleType = typ.id
		WHERE n_status<>3 AND typ.content=0 {$filter} 
		ORDER BY con.created_date DESC;";
		$r = $this->fetch($sql,1);
		
		$language = $this->getLanguageList();
		$category = $this->getCategoryList();
		$type = $this->getTypeList();
		$online = array(1=>"Iphone",2=>"Android",3=>"Blackberry",4=>"Feature Phone");
		$status = array(0=>"Pending",1=>"Staging",2=>"Production",3=>"Deleted");
		
		foreach($language as $key => $val){
			$lang[$val['id']] = $val['language'];
		}
		
		foreach($category as $key => $val){
			$cat[$val['id']] = $val['category'];
		}
		
		foreach($type as $key => $val){
			$type[$val['id']] = $val['type'];
		}
		
		$no=1;
		foreach($r as $key => $val){
			$val['no'] = $no++;
			$val['lid'] = $lang[$val['lid']];
			$val['categoryid'] = $cat[$val['categoryid']];
			$val['articleType'] = $type[$val['articleType']];
			$val['online'] = $online[$val['online']];
			$val['n_status'] = $status[$val['n_status']];
			$data[] = $val;
		}
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Utility/PHPExcelWrapper.php";
		$excel = new PHPExcelWrapper();
		$excel->setGlobalBorder(true, 'allborders', '00000000');
		$excel->setHeader(array('No','ID','Parentid','Language','Title','Brief','Content','Prize','Category','Type Article','Created Date','Posted Date','Online','Status'));
		$excel->getExcel($data,'list_Article');
		exit;
	}
	
	function inputparent($last_id=null){
		if($last_id==null)return false;
		$this->query("UPDATE axis_kakao_emoticon SET parentid={$last_id} WHERE id={$last_id} LIMIT 1");
	}
	
	function inputImage($last_id=null,$img=null){
		if($last_id==null)return false;
		if($img==null)return false;
		$this->query("UPDATE axis_kakao_emoticon SET image='{$img}' WHERE  id={$last_id} LIMIT 1");
		return false;
	}

	function getLanguageList(){
		$language = $this->fetch("SELECT * FROM axis_language_category",1);
		return $language;
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM axis_kakao_emoticon_type WHERE content IN ('0')",1);
		return $type;
	}
	
	function getCategoryList(){
		$type = $this->fetch("SELECT * FROM axis_kakao_emoticon_category",1);
		return $type;
	}
	
	function getDeviceList(){
		$type = $this->fetch("SELECT * FROM axis_news_device_type ORDER BY id",1);
		return $type;
	}
	
	
	function fixTinyEditor($content){
		global $CONFIG;
		$content = str_replace("\\r\\n","",$content);
		$content = htmlspecialchars(stripslashes($content), ENT_QUOTES);
		// $content = str_replace("../contents", "contents", $content);

		//$content = htmlspecialchars( stripslashes($content) );
		$content = str_replace("&lt;", "<", $content);
		$content = str_replace("&gt;", ">", $content);
		$content = str_replace("&quot;", "'", $content);
		$content = str_replace("&amp;", "&", $content);
		return $content;
	}
	
	
	function save_crop(){
		global $CONFIG;
		$files['source_file'] = $this->_p('imageFilename');
		$files['url'] = $CONFIG['LOCAL_PUBLIC_ASSET'].'galeri/';
		$files['real_url'] = $CONFIG['LOCAL_PUBLIC_ASSET']."galeri/";
		$arrFilename = explode('.',$files['source_file']);
		if($files==null) return false;
		$targ_w = $this->_p('w');
		$targ_h = $this->_p('h');
		$jpeg_quality = 90;	
		
		$src = 	$files['real_url'].$files['source_file'];
		$file_ext = strtolower($arrFilename[sizeof($arrFilename)-1]);
		
		if($file_ext=='jpg' || $file_ext=='jpeg' ){
			
			$img_r = imagecreatefromjpeg($src);
		}
		if($file_ext=='png' ) {
			$img_r = imagecreatefrompng($src);
			imagealphablending($img_r, true);
		}
		if($file_ext=='gif' ) $img_r = imagecreatefromgif($src);
		
		
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h ) or die('Cannot Initialize new GD image stream');
		
		if($file_ext=='png'){
			imagesavealpha($dst_r, true);
			imagealphablending($dst_r, false);
			$transparent = imagecolorallocatealpha($dst_r, 0, 0, 0, 127);
			imagefill($dst_r, 0, 0, $transparent);

		}
		
		imagecopyresampled($dst_r,$img_r,0,0,$this->_p('x'),$this->_p('y'),$targ_w,$targ_h, $this->_p('w'),$this->_p('h'));		
		
		// header('Content-type: image/jpeg');
		if($file_ext=='jpg' || $file_ext=='jpeg' ) imagejpeg($dst_r,$files['url'].$files['source_file'],$jpeg_quality);
		if($file_ext=='png')imagepng($dst_r,$files['url'].$files['source_file']);
		if($file_ext=='gif') imagegif($dst_r,$files['url'].$files['source_file']);
		
		include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					
		try{
			$thumb = PhpThumbFactory::create($CONFIG['BASE_DOMAIN'].'public_assets/galeri/'.$files['source_file']);
		}catch (Exception $e){
			// handle error here however you'd like
		}
		list($width, $height, $type, $attr) = getimagesize("{$CONFIG['BASE_DOMAIN']}public_assets/galeri/{$files['source_file']}");
		$maxSize = 1000;
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
		// $thumb->adaptiveResize($width,$height);
		// $big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/".$img);
		$thumb->adaptiveResize($w_small,$h_small);
		$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/small_".$files['source_file'] );
		$thumb->adaptiveResize($w_tiny,$h_tiny);
		$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/tiny_".$files['source_file']);
						
						
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		print json_encode(array('image'=>$CONFIG['BASE_DOMAIN'].'public_assets/galeri/'.$files['source_file']
								
								)
							);
		exit;
	}
}