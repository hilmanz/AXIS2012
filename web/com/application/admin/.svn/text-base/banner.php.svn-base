<?php
error_reporting(0);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";

class banner extends Admin{
	function __construct(){	
		parent::__construct();
	}
	
	function admin(){
		if($this->_g("lid")) $this->lid = $this->_g("lid");
		else  $this->lid = 1;		
		
		//helper
		$this->language = $this->getLanguageList();
		$this->type = $this->getTypeList();
		$this->category = $this->getCategoryList();
		$this->device = $this->getDeviceList();
		$this->page = $this->getPageList();
		$this->View->assign('type',$this->type);
		$this->View->assign('cat',$this->category);
		$this->View->assign('device',$this->device);
		$this->View->assign('language',$this->language);
		$this->View->assign('page',$this->page);
		
		global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
			
			
		if($this->Request->getParam('act') == 'add' ){
			return $this->banner_add();
		}elseif($this->Request->getParam('act') == 'edit' ){
			return $this->banner_edit();
		}elseif($this->Request->getParam('act') == 'hapus' ){
			return $this->banner_delete();
		}elseif($this->Request->getParam('act') == 'add_language' ){
			return $this->banner_add_language();
		}elseif($this->Request->getParam('act') == 'excelreport' ){
			return $this->downloadreport();
		}elseif($this->Request->getParam('act') == 'excel_comment' ){
			return $this->excel_comment();
		}elseif($this->Request->getParam('act') == 'comment' ){
			return $this->comment_banner();
		}elseif($this->Request->getParam('act') == 'change_status' ){
			return $this->change_status();
		}elseif($this->Request->getParam('act') == 'change_online' ){
			return $this->change_online();
		}elseif($this->Request->getParam('act') == 'change_prize' ){
			return $this->change_prize();
		}elseif($this->Request->getParam('act') == 'change_status_comment' ){
			return $this->change_status_comment();
		}elseif($this->Request->getParam('act') == 'save_crop' ){
			return $this->save_crop();
		} else {
			return $this->banner_list();
		}
	}

	function banner_list(){
		$search = $this->_g("search") == NULL ? '' : $this->_g("search");
		$id_type = $this->_g("id_type") == NULL ? '' : $this->_g("id_type");
		$id_page = $this->_g("id_page") == NULL ? '' : $this->_g("id_page");
		$startdate = $this->_g("startdate") == NULL ? '' : $this->_g("startdate");
		$enddate = $this->_g("enddate") == NULL ? '' : $this->_g("enddate");
		
		$filter  = $search=='' ? "" : "AND (con.title LIKE '%{$search}%' OR con.brief LIKE '%{$search}%' OR con.content LIKE '%{$search}%') ";
		$filter .= $startdate=='' ? "" : "AND con.created_date>='{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND con.created_date<'{$enddate}' ";
		$filter_banner = $id_type=='' ? "" : "AND type = '{$id_type}' ";
		$filter_banner .= $id_page=='' ? "" : "AND page LIKE '%{$id_page}%' ";
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 20;
		
		$this->open(0);
		$sql = "SELECT * FROM axis_news_content_banner WHERE n_status=1 {$filter_banner}";		
		$qData = $this->fetch($sql,1);
		foreach($qData as $val){
			$arrContentID[] = $val['parentid'];
		}		
		$strCid = implode(',',$arrContentID);
		
		$sql = "
			SELECT con.*
			FROM axis_news_content con
			WHERE n_status<>3
			AND (con.parentid IN ({$strCid}) OR con.articleType = 5)
			AND con.lid={$this->lid}
			{$filter}
			GROUP BY con.parentid
			ORDER BY con.created_date DESC
			LIMIT {$start},{$total_per_page}
		";
		$list = $this->fetch($sql,1);
		
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_news_content con 
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id 
			WHERE n_status<>3 AND ( con.parentid IN ({$strCid}) OR con.articleType = 5 ) AND con.lid={$this->lid} {$filter} GROUP BY con.parentid",1);
		$this->close();
		$total = count($list_totalall);
		
		/* list article */
		$sql = "
			SELECT con.*,lang.language,cat.category,typ.type as type_name,typ.content,bt.type,cb.page,dg.deviceid
			FROM  axis_news_content con
			LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
			LEFT JOIN axis_language_category lang ON con.lid = lang.id 
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
			LEFT JOIN axis_news_content_device_group dg ON con.parentid = dg.parentid
			LEFT JOIN axis_news_content_banner cb ON con.parentid = cb.parentid
			LEFT JOIN axis_news_content_banner_type bt ON cb.type = bt.id
			WHERE con.n_status<>3 AND (con.parentid IN ({$strCid}) OR con.articleType = 5)
		";
		$list_banner = $this->fetch($sql,1);
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$num[$v['parentid']] = $v['no'];
		}
		
		foreach($list_banner as $key => $val){
			$val['no'] = $num[$val['parentid']];			
			$deviceArr = explode(',',$val['deviceid']);
			$pageArr = explode(',',$val['page']);
			foreach($this->device as $vals){
				$arrDeviceCat[$vals['id']] = $vals['type'];
			}
			foreach($this->page as $vals){
				$arrPageCat[$vals['id']] = $vals['pagename'];
			}
			
			$arrDevice = null;
			foreach ($deviceArr as $v) {
				$arrDevice[] = $arrDeviceCat[$v];
			}
			
			$arrPage = null;
			foreach ($pageArr as $v) {
				$arrPage[] = $arrPageCat[$v];
			}
			
			$val['deviceid'] = implode(',',$arrDevice);
			$val['page'] = implode(',&nbsp;',$arrPage);
			$arrListnews[$val['parentid']][$val['id']] = $val;
			$arrTempnews[$val['parentid']][$val['lid']] = $val['lid'];
		}
	
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
		
		$param_search = $lid=='' ? "" : "&search_lid={$lid}";
		$param_search .= $id_type=='' ? "" : "&search_id_type={$id_type}";
		$param_search .= $id_page=='' ? "" : "&search_id_page={$id_page}";
		
		$this->View->assign('search',$search);
		$this->View->assign('lid',$this->lid);
		$this->View->assign('id_type',$id_type);
		$this->View->assign('id_page',$id_page);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('param_search',$param_search);
		$this->View->assign('list',$arrNewsOut);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=banner&lid={$this->lid}&id_cat={$id_cat}&id_type={$id_type}&search={$search}"));	
		return $this->View->toString("application/admin/Banner/banner_list.html");
	}
	
	function banner_add(){
		global $CONFIG;
		$parentid 		= $this->Request->getPost('parentid');
		$lid 			= $this->Request->getPost('lid');
		$title 			= $this->Request->getPost('title');
		$brief 			= $this->Request->getPost('brief');
		$content 		= $this->Request->getPost('content');
		$content 	  = $this->fixTinyEditor( $content );
		$categoryid 	= $this->Request->getPost('categoryid');
		$articleType 	= $this->Request->getPost('articleType');
		$pages 			= implode(',',$_POST['pages']);
		$id_device 		= implode(',',$_POST['device']);
		$status 		= $this->Request->getPost('n_status');
		$url 			= $this->Request->getPost('url');
		$posted_date 	= $this->Request->getPost('posted_date');
		$expired_date 	= $this->Request->getPost('expired_date');
			$textalignment 	= $this->Request->getPost('textalignment');
			
		if( $lid=='' || $title=='' || $brief=='' || $content==''){
				$this->log->sendActivity('add banner','enter');
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/Banner/banner_new.html");
		}
		
		if ($this->Request->getPost('save')) {
			$sql = "INSERT INTO axis_news_content (lid,title,brief,content,categoryid,articleType,n_status,created_date,posted_date,expired_date,url) 
				VALUES ('{$lid}','{$title}','{$brief}',\"{$content}\",'{$categoryid}',5,'{$status}',NOW(),'{$posted_date}','{$expired_date}','{$url}')";
			if( !$this->query($sql)){
					$this->log->sendActivity('add banner','failed');
				$this->View->assign("msg","Add process failure");
				return $this->View->toString("application/admin/Banner/banner_new.html");
			}else{
				$last_id = $this->getLastInsertId();
					$this->log->sendActivity('add banner',$last_id);
				if ($_FILES['image']['name']!=NULL) {
					include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					list($file_name,$ext) = explode('.',$_FILES['image']['name']);
					$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
					try{
						$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
					}catch (Exception $e){
						// handle error here however you'd like
					}
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/".$img)){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/{$img}");
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
						$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/big_".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/tiny_".$img );
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
						INSERT INTO axis_news_content_banner (parentid ,page,type,n_status,textalign )
						VALUES ({$last_id},'{$pages}',{$articleType},1,'{$textalignment}')
					";
					
					$sql_device = "
						INSERT INTO axis_news_content_device_group (parentid,deviceid,n_status)
						VALUES ({$last_id},'{$id_device}',1)
					";
					
					$this->query($sql);
						if(!$this->getLastInsertId()){
							return $this->View->showMessage('Article Berhasil diupload,Banner gagal di upload', "index.php?s=banner");
					}
					
					$this->query($sql_device);
						if(!$this->getLastInsertId()){
							return $this->View->showMessage('Article Berhasil diupload,Banner gagal di upload', "index.php?s=banner");
					}
				}
					return $this->View->showMessage('Berhasil', "index.php?s=banner");
			}
		}

		return $this->View->toString("application/admin/Banner/banner_new.html");
	}
	
	function banner_add_language(){
		$id = $this->Request->getParam('id');
		$id_lang = $this->Request->getParam('id_lang');
		$sql = "SELECT * FROM axis_news_content WHERE id={$id}";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$parent_id = $list['parentid'];
		$title = $list['title'];
		$url = $list['url'];
		$brief = $list['brief'];
		$content = $list['content'];
		$content 	  = $this->fixTinyEditor( $content );
		$slider_image = $list['slider_image']; // tambah field slider_image khusus image slider
		$categoryid = $list['categoryid'];
		$articleType = $list['articleType'];
		$prize = $list['prize'];
		$online = $list['online'];
		$status = $list['n_status'];
		$textalign =  $list['textalign'];
		$this->log->sendActivity('add banner other language',$id);
		
		if( !$this->query("INSERT INTO axis_news_content (parentid,lid,title,brief,content,slider_image,prize,categoryid,articleType,online,n_status,created_date,url) 
			VALUES ('{$parent_id}','{$id_lang}','{$title}','{$brief}',\"{$content}\",'{$slider_image}','{$prize}','{$categoryid}',5,'{$online}','{$status}',NOW(),'{$url}')")){
			return $this->View->showMessage('Gagal', "index.php?s=banner");
		}else{
			$this->log->sendActivity('add banner',$this->getLastInsertId());
			return $this->View->showMessage('Berhasil', "index.php?s=banner");
		}
	}
	
	function banner_edit(){
		global $CONFIG;
		
		$id 			= intval($this->_g('id'));
		$id_lang 		= intval($this->_g('id_lang'));
		$search	 		= $this->_g('search_lid') == NULL ? "" : "&lid={$this->_g(search_lid)}";
		$search	 		.= $this->_g('search_id_type') == NULL ? "" : "&id_type={$this->_g(search_id_type)}";
		$search		 	.= $this->_g('search_id_page') == NULL ? "" : "&id_page={$this->_g(search_id_page)}";		
		$this->View->assign('search',$search);
		
		$lid 			= $this->_p('lid');
		$title 			= $this->_p('title');
		$brief 			= $this->_p('brief');
		$content 		= $this->_p('content');
		$content 	  	= $this->fixTinyEditor( $content );
		//$categoryid 	= $this->_p('categoryid');
		$articleType 	= $this->_p('articleType');
		$pages 			= implode(',',$_POST['pages']);
		$id_device 		= implode(',',$_POST['device']);
		$status 		= $this->_p('n_status');
		$url 			= $this->_p('url');
		$posted_date 	= $this->_p('posted_date');
		$expired_date 	= $this->_p('expired_date');
		$textalignment 	= $this->_p('textalignment');		
		$this->log->sendActivity('edit banner',$id);
		if( empty($lid) && empty($title) && empty($brief)){
			$this->View->assign('msg',"Please complete the form!");
			$banner = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
			$bannerData = $this->fetch("SELECT * FROM axis_news_content_banner WHERE parentid={$id}");
			$bannerDevice = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($banner) ){
				if($bannerData){
					$pagesArr = explode(',',$bannerData['page']);
					foreach($pagesArr as $val){
						$arrPages[$val] = $val;
					}
					$bannerData['page'] = $arrPages;
					$this->View->assign('bannerData',$bannerData);
				}
				if($bannerDevice){
					$deviceArr = explode(',',$bannerDevice['deviceid']);
					foreach($deviceArr as $val){
						$arrDevice[$val] = $val;
					}
					$bannerDevice['deviceid'] = $arrDevice;
					$this->View->assign('bannerDevice',$bannerDevice);
				}
				$this->View->assign("lid",$banner['lid']);
				$this->View->assign("title",$banner['title']);
				$this->View->assign("brief",$banner['brief']);
				$this->View->assign("content",$banner['content']);
				$this->View->assign("slider_image",$banner['slider_image']);
				$this->View->assign("categoryid",$banner['categoryid']);
				$this->View->assign("articleType",$banner['articleType']);
				$this->View->assign("url",$banner['url']);
				$this->View->assign("status",$banner['n_status']);
				$this->View->assign("posted_date",$banner['posted_date']);
				$this->View->assign("expired_date",$banner['expired_date']);
			
				return $this->View->toString("application/admin/Banner/banner_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=banner&act=edit");
			}
		}
		
		$sql = "UPDATE axis_news_content SET title='{$title}',brief='{$brief}',
						content=\"{$content}\",
						posted_date='{$posted_date}',
						expired_date='{$expired_date}',
						url='{$url}',
						n_status='{$status}'
						WHERE parentid='{$id}' AND lid='{$id_lang}';";
		
		
		if(!$this->query($sql)){
		
			$this->View->assign("msg","Add process failure");
			$banner = $this->fetch("SELECT * FROM axis_news_content WHERE id={$id}");
			$bannerData = $this->fetch("SELECT * FROM axis_news_content_banner WHERE parentid={$id}");
			$bannerDevice = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
			if( is_array($banner) ){
				if($bannerData){
					$pagesArr = explode(',',$bannerData['page']);
					foreach($pagesArr as $val){
					$arrPages[$val] = $val;
						}
					$bannerData['page'] = $arrPages;
					$this->View->assign('bannerData',$bannerData);
				}
				if($bannerDevice){
					$deviceArr = explode(',',$bannerDevice['deviceid']);
					foreach($deviceArr as $val){
						$arrDevice[$val] = $val;
					}
					$bannerDevice['deviceid'] = $arrDevice;
					$this->View->assign('bannerDevice',$bannerDevice);
				}
				$this->View->assign("lid",$banner['lid']);
				$this->View->assign("title",$banner['title']);
				$this->View->assign("brief",$banner['brief']);
				$this->View->assign("content",$banner['content']);
				$this->View->assign("slider_image",$banner['slider_image']);
				$this->View->assign("categoryid",$banner['categoryid']);
				$this->View->assign("articleType",$banner['articleType']);
				$this->View->assign("online",$banner['online']);
				$this->View->assign("url",$banner['url']);
				$this->View->assign("status",$banner['n_status']);
				$this->View->assign("posted_date",$banner['posted_date']);
				$this->View->assign("expired_date",$banner['expired_date']);
				return $this->View->toString("application/admin/Banner/banner_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=banner&act=edit");
			}
		}else{
			$banner = $this->fetch("SELECT * FROM axis_news_content WHERE id={$id}");
			if ($_FILES['image']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_name,$ext) = explode('.',$_FILES['image']['name']);
				$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
				try{
					$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/".$img)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/{$img}");
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
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/big_".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/tiny_".$img );
				}
				$this->inputImage($id,$id_lang,$img);
			}
		
			if($pages){
				$sql = "SELECT count(*) total FROM axis_news_content_banner WHERE parentid={$id} LIMIT 1 ";
				$qData = $this->fetch($sql);
				if($qData['total']>0){
					$sql = "UPDATE axis_news_content_banner SET 
					page='{$pages}' , 
					type={$articleType},							
					textalign='{$textalignment}' 
					WHERE parentid={$id} LIMIT 1";
					$this->query($sql);
				
				}else{
					if($id){
						$sql = "
						INSERT INTO axis_news_content_banner (parentid,page,type,n_status,textalign) 
						VALUES ({$id},'{$pages}',{$articleType},1,'{$textalignment}')
						";
					
						$this->query($sql);
						if(!$this->getLastInsertId()){
							return $this->View->showMessage('Article Berhasil diupload, Banner gagal di upload', "index.php?s=banner");
						}
					}
				}
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
							return $this->View->showMessage('Article Berhasil diupload, Banner gagal di upload', "index.php?s=banner");
						}
					}
				}
			}
		
			return $this->View->showMessage('Berhasil', "index.php?s=banner");
		}
			
		$banner = $this->fetch("SELECT * FROM axis_news_content WHERE parentid={$id} AND lid={$id_lang}");
		$bannerData = $this->fetch("SELECT * FROM axis_news_content_banner WHERE contentid={$id}");
		$bannerDevice = $this->fetch("SELECT * FROM axis_news_content_device_group WHERE parentid={$id}");
		if( is_array($banner) ){
			if($bannerData){
				$pagesArr = explode(',',$bannerData['page']);
				foreach($pagesArr as $val){
					$arrPages[$val] = $val;
				}
				$bannerData['page'] = $arrPages;
				$this->View->assign('bannerData',$bannerData);
			}
			if($bannerDevice){
			$deviceArr = explode(',',$bannerDevice['deviceid']);
			foreach($deviceArr as $val){
				$arrDevice[$val] = $val;
			}
			$bannerDevice['deviceid'] = $arrDevice;
			$this->View->assign('bannerDevice',$bannerDevice);
			}
			$this->View->assign("lid",$banner['lid']);
			$this->View->assign("title",$banner['title']);
			$this->View->assign("brief",$banner['brief']);
			$this->View->assign("content",$banner['content']);
			$this->View->assign("slider_image",$banner['slider_image']);
			$this->View->assign("categoryid",$banner['categoryid']);
			$this->View->assign("articleType",$banner['articleType']);
			$this->View->assign("online",$banner['online']);
			$this->View->assign("url",$banner['url']);
			$this->View->assign("status",$banner['n_status']);
			return $this->View->toString("application/admin/Banner/banner_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=banner&act=edit");
		}
	
		return $this->View->toString("application/admin/Banner/banner_edit.html");
	}	
	
	function banner_delete(){
		$parentid 	= $this->Request->getParam('parentid');		
		$search	 	= $this->Request->getParam('search_lid') == NULL ? "" : "&lid={$this->Request->getParam(search_lid)}";
		$search	 	.= $this->Request->getParam('search_id_type') == NULL ? "" : "&id_type={$this->Request->getParam(search_id_type)}";
		$search		.= $this->Request->getParam('search_id_page') == NULL ? "" : "&id_page={$this->Request->getParam(search_id_page)}";
		
		if( !$this->query("UPDATE axis_news_content SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=banner{$search}");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=banner{$search}");
		}
	}
	
	function comment_banner(){
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
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=banner&act=comment&id={$id}&id_lang={$id_lang}"));
		return $this->View->toString("application/admin/Banner/banner_comment.html");
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
		//sendRedirect('index.php?s=article&act=comment');
	}
	
	function save_crop(){
		$files['source_file'] = $this->_p('imageFilename');
		$files['url'] = "{$CONFIG['LOCAL_PUBLIC_ASSET']}banner/";
		$arrFilename = explode('.',$files['source_file']);
		if($files==null) return false;
		$targ_w = $this->_p('w');
		$targ_h = $this->_p('h');
		$jpeg_quality = 90;	
		
		$src = 	$files['url'].$files['source_file'];
		
		if($arrFilename[1]=='jpg' || $arrFilename[1]=='jpeg' ) $img_r = imagecreatefromjpeg($src);
		if($arrFilename[1]=='png' ) $img_r = imagecreatefrompng($src);
		if($arrFilename[1]=='gif' ) $img_r = imagecreatefromgif($src);
		
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
		imagecopyresampled($dst_r,$img_r,0,0,$this->_p('x'),$this->_p('y'),$targ_w,$targ_h, $this->_p('w'),$this->_p('h'));		
		
		// header('Content-type: image/jpeg');
		if($arrFilename[1]=='jpg' || $arrFilename[1]=='jpeg' ) imagejpeg($dst_r,$files['url'].'thumb_'.$files['source_file'],$jpeg_quality);
		if($arrFilename[1]=='png' ) imagepng($dst_r,$files['url'].'thumb_'.$files['source_file']);
		if($arrFilename[1]=='gif' ) imagegif($dst_r,$files['url'].'thumb_'.$files['source_file']);
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		print json_encode(array('image'=>$files['url'].'thumb_'.$files['source_file']));
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
		$excel->getExcel($data,'list_Banner');
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
		$excel->getExcel($data,'list_comment_Banner');
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
		$this->query("UPDATE axis_news_content SET slider_image='{$img}' WHERE parentid={$Key_id} AND lid={$id_lang};");
	}

	function getLanguageList(){
		$language = $this->fetch("SELECT * FROM axis_language_category",1);
		return $language;
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM  axis_news_content_banner_type WHERE n_status=1",1);
		return $type;
	}
	
	function getPageList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_page ",1);
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