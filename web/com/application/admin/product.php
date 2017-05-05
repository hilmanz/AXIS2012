<?php
error_reporting(0);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";

class product extends Admin{
	function __construct(){
		parent::__construct();
	}
	
	function admin(){
	
			global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		if($this->Request->getParam('act') == 'add' ){
			return $this->product_add();
		}elseif($this->Request->getParam('act') == 'edit' ){
			return $this->product_edit();
		}elseif($this->Request->getParam('act') == 'hapus' ){
			return $this->product_delete();
		}elseif($this->Request->getParam('act') == 'add_language' ){
			return $this->product_add_language();
		}elseif($this->Request->getParam('act') == 'excelreport' ){
			return $this->downloadreport();
		}elseif($this->Request->getParam('act') == 'excel_comment' ){
			return $this->excel_comment();
		}elseif($this->Request->getParam('act') == 'comment' ){
			return $this->comment_product();
		}elseif($this->Request->getParam('act') == 'change_status' ){
			return $this->change_status();
		}elseif($this->Request->getParam('act') == 'change_online' ){
			return $this->change_online();
		}elseif($this->Request->getParam('act') == 'change_prize' ){
			return $this->change_prize();
		}elseif($this->Request->getParam('act') == 'change_status_comment' ){
			return $this->change_status_comment();
		}elseif($this->Request->getParam('act') == 'change_status_product' ){
			return $this->change_status_product();
		}elseif($this->Request->getParam('act') == 'product_list' ){
			return $this->product_list_tab();
		}elseif($this->Request->getParam('act') == 'product_add' ){
			return $this->product_add_tab();
		}elseif($this->Request->getParam('act') == 'product_edit' ){
			return $this->product_edit_tab();
		}elseif($this->Request->getParam('act') == 'product_hapus' ){
			return $this->product_delete_tab();
		} else {
			return $this->product_list();
		}
	}

	function product_list(){
		$device = $this->getDeviceList();
		$search = $this->Request->getParam("search") == NULL ? '' : $this->Request->getParam("search");
		$lid = $this->Request->getParam("lid") == NULL ? '' : $this->Request->getParam("lid");
		$id_type = $this->Request->getParam("id_type") == NULL ? '' : $this->Request->getParam("id_type");
		$startdate = $this->Request->getParam("startdate") == NULL ? '' : $this->Request->getParam("startdate");
		$enddate = $this->Request->getParam("expired_date") == NULL ? '' : $this->Request->getParam("enddate");
		
		$filter  = $search=='' ? "" : "AND (con.title LIKE '%{$search}%' OR con.brief LIKE '%{$search}%' OR con.content LIKE '%{$search}%') ";
		$filter .= $lid=='' ? "" : "AND con.lid='{$lid}' ";
		$filter .= $id_type=='' ? "" : "AND con.articleType='{$id_type}'";
		$filter .= $startdate=='' ? "" : "AND con.posted_date>='{$startdate}'";
		$filter .= $enddate=='' ? "" : "AND con.posted_date<'{$enddate}'";
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;
		
		$this->open(0);
		$sql = "
			SELECT con.id,con.parentid,typ.content
			FROM axis_news_content con
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
			WHERE n_status<>3
			AND typ.content IN ('5')
			{$filter}
			GROUP BY con.parentid
			ORDER BY con.posted_date ASC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content con 
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id 
			WHERE n_status<>3 AND typ.content IN ('5') {$filter} GROUP BY con.parentid",1);
		
		$list_totalComment = $this->fetch("SELECT contentid,count(contentid) as total_comment FROM axis_news_content_comment GROUP BY contentid",1);		
		
		$this->close();
		$total = count($list_totalall);
		
		/* list product */
		$list_product = $this->fetch("SELECT con.*,lang.language,cat.category,typ.type as type_name,typ.content,dev.deviceid
									FROM  axis_news_content con
									LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
									LEFT JOIN axis_language_category lang ON con.lid = lang.id 
									LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
									LEFT JOIN axis_news_content_device_group dev ON con.parentid = dev.parentid
									WHERE con.n_status<>3 AND typ.content IN ('5') ",1);
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$num[$v['parentid']] = $v['no'];
		}
		
		foreach ($list_totalComment as $k => $v) {
			$arrTotalcomment[$v['contentid']] = $v['total_comment'];
		}
		
		foreach($list_product as $key => $val){
			$val['no'] = $num[$val['parentid']];
			$val['total_comment'] = $arrTotalcomment[$val['id']];
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
		$this->View->assign('language',$language);
		$this->View->assign('search',$search);
		$this->View->assign('lid',$lid);
		$this->View->assign('id_type',$id_type);
		$this->View->assign('posted_date',$posted_date);
		$this->View->assign('expired_date',$expired_date);
		$this->View->assign('type',$type);
		$this->View->assign('cat',$category);
		$this->View->assign('device',$device);
		$this->View->assign('list',$arrNewsOut);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=product&lid={$lid}&id_cat={$id_cat}&id_type={$id_type}"));	
		return $this->View->toString("application/admin/Product/product_list.html");
	}
	
	function product_add(){
		global $CONFIG;
		$parentid 		= $this->Request->getPost('parentid');
		$lid 			= $this->Request->getPost('lid');
		$title 			= $this->Request->getPost('title');
		$brief 			= $this->Request->getPost('brief');
		$content 		= $this->Request->getPost('content');
		$content 		= $this->fixTinyEditor( $content );
		$articleType 	= $this->Request->getPost('articleType');
		$status 		= $this->Request->getPost('n_status');
		$posted_date 	= $this->Request->getPost('posted_date');
		$expired_date 	= $this->Request->getPost('expired_date');
		$myUrl			= $this->Request->getPost('myUrl');
		$id_device 		= implode(',',$_POST['device']);
		
		$language   	= $this->getLanguageList();
		$type 			= $this->getTypeList();
		$category 		= $this->getCategoryList();
		$device 		= $this->getDeviceList();
		$this->View->assign('language',$language);
		$this->View->assign('type',$type);
		$this->View->assign('cat',$category);
		$this->View->assign('device',$device);

		if( $lid==''  ){
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/Product/product_new.html");
		}
		
		if( !$this->query("INSERT INTO axis_news_content (lid,title,brief,content,articleType,n_status,created_date,posted_date,expired_date,url)
			VALUES ('{$lid}','{$title}',\"{$brief}\",\"{$content}\",'{$articleType}','{$status}',NOW(),'{$posted_date}','{$expired_date}','{$myUrl}')")){
			$this->View->assign("msg","Add process failure");
			return $this->View->toString("application/admin/Product/product_new.html");
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
				
				//if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img)){
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img)){
					//list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product/{$img}");
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product/{$img}");
					// cek size image 
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
					//$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img);
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					//$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/small_".$img );
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					//$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/tiny_".$img );
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/tiny_".$img );
				}
				if ($parentid==NULL) {
					$this->inputparent($last_id);
				}
				$this->inputImage($last_id,$lid,$img);
			}
			if ($parentid==NULL) {
				$this->inputparent($last_id);
			}
			if($last_id){
				$sql = "
					INSERT INTO axis_news_content_device_group (parentid ,deviceid,n_status ) 
					VALUES ({$last_id},'{$id_device}',1)
				";
				$this->query($sql);
				if(!$this->getLastInsertId()){
					return $this->View->showMessage('Article Berhasil diupload, Product gagal di upload', "index.php?s=product");
				}
			}
			return $this->View->showMessage('Berhasil', "index.php?s=product");
		}
		return $this->View->toString("application/admin/Product/product_new.html");
	}
	
	function product_add_language(){
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
		$categoryid = $list['categoryid'];
		$articleType = $list['articleType'];
		$prize = $list['prize'];
		$online = $list['online'];
		$status = $list['n_status'];
		$posted_date = $list['posted_date'];
		$expired_date = $list['expired_date'];
		$url = $list['url'];
		
		if( !$this->query("INSERT INTO axis_news_content (parentid,lid,title,brief,content,image,prize,categoryid,articleType,online,n_status,created_date,posted_date,expired_date,url) 
			VALUES ('{$parent_id}','{$id_lang}','{$title}','{$brief}',\"{$content}\",'{$image}','{$prize}','{$categoryid}','{$articleType}','{$online}','{$status}',NOW(),'{$posted_date}','{$expired_date}','{$url}')")){
			return $this->View->showMessage('Gagal', "index.php?s=product");
		}else{
			// di insert product description
			$lastid = $this->getLastInsertId();
			$sql ="INSERT INTO axis_news_content_product (contentid,title,description,date,n_status)
					SELECT {$lastid},cp.title,cp.description,NOW(),cp.n_status FROM axis_news_content_product cp WHERE contentid={$id}
			";
			if($this->query($sql))
			return $this->View->showMessage('Berhasil', "index.php?s=product");
			else return $this->View->showMessage('Gagal', "index.php?s=product");
		}
	}
	
	function product_edit(){
		global $CONFIG;
		$id 			= intval($this->Request->getParam('id'));
		$id_lang 		= intval($this->Request->getParam('id_lang'));
		$lid	 		= $this->Request->getParam('lang_id');
		
		$parentid 		= $this->Request->getPost('parentid');
		$lid 			= $this->Request->getPost('lid');
		$title 			= $this->Request->getPost('title');
		$brief 			= $this->Request->getPost('brief');
		$content 		= $this->Request->getPost('content');
		$content 		= $this->fixTinyEditor( $content );
		$articleType 	= $this->Request->getPost('articleType');
		$status 		= $this->Request->getPost('n_status');
		$posted_date 	= $this->Request->getPost('posted_date');
		$expired_date 	= $this->Request->getPost('expired_date');
		$myUrl			= $this->Request->getPost('myUrl');
		$id_device 		= implode(',',$_POST['device']);
		
		$device 		= $this->getDeviceList();
		$this->View->assign('device',$device);

		if( empty($lid) ){
			$this->View->assign('msg',"Please complete the form!");
			$product = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
			$productData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($product) ){
				$language = $this->getLanguageList();
				$type = $this->getTypeList();
				$category = $this->getCategoryList();
				if($productData){
					$pagesArr = explode(',',$productData['deviceid']);
					foreach($pagesArr as $val){
						$arrPages[$val] = $val;
					}
					$productData['deviceid'] = $arrPages;
					$this->View->assign('productData',$productData);
				}
				$this->View->assign('language',$language);
				$this->View->assign('type',$type);
				$this->View->assign('cat',$category);
				$this->View->assign("lid",$product['lid']);
				$this->View->assign("title",$product['title']);
				$this->View->assign("brief",$product['brief']);
				$this->View->assign("content",$product['content']);
				$this->View->assign("image",$product['image']);
				$this->View->assign("articleType",$product['articleType']);
				$this->View->assign("status",$product['n_status']);
				$this->View->assign("posted_date",$product['posted_date']);
				$this->View->assign("expired_date",$product['expired_date']);
				$this->View->assign("url",$product['url']);
				return $this->View->toString("application/admin/Product/product_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=product&act=edit");
			}
		}
		
		if(!$this->query("UPDATE axis_news_content SET title='{$title}',brief='{$brief}',
														content=\"{$content}\",
														articleType='{$articleType}',
														posted_date='{$posted_date}',
														expired_date='{$expired_date}',
														n_status='{$status}',
														url='{$myUrl}'
														WHERE parentid={$id} AND lid={$id_lang};")){
			$this->View->assign("msg","Edit process failure");
			$product = $this->fetch("SELECT * FROM axis_news_content WHERE id={$id}");
			$productData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($product) ){
				$language = $this->getLanguageList();
				$type = $this->getTypeList();
				$category = $this->getCategoryList();
				if($productData){
					$pagesArr = explode(',',$productData['deviceid']);
					foreach($pagesArr as $val){
						$arrPages[$val] = $val;
					}
					$productData['deviceid'] = $arrPages;
					$this->View->assign('productData',$productData);
				}
				
				$this->View->assign('device',$device);
				$this->View->assign('language',$language);
				$this->View->assign('type',$type);
				$this->View->assign('cat',$category);
				$this->View->assign("lid",$product['lid']);
				$this->View->assign("title",$product['title']);
				$this->View->assign("brief",$product['brief']);
				$this->View->assign("content",$product['content']);
				$this->View->assign("image",$product['image']);
				$this->View->assign("categoryid",$product['categoryid']);
				$this->View->assign("articleType",$product['articleType']);
				$this->View->assign("online",$product['online']);
				$this->View->assign("url",$product['url']);
				$this->View->assign("status",$product['n_status']);
				return $this->View->toString("application/admin/Product/product_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=product&act=edit");
			}
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
				
				//if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img)){
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img)){
					//list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product/{$img}");
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}product/{$img}");
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
					//$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img);
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					//$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/small_".$img );
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					//$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/tiny_".$img );					
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}product/tiny_".$img );
				}
				$this->inputImage($id,$id_lang,$img);
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
							return $this->View->showMessage('Article Berhasil diupload, Product gagal di upload', "index.php?s=product");
						}
					}
				}
			}
			return $this->View->showMessage('Berhasil', "index.php?s=product");
		}
		
		$product = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
		$productData = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
		if( is_array($product) ){
			$language = $this->getLanguageList();
			$type = $this->getTypeList();
			$category = $this->getCategoryList();
			if($productData){
				$pagesArr = explode(',',$productData['deviceid']);
				foreach($pagesArr as $val){
					$arrPages[$val] = $val;
				}
				$productData['deviceid'] = $arrPages;
				$this->View->assign('productData',$productData);
			}
			
			$this->View->assign('device',$device);
			$this->View->assign('language',$language);
			$this->View->assign('type',$type);
			$this->View->assign('cat',$category);
			$this->View->assign("lid",$product['lid']);
			$this->View->assign("title",$product['title']);
			$this->View->assign("brief",$product['brief']);
			$this->View->assign("content",$product['content']);
			$this->View->assign("image",$product['image']);
			$this->View->assign("categoryid",$product['categoryid']);
			$this->View->assign("articleType",$product['articleType']);
			$this->View->assign("online",$product['online']);
			$this->View->assign("url",$product['url']);
			$this->View->assign("status",$product['n_status']);
			return $this->View->toString("application/admin/product/product_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=product&act=edit");
		}
		return $this->View->toString("application/admin/Product/product_edit.html");
	}
	
	function product_delete(){
		$parentid = $this->Request->getParam('parentid');
		if( !$this->query("UPDATE axis_news_content SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=product");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product");
		}
	}
	
	function change_status_product(){
		$id = intval($this->Request->getParam('id'));
		$status = intval($this->Request->getParam('status'));
		if($this->query("UPDATE axis_news_content_product SET n_status={$status} , date=NOW() WHERE id={$id};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function comment_product(){
		$id = $this->Request->getParam("id") == NULL ? '' : $this->Request->getParam("id");
		$id_lang = $this->Request->getParam("id_lang") == NULL ? '' : $this->Request->getParam("id_lang");		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;
		
		$id_article = $this->fetch("SELECT * FROM axis_news_content WHERE n_status<>3 AND parentid={$id} AND lid={$id_lang}");
		$id_content = $id_article['id'];
		$this->open(0);
		$sql = "
			SELECT com.*,sm.name
			FROM axis_news_content_comment com
			LEFT JOIN social_member sm ON com.userid = sm.id
			WHERE com.contentid = {$id_content} AND com.n_status<>2
			ORDER BY com.date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content_comment WHERE contentid = {$id_content}",1);
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
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=product&act=comment&id={$id}&id_lang={$id_lang}"));
		return $this->View->toString("application/admin/Product/product_comment.html");
	}
	
	function product_list_tab(){
		$id = $this->Request->getParam("id");
		$st = $this->Request->getParam("start");
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;
		
		$this->open(0);
		$sql = "SELECT * FROM axis_news_content_product WHERE contentid={$id} ORDER BY date DESC LIMIT {$start},{$total_per_page}";		
		$list = $this->fetch($sql,1);
		$article = $this->fetch("SELECT id,title FROM axis_news_content WHERE id={$id}");
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content_product WHERE contentid={$id}",1);
		$this->close();
		$total = count($list_totalall);
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
		}
		
		$this->View->assign('list',$data);
		$this->View->assign('title_article',$article['title']);
		$this->View->assign('id_content',$article['id']);
		$this->View->assign('start',$st);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=article&act=product_list&id={$id}"));
		return $this->View->toString("application/admin/Product/product_list_tab.html");
	}
	
	function product_add_tab(){
		$id_content 	= $this->Request->getParam('id_content');
		$start 			= $this->Request->getParam('start');
		$title 			= $this->Request->getPost('title');
		$description 	= $this->Request->getPost('description');
		$description 		  = $this->fixTinyEditor( $description );
		$status 		= $this->Request->getPost('n_status');
		
		$this->View->assign('id_content',$id_content);
		$this->View->assign('start',$start);

		if($title=='' || $description==''){
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/Product/product_new_tab.html");
		}
		
		if( !$this->query("INSERT INTO axis_news_content_product (contentid,title,description,date,n_status) 
			VALUES ('{$id_content}','{$title}',\"{$description}\",NOW(),1)")){
			$this->View->assign("msg","Add process failure");
			return $this->View->toString("application/admin/Product/product_new_tab");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product&act=product_list&id={$id_content}");
		}
		return $this->View->toString("application/admin/Product/product_new_tab.html");
	}
	
	function product_edit_tab(){
		$id 			= intval($this->Request->getParam('id'));
		$id_content 	= intval($this->Request->getParam('id_content'));
		$start 			= $this->Request->getParam('start');
		$title 			= $this->Request->getPost('title');
		$description 	= $this->Request->getPost('description');
		$description 		  = $this->fixTinyEditor( $description );
		$status 		= $this->Request->getPost('n_status');
		
		$this->View->assign('id',$id);
		$this->View->assign('id_content',$id_content);
		$this->View->assign('start',$start);

		if( empty($title) && empty($description)){
			$this->View->assign('msg',"Please complete the form!");
			$product = $this->fetch("SELECT * FROM axis_news_content_product WHERE id={$id}");
			
			if( is_array($product)){
				$this->View->assign("title",$product['title']);
				$this->View->assign("description",$product['description']);
				$this->View->assign("status",$product['n_status']);
				return $this->View->toString("application/admin/Product/product_edit_tab.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=product&act=product_edit");
			}
		}
		$sql = "UPDATE axis_news_content_product SET title='{$title}',description=\"{$description}\",date=NOW() WHERE id={$id};";
		// pr($sql);
		if(!$this->query($sql)){
			$this->View->assign("msg","Edit process failure");
			$product = $this->fetch("SELECT * FROM axis_news_content_product WHERE id={$id}");

			if( is_array($product) ){
				$this->View->assign("title",$product['title']);
				$this->View->assign("description",$product['description']);
				$this->View->assign("status",$product['n_status']);
				return $this->View->toString("application/admin/Product/product_edit_tab.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=product&act=product_edit");
			}
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product&act=product_list&id={$id_content}");
		}
		
		$product = $this->fetch("SELECT * FROM axis_news_content_product WHERE id={$id}");
		if( is_array($product) ){
			$this->View->assign("title",$product['title']);
			$this->View->assign("description",$product['description']);
			$this->View->assign("status",$product['n_status']);
			return $this->View->toString("application/admin/Product/product_edit_tab.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=product&act=product_edit");
		}
		return $this->View->toString("application/admin/Product/product_edit_tab.html");
	}
	
	function product_delete_tab(){
		$id = $this->Request->getParam('id');
		$id_content = $this->Request->getParam('id_content');
		$start 		= $this->Request->getParam('start');
		if(!$this->query("DELETE FROM axis_news_content_product WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=product&act=product_list&id={$id_content}&start={$start}");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=product&act=product_list&id={$id_content}&start={$start}");
		}
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
		//sendRedirect('index.php?s=article&act=comment');
	}
	
	function downloadreport(){
		$lid = $this->Request->getParam('lid');
		$id_cat = $this->Request->getParam('id_cat');
		$id_type = $this->Request->getParam('id_type');
		$filter = $lid=='' ? "" : " AND con.lid = {$lid} ";
		$filter .= $id_cat=='' ? "" : " AND con.categoryid = {$id_cat} ";
		$filter .= $id_type=='' ? "" : " AND con.articleType = {$id_type} ";
		$sql = "
		SELECT '' as no,con.lid,con.title,con.brief,con.content,con.prize,con.categoryid,con.articleType,con.created_date,con.posted_date,con.online,con.n_status 
		FROM axis_news_content con 
		LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
		WHERE n_status<>3 AND typ.content=1 {$filter} 
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
		$excel->setHeader(array('No','Language','Title','Brief','Content','Prize','Category','Type Article','Created Date','Posted Date','Online','Status'));
		$excel->getExcel($data,'list_product');
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
		$excel->getExcel($data,'list_comment_product');
		exit;
	}
	
	function inputparent($id){
		$sql = "SELECT * FROM axis_news_content ORDER BY id DESC";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$Key_id = $id==0 ? $list['id'] : $id;
		$this->query("UPDATE axis_news_content SET parentid='{$Key_id}' WHERE id={$Key_id};");
	}
	
	function inputImage($id,$id_lang,$img){
		$sql = "SELECT * FROM axis_news_content ORDER BY id DESC";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$Key_id = $id==0 ? $list['id'] : $id;
		$this->query("UPDATE axis_news_content SET image='{$img}' WHERE parentid={$Key_id} AND lid={$id_lang};");
	}

	function getLanguageList(){
		$language = $this->fetch("SELECT * FROM axis_language_category",1);
		return $language;
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_type WHERE content=5",1);
		return $type;
	}
	
	function getCategoryList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_category",1);
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
}