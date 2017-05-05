<?php
error_reporting(0);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";

class division extends Admin{
	function __construct(){
		parent::__construct();
	}
	
	function admin(){
		//helper
		$this->language = $this->getLanguageList();
		$this->View->assign('language',$this->language);
			global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		$this->type = 6;
		$act = $this->_g('act');
		
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$lid = $this->_g("lid") == NULL ? '' : $this->_g("lid");
		$startdate = $this->_g("startdate") == NULL ? '' : $this->_g("startdate");
		$enddate = $this->_g("enddate") == NULL ? '' : $this->_g("enddate");
		
		$filter  = $lid=='' ? "" : "AND con.lid='{$lid}' ";
		$filter .= $startdate=='' ? "" : "AND con.posted_date>='{$startdate}'";
		$filter .= $enddate=='' ? "" : "AND con.posted_date<'{$enddate}'";
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 20;
		
		$this->open(0);
		$sql = "
			SELECT con.*
			FROM axis_coorporate_blog con
			WHERE con.n_status<>3
			AND con.type = {$this->type}
			{$filter}
			GROUP BY con.parentid
			ORDER BY con.posted_date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT con.* FROM axis_coorporate_blog con 
			WHERE n_status<>3 AND con.type = {$this->type} {$filter} GROUP BY con.parentid",1);
		
		$list_totalComment = $this->fetch("SELECT contentid,count(contentid) as total_comment FROM axis_news_content_comment GROUP BY contentid",1);		
		
		$this->close();
		$total = count($list_totalall);
		
		/* list product */
		$list_divisi = $this->fetch("SELECT con.*,lang.language
									FROM  axis_coorporate_blog con
									LEFT JOIN axis_language_category lang ON con.lid = lang.id
									WHERE con.n_status<>3 AND con.type = {$this->type} ",1);
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$num[$v['parentid']] = $v['no'];
		}
		
		foreach ($list_totalComment as $k => $v) {
			$arrTotalcomment[$v['contentid']] = $v['total_comment'];
		}
		
		foreach($list_divisi as $key => $val){
			$val['no'] = $num[$val['parentid']];
			$val['total_comment'] = $arrTotalcomment[$val['id']];
			$arrListdivisi[$val['parentid']][$val['id']] = $val;
			$arrTempnews[$val['parentid']][$val['lid']] = $val['lid'];
			$arrTempcomment[$val['parentid']][$val['lid']] = $val['total_comment'];
		}
		$this->View->assign('total_comment',$arrTempcomment);
		
		/* list bahasa */
		$list_lang = $this->fetch("SELECT * FROM  axis_language_category lg",1);
		
		/* list data */
		foreach($list as $key => $val){
			$arrNewsOut[$val['id']]=$arrListdivisi[$val['parentid']];
			foreach($list_lang as $vLang){
				if(@$arrTempnews[$val['parentid']][$vLang['id']]) $arrNewsOut[$val['id']]['hasLang'][$vLang['id']] = true;
				else $arrNewsOut[$val['id']]['hasLang'][$vLang['id']]= false;
			}
		}
		
		$this->View->assign('search',$search);
		$this->View->assign('lid',$lid);
		$this->View->assign('id_type',$id_type);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('list',$arrNewsOut);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=division&lid={$lid}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/division/division_list.html");
	}
	
	function add(){
		global $CONFIG;
		$parentid 		= $this->_p('parentid');
		$lid 			= $this->_p('lid');
		$title 			= $this->_p('title');
		$brief 			= $this->_p('brief');
		$content 		= $this->_p('content');
		$content 		= $this->fixTinyEditor( $content );
		$status 		= $this->_p('n_status');
		$posted_date 	= $this->_p('posted_date');
		$expired_date 	= $this->_p('expired_date');

		if($lid==''){
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/division/division_new.html");
		}
		
		if( !$this->query("INSERT INTO axis_coorporate_blog (lid,title,brief,content,type,n_status,created_date,posted_date,expired_date,authorid)
			VALUES ('{$lid}','{$title}','{$brief}','{$content}','{$this->type}','{$status}',NOW(),'{$posted_date}','{$expired_date}',{$this->Session->getVariable("uid")})")){
			$this->View->assign("msg","Add process failure");
			return $this->View->toString("application/admin/division/division_new.html");
		}else{
			$last_id = $this->getLastInsertId();
			if ($parentid==NULL) {
				$this->inputparent($last_id);
			}
			if ($_FILES['image']['name']!=NULL) {
				include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
				list($file_name,$ext) = explode('.',$_FILES['image']['name']);
				$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
				try{
					$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
				}catch (Exception $e){
					// handle error here however you'd like
				}
				
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}division/".$img)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}division/{$img}");
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
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/tiny_".$img );
				}
				if ($parentid==NULL) {
					$this->inputparent($last_id);
				}
				$this->inputImage($last_id,$lid,$img);
			}
			return $this->View->showMessage('Berhasil', "index.php?s=division");
		}
		return $this->View->toString("application/admin/division/division_new.html");
	}
	
	function add_language(){
		$id = $this->_g('id');
		$id_lang = $this->_g('id_lang');
		$sql = "SELECT * FROM axis_coorporate_blog WHERE id={$id}";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$parent_id = $list['parentid'];
		$title = $list['title'];
		$brief = $list['brief'];
		$content = $list['content'];
		$image = $list['image'];
		$type_id = $list['type'];
		$status = $list['n_status'];
		$posted_date = $list['posted_date'];
		$expired_date = $list['expired_date'];
		$authorid = $list['authorid'];
		if( !$this->query("INSERT INTO axis_coorporate_blog (parentid,lid,title,brief,content,image,type,n_status,created_date,posted_date,expired_date,authorid) 
			VALUES ('{$parent_id}','{$id_lang}','{$title}','{$brief}',\"{$content}\",'{$image}','{$type_id}','{$status}',NOW(),'{$posted_date}','{$expired_date}','{$authorid}')")){
			return $this->View->showMessage('Gagal', "index.php?s=division");
		}else{
			$lastid = $this->getLastInsertId();
			$sql ="INSERT INTO axis_coorporate_division (contentid,title,description,date,n_status)
					SELECT {$lastid},divisi.title,divisi.description,NOW(),divisi.n_status FROM axis_coorporate_division divisi WHERE contentid={$id}
			";
			if($this->query($sql)) 
			return $this->View->showMessage('Berhasil', "index.php?s=division");
			else return $this->View->showMessage('Gagal', "index.php?s=division");
		}
	}
	
	function edit(){
		global $CONFIG;
		$id 			= intval($this->_g('id'));
		$id_lang 		= intval($this->_g('id_lang'));
		$lid	 		= $this->_g('lang_id');
		
		$parentid 		= $this->_p('parentid');
		$lid 			= $this->_p('lid');
		$title 			= $this->_p('title');
		$brief 			= $this->_p('brief');
		$content 		= $this->_p('content');
		$content 		= $this->fixTinyEditor( $content );
		$type_id 		= $this->_p('type');
		$status 		= $this->_p('n_status');
		$posted_date 	= $this->_p('posted_date');
		$expired_date 	= $this->_p('expired_date');

		if(empty($lid)){
			$this->View->assign('msg',"Please complete the form!");
			$division = $this->fetch("SELECT * FROM axis_coorporate_blog WHERE parentid={$id} AND lid={$id_lang}");
			if( is_array($division) ){
				$this->View->assign("lid",$division['lid']);
				$this->View->assign("title",$division['title']);
				$this->View->assign("brief",$division['brief']);
				$this->View->assign("content",$division['content']);
				$this->View->assign("image",$division['image']);
				$this->View->assign("type_id",$division['type']);
				$this->View->assign("status",$division['n_status']);
				$this->View->assign("posted_date",$division['posted_date']);
				$this->View->assign("expired_date",$division['expired_date']);
				return $this->View->toString("application/admin/division/division_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit");
			}
		}
		
		if(!$this->query("UPDATE axis_coorporate_blog SET title='{$title}',brief='{$brief}',
														content='{$content}',
														posted_date='{$posted_date}',
														expired_date='{$expired_date}',
														n_status='{$status}'
														WHERE parentid={$id} AND lid={$id_lang};")){
			$this->View->assign("msg","Edit process failure");
			$division = $this->fetch("SELECT * FROM axis_coorporate_blog WHERE parentid={$id} AND lid={$id_lang}");
			if( is_array($division) ){
				$this->View->assign("lid",$division['lid']);
				$this->View->assign("title",$division['title']);
				$this->View->assign("brief",$division['brief']);
				$this->View->assign("content",$division['content']);
				$this->View->assign("image",$division['image']);
				$this->View->assign("type_id",$division['type']);
				$this->View->assign("status",$division['n_status']);
				$this->View->assign("posted_date",$division['posted_date']);
				$this->View->assign("expired_date",$division['expired_date']);
				return $this->View->toString("application/admin/division/division_edit.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit");
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
				
				if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}division/".$img)){
					list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}division/{$img}");
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
					$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/".$img);
					$thumb->adaptiveResize($w_small,$h_small);
					$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/small_".$img );
					$thumb->adaptiveResize($w_tiny,$h_tiny);
					$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}division/tiny_".$img );
				}
				$this->inputImage($id,$id_lang,$img);
			}
			return $this->View->showMessage('Berhasil', "index.php?s=division");
		}
		
		$division = $this->fetch("SELECT * FROM axis_coorporate_blog WHERE parentid={$id} AND lid={$id_lang}");
		if( is_array($division) ){
			$this->View->assign("lid",$division['lid']);
			$this->View->assign("title",$division['title']);
			$this->View->assign("brief",$division['brief']);
			$this->View->assign("content",$division['content']);
			$this->View->assign("image",$division['image']);
			$this->View->assign("type_id",$division['type']);
			$this->View->assign("status",$division['n_status']);
			$this->View->assign("posted_date",$division['posted_date']);
			$this->View->assign("expired_date",$division['expired_date']);
			return $this->View->toString("application/admin/division/division_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit");
		}
		return $this->View->toString("application/admin/division/division_edit.html");
	}
	
	function delete(){
		$parentid = $this->_g('parentid');
		if( !$this->query("UPDATE axis_coorporate_blog SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=division");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=division");
		}
	}

	function division_tab(){
		$id = $this->_g("id");
		$st = $this->_g("start");
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 20;
		
		$this->open(0);
		$sql = "SELECT * FROM axis_coorporate_division WHERE contentid={$id} ORDER BY date DESC LIMIT {$start},{$total_per_page}";		
		$list = $this->fetch($sql,1);
		$coor_blog = $this->fetch("SELECT id,title FROM axis_coorporate_blog WHERE id={$id}");
		/* Hitung banyak record data */
		$list_totalall = $this->fetch("SELECT * FROM axis_coorporate_division WHERE contentid={$id}",1);
		$this->close();
		$total = count($list_totalall);
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
		}
		
		$this->View->assign('list',$data);
		$this->View->assign('title_blog',$coor_blog['title']);
		$this->View->assign('id_content',$coor_blog['id']);
		$this->View->assign('start',$st);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=division&act=tab_division&id={$id}"));
		return $this->View->toString("application/admin/division/division_tab.html");
	}
	
	function add_tab(){
		$id_content 	= $this->_g('id_content');
		$start 			= $this->_g('start');
		$title 			= $this->_p('title');
		$description 	= $this->_p('description');
		$description 	= $this->fixTinyEditor( $description );
		$status 		= $this->_p('n_status');
		
		$this->View->assign('id_content',$id_content);
		$this->View->assign('start',$start);

		if($title=='' || $description==''){
			$this->View->assign('msg',"Please complete the form!");
			return $this->View->toString("application/admin/division/division_new_tab.html");
		}
		
		if( !$this->query("INSERT INTO axis_coorporate_division (contentid,title,description,date,n_status) 
			VALUES ('{$id_content}','{$title}','{$description}',NOW(),1)")){
			$this->View->assign("msg","Add process failure");
			return $this->View->toString("application/admin/division/division_new_tab.html");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=division&act=division_tab&id={$id_content}");
		}
		return $this->View->toString("application/admin/division/division_new_tab.html");
	}
	
	function edit_tab(){
		$id 			= intval($this->_g('id'));
		$id_content 	= intval($this->_g('id_content'));
		$start 			= $this->_g('start');
		$title 			= $this->_p('title');
		$description 	= $this->_p('description');
		$description 	= $this->fixTinyEditor( $description );
		$status 		= $this->_p('n_status');
		
		$this->View->assign('id',$id);
		$this->View->assign('id_content',$id_content);
		$this->View->assign('start',$start);

		if( empty($title) && empty($description)){
			$this->View->assign('msg',"Please complete the form!");
			$division_tab = $this->fetch("SELECT * FROM axis_coorporate_division WHERE id={$id}");
			
			if( is_array($division_tab)){
				$this->View->assign("title",$division_tab['title']);
				$this->View->assign("description",$division_tab['description']);
				$this->View->assign("status",$division_tab['n_status']);
				return $this->View->toString("application/admin/division/division_edit_tab.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit_tab");
			}
		}
		
		if(!$this->query("UPDATE axis_coorporate_division SET title='{$title}',description='{$description}' WHERE id={$id};")){
			$this->View->assign("msg","Edit process failure");
			$division_tab = $this->fetch("SELECT * FROM axis_coorporate_division WHERE id={$id}");

			if( is_array($division_tab) ){
				$this->View->assign("title",$division_tab['title']);
				$this->View->assign("description",$division_tab['description']);
				$this->View->assign("status",$division_tab['n_status']);
				return $this->View->toString("application/admin/division/division_edit_tab.html");
			}else{
				return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit_tab");
			}
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=division&act=division_tab&id={$id_content}");
		}
		
		$division_tab = $this->fetch("SELECT * FROM axis_coorporate_division WHERE id={$id}");
		if( is_array($division_tab) ){
			$this->View->assign("title",$division_tab['title']);
			$this->View->assign("description",$division_tab['description']);
			$this->View->assign("status",$division_tab['n_status']);
			return $this->View->toString("application/admin/division/division_edit_tab.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=division&act=edit_tab");
		}
		return $this->View->toString("application/admin/division/division_edit_tab.html");
	}
	
	function delete_tab(){
		$id = $this->_g('id');
		$id_content = $this->_g('id_content');
		$start 		= $this->_g('start');
		if(!$this->query("DELETE FROM axis_coorporate_division WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=division&act=division_tab&id={$id_content}&start={$start}");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=division&act=division_tab&id={$id_content}&start={$start}");
		}
	}
	
	function change_status(){
		$id = intval($this->_g('id'));
		$status = intval($this->_g('status'));
		if($this->query("UPDATE axis_coorporate_division SET n_status={$status} WHERE id={$id};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function excel(){
		$lid = $this->_g('lid');
		$startdate = $this->_g('startdate');
		$enddate = $this->_g('enddate');
		$filter = $lid=='' ? "" : " AND con.lid = {$lid} ";
		$filter .= $startdate=='' ? "" : " AND con.posted_date >= '{$startdate}' ";
		$filter .= $enddate=='' ? "" : " AND con.posted_date < '{$enddate}' ";
		$sql = "
		SELECT '' as no,con.lid,con.title,con.brief,con.content,con.created_date,con.posted_date,con.n_status 
		FROM axis_coorporate_blog con
		WHERE con.n_status<>3 AND con.type={$this->type} {$filter} 
		ORDER BY con.posted_date DESC;";
		$r = $this->fetch($sql,1);
		
		$language = $this->getLanguageList();
		$status = array(0=>"Inactive",1=>"Publish",2=>"Unpublish");
		
		foreach($language as $key => $val){
			$lang[$val['id']] = $val['language'];
		}
		
		$no=1;
		foreach($r as $key => $val){
			$val['no'] = $no++;
			$val['lid'] = $lang[$val['lid']];
			$val['n_status'] = $status[$val['n_status']];
			$data[] = $val;
		}
		
		global $ENGINE_PATH;
		include_once $ENGINE_PATH."Utility/PHPExcelWrapper.php";
		$excel = new PHPExcelWrapper();
		$excel->setGlobalBorder(true, 'allborders', '00000000');
		$excel->setHeader(array('No','Language','Title','Brief','Content','Created Date','Posted Date','Status'));
		$excel->getExcel($data,'list_Division');
		exit;
	}
	
	function inputparent($id){
		$sql = "SELECT * FROM axis_coorporate_blog ORDER BY id DESC";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$Key_id = $id==0 ? $list['id'] : $id;
		$this->query("UPDATE axis_coorporate_blog SET parentid='{$Key_id}' WHERE id={$Key_id};");
	}
	
	function inputImage($id,$id_lang,$img){
		$sql = "SELECT * FROM axis_coorporate_blog ORDER BY id DESC";
		$this->open(0);
		$list = $this->fetch($sql);
		$this->close();
		$Key_id = $id==0 ? $list['id'] : $id;
		$this->query("UPDATE axis_coorporate_blog SET image='{$img}' WHERE parentid={$Key_id} AND lid={$id_lang};");
	}

	function getLanguageList(){
		$language = $this->fetch("SELECT * FROM axis_language_category",1);
		return $language;
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM  axis_coorporate_type WHERE id=6",1);
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