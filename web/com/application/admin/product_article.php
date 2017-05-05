<?php
error_reporting(E_ALL);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class product_article extends Admin{
	function __construct(){	
		parent::__construct();	
		$this->type = 28;
	}
	
	function admin(){
		if($this->_g("lid")) $this->lid = $this->_g("lid");
		else  $this->lid = 1;
		global $CONFIG;
		
		//helper
		$this->language = $this->getLanguageList();
		$this->category = $this->getCategoryList();
		$this->device = $this->getDeviceList();
		$this->View->assign('cat',$this->category);
		$this->View->assign('device',$this->device);
		$this->View->assign('language',$this->language);
		$this->View->assign('baseUrl',$CONFIG['BASE_DOMAIN_PATH']);
		$this->View->assign('product_article_detail',"index.php?page=produk&act=article&id=");
		
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$filter ="";
		$id_cat = $this->_g("id_cat") == NULL ? '' : $this->_g("id_cat");
		$startdate = $this->_g("startdate") == NULL ? '' : $this->_g("startdate");
		$enddate = $this->_g("enddate") == NULL ? '' : $this->_g("enddate");
		$filter .= $id_cat=='' ? "" : "AND con.categoryid='{$id_cat}' ";
		$filter .= $startdate=='' ? "" : "AND con.posted_date>='{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND con.posted_date<'{$enddate}' ";
		
		$search = $this->_g("search");
		if($search) $filter .=" AND title like '%{$search}%' ";
		$this->View->assign('search',$search);
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;

		/* list article */
		$sql = "
			SELECT con.*,dev.deviceid
			FROM axis_news_content con
			LEFT JOIN axis_news_content_device_group dev ON con.parentid = dev.parentid
			WHERE con.n_status<>3
			AND con.articleType={$this->type}
			AND con.lid={$this->lid}
			{$filter}
			ORDER BY con.created_date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		if($list){
			foreach($this->category as $val){
				$arrCategory[$val['id']] = $val['category'];			
			}
			foreach($list as $val){
				$arrPid[] = $val['parentid'];
			}
			if($arrPid) $strPid = implode(',',$arrPid);
			else $strPid = false;
			$langData = $this->checkLanguage($strPid);
			
			//merge with language
			foreach($list as $key => $val){
				
				$list[$key]['language_data'] = $langData[$val['parentid']];
				if(array_key_exists($val['categoryid'],$arrCategory)) $list[$key]['category'] = $arrCategory[$val['categoryid']];
				else $list[$key]['category'] = false;
			}
		}
	
		
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total
			FROM axis_news_content con
			WHERE n_status<>3
			AND con.articleType={$this->type}
			AND con.lid={$this->lid}
			{$filter}
			GROUP BY con.parentid",1);		
		
		$total = intval(count($totalList));

		$this->View->assign('list',$list);
		$this->View->assign('lid',$this->lid);
		$this->View->assign('id_cat',$id_cat);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=product_article&lid={$this->lid}&id_cat={$id_cat}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/product_article/product_article_list.html");
	}
	
	function checkLanguage($pid=null){
		if($pid==null)return false;
		//cheack available language
		$sql = " SELECT * FROM axis_language_category";
		$qData = $this->fetch($sql,1);
		foreach($qData as $val){
				$arrLanguage[$val['id']] = $val['language'];
		}
		//compare with content
		$sql = "
			SELECT *
				FROM axis_news_content con
				WHERE n_status<>3
				AND con.articleType={$this->type}
				AND parentid IN  ({$pid})
				LIMIT 50;
			";
		$qData = $this->fetch($sql,1);
		
		foreach($qData as $key => $val){
			$arrContentLang[$val['parentid']][$val['lid']] = true;
			foreach($arrLanguage as $kLang => $vLang){
				if(array_key_exists($kLang,$arrContentLang[$val['parentid']])) $langData[$kLang] = true;
				else $langData[$kLang] = false;
			}
			$arrContent[$val['parentid']] = $langData;
			$arrContent[$val['parentid']]['langDesc'] = $arrLanguage;
		}
		
		return $arrContent;		
	}
	
	function add(){	
		global $CONFIG;
		if($this->_p('save')){
		$lid 			= $this->Request->getPost('lid');
		$title 			= $this->Request->getPost('title');
		$brief 			= $this->Request->getPost('brief');
		$content 		= $this->Request->getPost('content');		
		$content 	  	= $this->fixTinyEditor( $content );
		$status 		= $this->Request->getPost('n_status');
		$posted_date 	= $this->Request->getPost('posted_date');
		$expired_date 	= $this->Request->getPost('expired_date');
		$categoryid		= $this->Request->getPost('categoryid');
		$prize 			= $this->Request->getPost('prize');
		
		
			if( $lid=='' || $title=='' || $content==''){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/product_article/product_article_new.html");
			}
			$sql = "INSERT INTO axis_news_content 
				(lid,title,brief,prize,content,articleType,categoryid,n_status,created_date,posted_date,expired_date,authorid) 
				VALUES 
				('{$lid}','{$title}','{$brief}','{$prize}',\"{$content}\",'{$this->type}','{$categoryid}','{$status}',NOW(),'{$posted_date}','{$expired_date}',{$this->Session->getVariable("uid")})";
			$this->query($sql);
			
			$last_id = $this->getLastInsertId();
			if(!$last_id){
				$this->View->assign("msg","Add process failure");
				return $this->View->toString("application/admin/product_article/product_article_new.html");
			}else{
			
				//update parentid
				$this->inputparent($last_id);
			
				
				// pr($last_id);exit;
				if ($_FILES['image']['name']!=NULL) {
					include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					list($file_name,$ext) = explode('.',$_FILES['image']['name']);
					$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
					try{
						$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
					}catch (Exception $e){
						// handle error here however you'd like
					}
					
					//if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}")){
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}")){
						//list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}");
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}");
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
						$thumb->adaptiveResize($width,$height);
						//$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/".$img);
						$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						//$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/small_".$img );
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						//$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/tiny_".$img );
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=product_article");
			}
		}
		return $this->View->toString("application/admin/product_article/product_article_new.html");
	}
	
	function add_language(){
		$id = $this->_g('id');
		$lid = $this->Request->getParam('id_lang');
		$sql = "SELECT * FROM axis_news_content WHERE id={$id} LIMIT 1";
		$qData = $this->fetch($sql);
		
		$sql ="
		INSERT INTO axis_news_content 				
		(parentid,lid,title,brief,prize,content,image,articleType,categoryid,n_status,created_date,posted_date,expired_date,authorid) 
		VALUES 
		({$qData['parentid']},{$lid},'{$qData['title']}','{$qData['brief']}','{$qData['prize']}',\"{$qData['content']}\",'{$qData['image']}',{$qData['articleType']},{$qData['categoryid']},'{$qData['n_status']}',NOW(),'{$qData['posted_date']}','{$qData['expired_date']}',{$this->Session->getVariable("uid")})";
		// pr($sql);exit;
		$this->query($sql);
		if(!$this->getLastInsertId()){
			return $this->View->showMessage('Gagal', "index.php?s=product_article");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product_article");
		}
	}
	
	function edit(){
		global $CONFIG;
		$parentid 		= $this->_g('id');
		$lid 			= $this->_g('lid');
		
		
		if(! $this->_p('save')){
			$sql = "SELECT * FROM axis_news_content WHERE parentid={$parentid} AND lid = {$lid} AND articleType={$this->type} LIMIT 1";
			$qData = $this->fetch($sql);
			foreach($qData as $key => $val){
				$this->View->assign($key,$val);
			}
			$deviceData = $this->getDeviceContent($parentid);
			$this->View->assign('deviceData',$deviceData);
		}else{
			$id 			= $this->_p('id');
			$lid 			= $this->_p('lid');
			$title 			= $this->_p('title');
			$brief 			= $this->_p('brief');
			$content 		= $this->_p('content');		
			$content 	  	= $this->fixTinyEditor( $content );
			$status 		= $this->_p('n_status');
			$posted_date 	= $this->_p('posted_date');
			$expired_date 	= $this->_p('expired_date');
			$prize 			= $this->_p('prize');
			$parentid		= $this->_p('parentid');
			$categoryid 	= $this->_p('categoryid');
			
			if( $lid=='' || $title=='' || $content==''){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/product_article/product_article_edit.html");
			}
			$sql = "UPDATE axis_news_content SET title='{$title}',brief='{$brief}',
														content=\"{$content}\",
														posted_date='{$posted_date}',
														expired_date='{$expired_date}',
														n_status='{$status}',
														prize='{$prize}',
														categoryid='{$categoryid}',
														authorid = {$this->Session->getVariable("uid")}
														WHERE id={$id} AND lid={$lid} LIMIT 1";
			
			
			$last_id = $parentid;
		
			// pr($sql);exit;
			if(!$this->query($sql)){
				$this->View->assign("msg","edit process failure");
				return $this->View->toString("application/admin/product_article/product_article_edit.html");
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
					
					//if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}")){
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}")){
						//list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}");
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/{$img}");
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
						$thumb->adaptiveResize($width,$height);
						//$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/".$img);
						$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						//$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/small_".$img );
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						//$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/tiny_".$img );
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product_article/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=product_article");
			}
		}
		
		return $this->View->toString("application/admin/product_article/product_article_edit.html");
	}
	
	function hapus(){
		$parentid = $this->_g('parentid');
		if( !$this->query("UPDATE axis_news_content SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=product_article");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product_article");
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
		FROM axis_news_content con 
		LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
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
	
	function getDeviceContent($id=null){
		if($id==null)return false;
		$articleData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
		$pagesArr = explode(',',$articleData['deviceid']);
		foreach($pagesArr as $val){
			$arrPages[$val] = $val;
		}
		return $arrPages;
	}
	
	function inputdevice($last_id=null,$id_device=null){
			if($last_id==null)return false;
			if($id_device==null)return false;
			
			$sql = "
				INSERT INTO axis_news_content_device_group (parentid,deviceid,n_status ) 
				VALUES ({$last_id},'{$id_device}',1)
				ON DUPLICATE KEY UPDATE deviceid = '{$id_device}'
			";
			// pr($sql);exit;
			$this->query($sql);
	}
	
	function inputparent($last_id=null){
		if($last_id==null)return false;
		$this->query("UPDATE axis_news_content SET parentid={$last_id} WHERE id={$last_id} LIMIT 1");
	}
	
	function inputImage($last_id=null,$img=null){
		if($last_id==null)return false;
			if($img==null)return false;
		$this->query("UPDATE axis_news_content SET image='{$img}' WHERE id={$last_id} LIMIT 1");
		return false;
	}

	function getLanguageList(){
		$language = $this->fetch("SELECT * FROM axis_language_category",1);
		return $language;
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_type WHERE content IN ('0')",1);
		return $type;
	}
	
	function getCategoryList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_category WHERE used=2",1);
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
		$content = str_replace("../", "", $content);

		//$content = htmlspecialchars( stripslashes($content) );
		$content = str_replace("&lt;", "<", $content);
		$content = str_replace("&gt;", ">", $content);
		$content = str_replace("&quot;", "'", $content);
		$content = str_replace("&amp;", "&", $content);
		return $content;
	}
	
	function downloadreport_old(){
		$total_per_page = 10;
		$sql = "SELECT * FROM axis_news_content con";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$this->close();	
		
		$export_file = "Article_".date('Y-m-d').".xls";
		ob_end_clean();
		ini_set('zlib.output_compression','Off');
	   
		header('Pragma: public');
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");                  // Date in the past   
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
		header ("Pragma: no-cache");
		header("Expires: 0");
		header('Content-Transfer-Encoding: none');
		header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
		header("Content-type: application/x-msexcel");                    // This should work for the rest
		header('Content-Disposition: attachment; filename="'.basename($export_file).'"'); 
		$this->View->assign('list',$list);
		print $this->View->toString("application/admin/Article/article_list.html");
		exit;
	}	
}