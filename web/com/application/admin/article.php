<?php
error_reporting(0);
global $ENGINE_PATH;
global $CONFIG;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once $ENGINE_PATH."config/config.inc.php";

class article extends Admin{

	var $type = '';
	var $category = '';
	
	function __construct(){	
		parent::__construct();	
		global $logger;
		$this->logger = $logger;
	}
	
	function admin(){

		//get admin role
		foreach($this->roler as $key => $val){
			$this->View->assign($key,$val);
		}
		//get specified admin role if true
		if($this->specified_role){
			foreach($this->specified_role as $val){
				$type[] = $val['type'];
				if($val['requestID']==$this->Request->getParam('s')) $category[] = $val['category'];
				//$category[] = $val['category'];
			}
			if($type) $this->type = implode(',',$type);
			else return false;
			if($category) $this->category = implode(',',$category);
			else return false;
		}		
		
		/*
		example for status update
		 if($this->roler['approver']) $status 		= $this->Request->getPost('n_status');
		 else $status 	 = 0;
		*/
		
		global $CONFIG;
		$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		// pr($this->roler);
		if($this->Request->getParam('act') == 'add' ){
			return $this->Article_add();
		}elseif($this->Request->getParam('act') == 'edit' ){
			return $this->Article_edit();
		}elseif($this->Request->getParam('act') == 'hapus' ){
			return $this->Article_delete();
		}elseif($this->Request->getParam('act') == 'add_language' ){
			return $this->Article_add_language();
		}elseif($this->Request->getParam('act') == 'excelreport' ){
			return $this->downloadreport();
		}elseif($this->Request->getParam('act') == 'excel_comment' ){
			return $this->excel_comment();
		}elseif($this->Request->getParam('act') == 'comment' ){
			return $this->comment_article();
		}elseif($this->Request->getParam('act') == 'change_status' ){
			return $this->change_status();
		}elseif($this->Request->getParam('act') == 'change_online' ){
			return $this->change_online();
		}elseif($this->Request->getParam('act') == 'change_prize' ){
			return $this->change_prize();
		}elseif($this->Request->getParam('act') == 'change_status_comment' ){
			return $this->change_status_comment();
		}elseif($this->Request->getParam('act') == 'savecrop' ){
			return $this->save_crop();
		} else {
			return $this->Article_list();
		}
	}

	function Article_list(){
		$search = $this->_g("search") == NULL ? '' : $this->_g("search");
		$device = $this->getDeviceList();
		$lid = $this->Request->getParam("lid") == NULL ? '' : $this->Request->getParam("lid");
		$id_cat = $this->Request->getParam("id_cat") == NULL ? '' : $this->Request->getParam("id_cat");
		$id_type = $this->Request->getParam("id_type") == NULL ? '' : $this->Request->getParam("id_type");
		$startdate = $this->Request->getParam("startdate") == NULL ? '' : $this->Request->getParam("startdate");
		$enddate = $this->Request->getParam("enddate") == NULL ? '' : $this->Request->getParam("enddate");
		
		$filter  = $lid=='' ? "" : "AND con.lid='{$lid}' ";
		$filter .= $startdate=='' ? "" : "AND con.posted_date >= '{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND con.posted_date < '{$enddate}' ";		
		$filter  .= $search=='' ? "" : "AND (con.title LIKE '%{$search}%' OR con.brief LIKE '%{$search}%' OR con.content LIKE '%{$search}%') ";
		$this->View->assign('search',$search);
		//check klo ada specified role nya
		//if($this->type) {
		//	$filter .= " AND con.articleType IN ({$this->type}) ";
		//}else {
			$artType = explode(',',$this->type);
			if ($id_type!='') {
				if(in_array($id_type,$artType)){ $filter .= $id_type=='' ? "" : "AND con.articleType='{$id_type}'";}
				else $filter .= "AND con.articleType IN ({$id_type}) ";
			}
		//}
		
		if ($this->Request->getParam("cari")=='cari' && $id_cat!='') {
			$filter .= "AND con.categoryid IN ({$id_cat}) ";
		} else {
			if($this->category) {
				$filter .= "AND con.categoryid IN ({$this->category}) ";
			}
		}
		
		/* if($this->category) {
			$filter .= "AND con.categoryid IN ({$this->category}) ";
		} else {
			$arrCat = explode(',',$this->category);
			if(in_array($id_cat,$arrCat)){ $filter .= $id_cat=='' ? "" : "AND con.categoryid='{$id_cat}' ";}
			else $filter .= "AND con.categoryid IN ({$id_cat}) ";
		} */
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;		
		
		$this->open(0);
		/* list article */
		$sql = "
			SELECT con.*,lang.language,cat.category,typ.type as type_name,typ.content
			FROM axis_news_content con
			LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
			LEFT JOIN axis_language_category lang ON con.lid = lang.id 
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
			WHERE n_status<>3
			AND typ.content IN (0)
			{$filter}
			GROUP BY con.parentid
			ORDER BY con.posted_date DESC
			LIMIT {$start},{$total_per_page}
		";
		//print_r($sql);
		$list = $this->fetch($sql,1);
		
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content con 
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id 
			WHERE n_status<>3 AND typ.content IN ('0') {$filter} GROUP BY con.parentid",1);
		
		/* Hitung total comment article*/
		$list_totalComment = $this->fetch("SELECT contentid,count(contentid) as total_comment FROM axis_news_content_comment GROUP BY contentid",1);
		
		$this->close();
		$total = count($list_totalall);

		$list_article = $this->fetch("SELECT con.*,lang.language,cat.category,typ.type as type_name,typ.content,dev.deviceid
									FROM  axis_news_content con
									LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
									LEFT JOIN axis_language_category lang ON con.lid = lang.id 
									LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
									LEFT JOIN axis_news_content_device_group dev ON con.parentid = dev.parentid
									WHERE con.n_status<>3 AND typ.content IN ('0')",1);		
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$num[$v['parentid']] = $v['no'];
			$arrParentId[] = $v['parentid'];
		}
		
		if($arrParentId) $strparentId = implode(',',$arrParentId);
		else $strparentId = false;
		
		if($strparentId){
			$sql =" SELECT * FROM axis_news_content_banner WHERE parentid IN ({$strparentId}) ";
			$bannerData = $this->fetch($sql,1);
			if($bannerData){
				foreach($bannerData as $val){
					$parentidinbanner[$val['parentid']] = true;				
				}
			}
		}else $parentidinbanner = false;		
		
		foreach ($list_totalComment as $k => $v) {
			$arrTotalcomment[$v['contentid']] = $v['total_comment'];			
		}	
		
		foreach($list_article as $key => $val){
			$val['no'] = $num[$val['parentid']];
			$val['total_comment'] = $arrTotalcomment[$val['id']];
				if($parentidinbanner){
					if(array_key_exists($val['parentid'],$parentidinbanner)) $val['is_banner'] = true;
					else $val['is_banner'] = false;
				}
				
			$deviceArr = explode(',',$val['deviceid']);			
			foreach($device as $vals){
				$arrDeviceCat[$vals['id']] = $vals['type'];
			}
			
			$arrDevice = null;
			foreach ($deviceArr as $v) {
				$arrDevice[] = $arrDeviceCat[$v];
			}
			
			$val['deviceid'] = implode(',',$arrDevice);
			$arrListnews[$val['parentid']][$val['id']] = $val;
			$arrTempnews[$val['parentid']][$val['lid']] = $val['lid'];
			$arrTempcomment[$val['parentid']][$val['lid']] = $val['total_comment'];
		}
		
		$this->View->assign('total_comment',$arrTempcomment);
		
		/* list bahasa */
		$list_lang = $this->fetch("SELECT * FROM  axis_language_category lg",1);
		
		/* list data */
		foreach($list as $key => $val){
			$arrNewsOut[$val['id']]=$arrListnews[$val['parentid']];
			foreach($list_lang as $vLang){
				if(@$arrTempnews[$val['parentid']][$vLang['id']]) $arrNewsOut[$val['id']]['hasLang'][$vLang['id']] = true;
				else $arrNewsOut[$val['id']]['hasLang'][$vLang['id']]= false;
			}
		}
		
		$language = $this->getLanguageList();
		$type = $this->getTypeList();
		$category = $this->getCategoryList();
		$cek_cat = count($category);
		$device = $this->getDeviceList();
		$this->View->assign('language',$language);
		$this->View->assign('lid',$lid);
		$this->View->assign('id_cat',$id_cat);
		$this->View->assign('id_type',$id_type);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('type',$type);
		$this->View->assign('cat',$category);
		$this->View->assign('cek_cat',$cek_cat);
		$this->View->assign('device',$device);
		$this->View->assign('start',$start);
		$this->View->assign('list',$arrNewsOut);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=article&lid={$lid}&id_cat={$id_cat}&id_type={$id_type}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/Article/article_list.html");
	}
	
	function Article_add(){
		global $CONFIG;
		$authorid = $this->Session->getVariable("uid");
		
		$parentid 		= $this->Request->getPost('parentid');
		$lid 			= $this->Request->getPost('lid');
		$title 			= $this->Request->getPost('title');
		$brief 			= $this->Request->getPost('brief');
		$content 		= $this->Request->getPost('content');
		$content 	  	= $this->fixTinyEditor( $content );
		$categoryid 	= $this->Request->getPost('categoryid');
		$articleType	= $this->Request->getPost('articleType');
		$url 			= $this->Request->getPost('url');
		$sourceurl 		= $this->Request->getPost('sourceurl');
		
		if($this->roler['approver']) $status 		= $this->Request->getPost('n_status');
		else $status 	 = 0;
		$posted_date 	= $this->Request->getPost('posted_date');
		$expired_date 	= $this->Request->getPost('expired_date');
		$arrDeviceID 	= $_POST['device'];
		
		$id_device 		= implode(',',$_POST['device']);
		$language 		= $this->getLanguageList();
		$type 			= $this->getTypeList();
		$category 		= $this->getCategoryList();
		$cek_cat		= count($category);
		$device 		= $this->getDeviceList();
		
		foreach ($arrDeviceID as $k => $v) {
			$key_device[$v] = $v;
		}
		
		$this->View->assign('language',$language);
		$this->View->assign('type',$type);
		$this->View->assign('cat',$category);
		$this->View->assign('cek_cat',$cek_cat);
		$this->View->assign('device',$device);
		$this->View->assign('lid',$lid);
		$this->View->assign('title',$title);
		$this->View->assign('brief',$brief);
		$this->View->assign('content',$content);
		$this->View->assign('id_device',$key_device);
		$this->View->assign('categoryid',$categoryid);
		$this->View->assign('id_type',$articleType);
		$this->View->assign('categoryid',$categoryid);
		$this->View->assign('url',$url);
		$this->View->assign('sourceurl',$sourceurl);
		$this->View->assign('posted_date',$posted_date);
		$this->View->assign('expired_date',$expired_date);
		$this->View->assign('status',$status);

		if( $lid=='' || $title=='' ){
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/Article/article_new.html");
		}
		
		//check if category id is exist in admin role
		if($this->category) {
			$arrCategory 	= explode(',',$this->category);
			if(!in_array($categoryid,$arrCategory)) {
				return $this->View->showMessage('you are not authorize for this category id', "index.php?s=article");
			}
		}
		
		if($this->type) {
			$arrType 	= explode(',',$this->type);
			if(!in_array($articleType,$arrType)) {
				return $this->View->showMessage('you are not authorize for this article id', "index.php?s=article");
			}
		}
		
		$sql = "INSERT INTO axis_news_content (lid,title,brief,content,categoryid,articleType,prize,url,sourceurl,online,n_status,created_date,posted_date,expired_date,authorid) 
			VALUES ('{$lid}','{$title}',\"{$brief}\",\"{$content}\",'{$categoryid}','{$articleType}','{$prize}','{$url}','{$sourceurl}','{$online}','{$status}',NOW(),'{$posted_date}','{$expired_date}','{$authorid}')";
			
		$this->logger->log($sql);
		
		if( !$this->query($sql)){
			$this->View->assign("msg","Add process failure");
			return $this->View->toString("application/admin/Article/article_new.html");
		}else{

			$last_id = $this->getLastInsertId();
			if ($_FILES['image']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_name,$ext) = explode('.',$_FILES['image']['name']);
				$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
				try{
					$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}article/".$img)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/{$img}");
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
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/big_".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/tiny_".$img );
				}
				if ($parentid==NULL) {
					$this->inputparent($last_id);
				}
				$this->inputImage($last_id,$lid,$img);
			}
			
			if ($_FILES['image_thumb']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_nameThumb,$ext_thumb) = explode('.',$_FILES['image_thumb']['name']);
				$img_thumb = md5($_FILES['image_thumb']['name'].rand(1000,9999)).".".$ext_thumb;
				try{
					$thumb = PhpThumbFactory::create( $_FILES['image_thumb']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image_thumb']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}article/".$img_thumb)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/{$img_thumb}");
					$maxSize = 720;
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
					
					$w_small = $width - ($width * 0.45);
					$h_small = $height - ($height * 0.45);
					$w_tiny = $width - ($width * 0.65);
					$h_tiny = $height - ($height * 0.65);
					
					//resize the image
					$thumb->adaptiveResize($width,$height);
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_big_".$img_thumb);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_medium_".$img_thumb );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_".$img_thumb );
				}
				$this->inputImageThumb($last_id,$lid,$img_thumb);
			}
			
			if ($parentid==NULL) {
				$this->inputparent($last_id);
			}
			
			if($last_id){
				$sql = "
					INSERT INTO axis_news_content_device_group (parentid,deviceid,n_status ) 
					VALUES ({$last_id},'{$id_device}',1)
				";
				$this->query($sql);
				if(!$this->getLastInsertId()){
					return $this->View->showMessage('Article Berhasil diupload', "index.php?s=article");
				}
			}
			
			$this->log->sendActivity('add article',$last_id);
			return $this->View->showMessage('Berhasil', "index.php?s=article");
		}
		return $this->View->toString("application/admin/Article/article_new.html");
	}
	
	function Article_add_language(){
		$id = $this->Request->getParam('id');
		$id_lang = $this->Request->getParam('id_lang');
		$sql = "SELECT * FROM axis_news_content WHERE id={$id}";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$parent_id = $list['parentid'];
		$title = $list['title'];
		$brief = $list['brief'];
		$content = $list['content'];
		$image = $list['image'];
		$imageThumb = $list['thumbnail_image'];
		$categoryid = $list['categoryid'];
		$articleType = $list['articleType'];
		$online = $list['online'];
		$url = $list['url'];
		$sourceurl = $list['sourceurl'];
		$authorid = $list['authorid'];
		$status = 0;
		$posted_date = $list['posted_date'];
		$expired_date = $list['expired_date'];
		$sql = "INSERT INTO axis_news_content (parentid,lid,title,brief,content,image,thumbnail_image,categoryid,articleType,online,n_status,created_date,posted_date,expired_date,url,sourceurl,authorid) 
			VALUES ('{$parent_id}','{$id_lang}','{$title}',\"{$brief}\",\"{$content}\",'{$image}','{$imageThumb}','{$categoryid}','{$articleType}','{$online}','{$status}',NOW(),'{$posted_date}','{$expired_date}','{$url}','{$sourceurl}','{$authorid}')";
		
			// pr($sql);exit;
		$this->logger->log($sql);
		if( !$this->query($sql)){
			return $this->View->showMessage('Gagal', "index.php?s=article");
		}else{
			$this->log->sendActivity('add article',$this->getLastInsertId());
			return $this->View->showMessage('Berhasil', "index.php?s=article");
		}
	}
	
	function Article_edit(){
		global $CONFIG;
		$authorid = $this->Session->getVariable("uid");
		$id 			= intval($this->Request->getParam('id'));
		$id_lang 		= intval($this->Request->getParam('id_lang'));
		$lid	 		= $this->Request->getParam('lang_id');
		if($this->_p('simpan')==true){
			$parentid 		= $this->Request->getPost('parentid');
			$lid 			= $this->Request->getPost('lid');
			$title 			= $this->Request->getPost('title');
			$brief 			= $this->Request->getPost('brief');
			$content 		= $this->Request->getPost('content');
			$content 	  	= $this->fixTinyEditor( $content );
			$categoryid 	= $this->Request->getPost('categoryid');		
			$url 			= $this->Request->getPost('url');
			$sourceurl 		= $this->Request->getPost('sourceurl');
			$id_device 		= implode(',',$_POST['device']);
			if($this->roler['approver']) $status 		= $this->Request->getPost('n_status');
			else $status 	 = 0;
			$posted_date 	= $this->Request->getPost('posted_date');
			$expired_date 	= $this->Request->getPost('expired_date');
			$articleType	= $this->Request->getPost('articleType');
		
			if($this->type) {
				$arrType 	= explode(',',$this->type);				
				if(!in_array($articleType,$arrType)) {
					return $this->View->showMessage('you are not authorize for this article id', "index.php?s=article");
				}
			}
		}
		
		$device 		= $this->getDeviceList();
		$this->View->assign('device',$device);		
		
		if( empty($lid) && empty($title)){
			$this->View->assign('msg',"Please complete the form!");
			$article = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
			$articleData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($article) ){
				$language = $this->getLanguageList();
				$type = $this->getTypeList();
				$category = $this->getCategoryList();
				$jmlCategory = count($category);
				if($articleData){
					$pagesArr = explode(',',$articleData['deviceid']);
					foreach($pagesArr as $val){
						$arrPages[$val] = $val;
					}
					$articleData['deviceid'] = $arrPages;
					$this->View->assign('articleData',$articleData);
				}
				$this->View->assign('language',$language);
				$this->View->assign('type',$type);
				$this->View->assign('cat',$category);
				$this->View->assign('cek_cat',$jmlCategory);
				$this->View->assign("lid",$article['lid']);
				$this->View->assign("title",$article['title']);
				$this->View->assign("brief",$article['brief']);
				$this->View->assign("content",$article['content']);
				$this->View->assign("image",$article['image']);
				$this->View->assign("imagethumb",$article['thumbnail_image']);
				$this->View->assign("categoryid",$article['categoryid']);
				$this->View->assign("articleType",$article['articleType']);
				$this->View->assign("online",$article['online']);
				$this->View->assign("url",$article['url']);
				$this->View->assign("sourceurl",$article['sourceurl']);
				$this->View->assign("status",$article['n_status']);
				$this->View->assign("posted_date",$article['posted_date']);
				$this->View->assign("expired_date",$article['expired_date']);
				return $this->View->toString("application/admin/Article/article_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=article&act=edit");
			}
		}
		
		//check if category id is exist in admin role
		if($this->category) {
			$arrCategory 	= explode(',',$this->category);
			if(!in_array($categoryid,$arrCategory)) {
				return $this->View->showMessage('you are not authorize for this category id', "index.php?s=article");
			}
		}
		
		if($this->roler['approver']) $isApproverQuery = "";
		else $isApproverQuery = ",authorid='{$authorid}'";
		
		$sql = "UPDATE axis_news_content SET title='{$title}',brief=\"{$brief}\",
														content=\"{$content}\",
														categoryid='{$categoryid}',
														posted_date='{$posted_date}',
														expired_date='{$expired_date}',
														articleType='{$articleType}',
														n_status='{$status}',
														url='{$url}',
														sourceurl='{$sourceurl}' {$isApproverQuery}
														WHERE parentid={$id} AND lid={$id_lang};";
		$this->logger->log($sql);
		if(!$this->query($sql)){
			$this->View->assign("msg","Edit process failure");
			$article = $this->fetch("SELECT * FROM axis_news_content WHERE id={$id}");
			$articleData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($article) ){
				$language = $this->getLanguageList();
				$type = $this->getTypeList();
				$category = $this->getCategoryList();
				if($articleData){
					$pagesArr = explode(',',$articleData['deviceid']);
					foreach($pagesArr as $val){
						$arrPages[$val] = $val;
					}
					$articleData['deviceid'] = $arrPages;
					$this->View->assign('articleData',$articleData);
				}
				
				$this->View->assign('language',$language);
				$this->View->assign('type',$type);
				$this->View->assign('cat',$category);
				$this->View->assign("lid",$article['lid']);
				$this->View->assign("title",$article['title']);
				$this->View->assign("brief",$article['brief']);
				$this->View->assign("content",$article['content']);
				$this->View->assign("image",$article['image']);
				$this->View->assign("imagethumb",$article['thumbnail_image']);
				$this->View->assign("categoryid",$article['categoryid']);
				$this->View->assign("articleType",$article['articleType']);
				$this->View->assign("online",$article['online']);
				$this->View->assign("url",$article['url']);
				$this->View->assign("sourceurl",$article['sourceurl']);
				$this->View->assign("status",$article['n_status']);
				$this->View->assign("posted_date",$article['posted_date']);
				$this->View->assign("expired_date",$article['expired_date']);
				return $this->View->toString("application/admin/Article/article_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=article&act=edit");
			}
		}else{
			//$article = $this->fetch("SELECT * FROM axis_news_content WHERE id={$id}");
			if ($_FILES['image']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_name,$ext) = explode('.',$_FILES['image']['name']);
				$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
				try{
					$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}article/".$img)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/{$img}");
					
					//update new image for the article
					//$sql = "UPDATE axis_news_content SET image='{$img}' WHERE id={$id}";
					//$this->query($sql);	
					//-->
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
					$big = $thumb->save("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/big_".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/tiny_".$img );					
				}
				$this->inputImage($id,$id_lang,$img);
			}
			
			if ($_FILES['image_thumb']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_nameThumb,$ext_thumb) = explode('.',$_FILES['image_thumb']['name']);
				$img_thumb = md5($_FILES['image_thumb']['name'].rand(1000,9999)).".".$ext_thumb;
				try{
					$thumb = PhpThumbFactory::create($_FILES['image_thumb']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image_thumb']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}article/".$img_thumb)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}article/{$img_thumb}");
					
					$maxSize = 720;
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
					
					$w_small = $width - ($width * 0.45);
					$h_small = $height - ($height * 0.45);
					$w_tiny = $width - ($width * 0.65);
					$h_tiny = $height - ($height * 0.65);
				
					//resize the image
					$thumb->adaptiveResize($width,$height);
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_big_".$img_thumb);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_medium_".$img_thumb );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}article/realthumb_".$img_thumb );
				}
				
				$this->inputImageThumb($id,$id_lang,$img_thumb);
			}
			
			if($id_device){
				$sql = "SELECT count(*) total FROM axis_news_content_device_group WHERE parentid={$id} LIMIT 1 ";
				$qData = $this->fetch($sql);
				if($qData['total']>0){
					$sql = "UPDATE axis_news_content_device_group SET deviceid='{$id_device}' WHERE parentid={$id} LIMIT 1";
					$this->query($sql);				
				}else{
					if($id){
						$sql = "
						INSERT INTO axis_news_content_device_group (parentid,deviceid,n_status) 
						VALUES ({$id},'{$id_device}',1)
						";
					
						$this->query($sql);
						if(!$this->getLastInsertId()){
							return $this->View->showMessage('Article Berhasil diupload', "index.php?s=article");
						}
					}
				}
			}
			$this->log->sendActivity('edit article',$id);
			return $this->View->showMessage('Berhasil', "index.php?s=article");
		}
		
		$article = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
		$articleData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
		if( is_array($article) ){
			$language = $this->getLanguageList();
			$type = $this->getTypeList();
			$category = $this->getCategoryList();
			if($articleData){
				$pagesArr = explode(',',$articleData['deviceid']);
				foreach($pagesArr as $val){
					$arrPages[$val] = $val;
				}
				$articleData['deviceid'] = $arrPages;
				$this->View->assign('articleData',$articleData);
			}
			$this->View->assign('language',$language);
			$this->View->assign('type',$type);
			//$this->View->assign('cat',$category);
			$this->View->assign("lid",$article['lid']);
			$this->View->assign("title",$article['title']);
			$this->View->assign("brief",$article['brief']);
			$this->View->assign("content",$article['content']);
			$this->View->assign("image",$article['image']);
			$this->View->assign("imagethumb",$article['thumbnail_image']);
			$this->View->assign("categoryid",$article['categoryid']);
			$this->View->assign("articleType",$article['articleType']);
			$this->View->assign("online",$article['online']);
			$this->View->assign("url",$article['url']);
			$this->View->assign("sourceurl",$article['sourceurl']);
			$this->View->assign("status",$article['n_status']);
			$this->View->assign("posted_date",$article['posted_date']);
			$this->View->assign("expired_date",$article['expired_date']);
			return $this->View->toString("application/admin/Article/article_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=article&act=edit");
		}
		return $this->View->toString("application/admin/Article/article_edit.html");
	}
	
	function Article_delete(){
		$parentid = $this->Request->getParam('parentid');
		if( !$this->query("UPDATE axis_news_content SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=article");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=article");
		}
	}
	
	function comment_article(){
		$id = $this->Request->getParam("id") == NULL ? '' : $this->Request->getParam("id");
		$id_lang = $this->Request->getParam("id_lang") == NULL ? '' : $this->Request->getParam("id_lang");		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;
		
		$id_article = $this->fetch("SELECT * FROM axis_news_content WHERE n_status<>3 AND parentid={$id} AND lid={$id_lang}");
		$this->open(0);
		$sql = "
			SELECT com.*,sm.name
			FROM axis_news_content_comment com
			LEFT JOIN social_member sm ON com.userid = sm.id
			WHERE com.contentid = {$id_article[id]} AND com.n_status<>2
			ORDER BY com.date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content_comment WHERE contentid = {$id_article[id]}",1);
		$this->close();
		$total = count($list_totalall);
		
		/* list data */
		$no=1+$start;
		foreach($list as $key => $val){
			$val['no']=$no++;
			$data[]=$val;
		}
		
		$this->View->assign('list',$data);
		$this->View->assign('time',$time);
		$this->View->assign('contentid',$id_article['id']);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=article&act=comment&id={$id}&id_lang={$id_lang}"));
		return $this->View->toString("application/admin/Article/article_comment.html");
	}
	
	function change_status(){
		$parentid = intval($this->Request->getParam('parentid'));
		$status = intval($this->Request->getParam('status'));
		if($this->query("UPDATE axis_news_content SET n_status={$status} WHERE parentid={$parentid};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function change_online(){
		$parentid = intval($this->Request->getParam('parentid'));
		$online = intval($this->Request->getParam('online'));
		if($this->query("UPDATE axis_news_content SET online={$online} WHERE parentid={$parentid};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function change_prize(){
		$parentid = intval($this->Request->getParam('parentid'));
		$prize = intval($this->Request->getParam('prize'));
		if($this->query("UPDATE axis_news_content SET prize={$prize} WHERE parentid={$parentid};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function change_status_comment(){
		$id = intval($this->Request->getParam('id'));
		$status = intval($this->Request->getParam('status'));
		if($this->query("UPDATE axis_news_content_comment SET n_status={$status} WHERE id={$id};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function downloadreport(){
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
	
	function excel_comment(){
		$contentid = $this->Request->getParam('contentid');
		$sql = "
			SELECT '' as no,com.id,sm.name,com.comment,com.date,com.n_status 
			FROM axis_news_content_comment com
			LEFT JOIN social_member sm ON com.userid = sm.id
			WHERE contentid={$contentid}
			ORDER BY com.date DESC;
		";
		$r = $this->fetch($sql,1);
		$status = array(0=>"Pending",1=>"Approve",2=>"Deleted");
		
		$no=1;
		foreach($r as $key => $val){
			$val['no'] = $no++;
			$val['n_status'] = $status[$val['n_status']];
			$data[] = $val;
		}
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Utility/PHPExcelWrapper.php";
		$excel = new PHPExcelWrapper();
		$excel->setGlobalBorder(true, 'allborders', '00000000');
		$excel->setHeader(array('No','ID','User Name','Comment','Date','Status'));
		$excel->getExcel($data,'list_comment_Article');
		exit;
	}	
	
	function inputparent($id){
		$sql = "SELECT * FROM axis_news_content ORDER BY id DESC";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$Key_id = $id==0 ? $list['id'] : $id;
		$this->query("UPDATE axis_news_content SET parentid={$Key_id} WHERE id={$Key_id};");
	}
	
	function inputImage($id,$id_lang,$img){
		$this->query("UPDATE axis_news_content SET image='{$img}' WHERE parentid={$id} AND lid={$id_lang};");
	}
	
	function inputImageThumb($id,$id_lang,$img){
		$this->query("UPDATE axis_news_content SET thumbnail_image='{$img}' WHERE parentid={$id} AND lid={$id_lang};");
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
		if($this->category) {
		 $qCat = " id IN ({$this->category}) AND used = 0 ";
		}else $qCat = " used = 0  ";
		$type = $this->fetch("SELECT * FROM axis_news_content_category WHERE {$qCat} ",1);
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
		$content = str_replace("../index.php", "index.php", $content);

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
	
	function save_crop(){
		global $CONFIG;
		$files['source_file'] = $this->_p('imageFilename');
		$files['url'] = $CONFIG['LOCAL_PUBLIC_ASSET'].'article/';
		$files['real_url'] = $CONFIG['LOCAL_PUBLIC_ASSET']."article/";
		$arrFilename = explode('.',$files['source_file']);
		if($files==null) return false;
		$targ_w = $this->_p('w');
		$targ_h = $this->_p('h');
		$targ_scale = floatval($this->_p('scale'));
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
		if($file_ext=='jpg' || $file_ext=='jpeg' ) imagejpeg($dst_r,$files['url'].'thumb_'.$files['source_file'],$jpeg_quality);
		if($file_ext=='png')imagepng($dst_r,$files['url'].'thumb_'.$files['source_file']);
		if($file_ext=='gif') imagegif($dst_r,$files['url'].'thumb_'.$files['source_file']);
		
		if($targ_scale>0){
			$info = getimagesize($src);
			$this->resize_image($src,$files['url'].'resized_'.$files['source_file'],$files,$file_ext,0,0,($info[0]*($targ_scale/100)),($info[1]*($targ_scale/100)),$info[0],$info[1]);
			$src = $files['url'].'resized_'.$files['source_file'];
		}
		
		$this->resize_image($src,$files['url'].'thumb_'.$files['source_file'],$files,$file_ext,$this->_p('x'),$this->_p('y'),$targ_w,$targ_h,$this->_p('w'),$this->_p('h'));		
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		print json_encode(array('image'=>$CONFIG['BASE_DOMAIN_PATH'].'public_assets/article/thumb_'.$files['source_file']));
		exit;
	}
	
	function resize_image($src,$target,$files,$file_ext,$nx,$ny,$targ_w,$targ_h,$nw,$nh,$jpeg_quality = 90){
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
		
		imagecopyresampled($dst_r,$img_r,0,0,$nx,$ny,$targ_w,$targ_h, $nw,$nh);
		
		//$files['url'].'thumb_'.$files['source_file']
		
		// header('Content-type: image/jpeg');
		if($file_ext=='jpg' || $file_ext=='jpeg' ) imagejpeg($dst_r,$target,$jpeg_quality);
		if($file_ext=='png')imagepng($dst_r,$files['url'].'thumb_'.$files['source_file']);
		if($file_ext=='gif') imagegif($dst_r,$files['url'].'thumb_'.$files['source_file']);
	}
}