<?php
error_reporting(0);
global $ENGINE_PATH;
global $CONFIG;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once $ENGINE_PATH."config/config.inc.php";

class article_user extends Admin{
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
				// $category[] = $val['category'];
			}
			if($type) $this->type = implode(',',$type);
			else return false;
			if($category) $this->category = implode(',',$category);
			else return false;
		}
		
		global $CONFIG;
		$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		$act = $this->Request->getParam('act');
		
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}
	
	function home(){
		$search = $this->Request->getParam('search');
		$status = $this->Request->getParam('n_status');
		$startdate = $this->Request->getParam('startdate');
		$enddate = $this->Request->getParam('enddate');
		$id_cat = $this->Request->getParam("id_cat") == NULL ? '' : $this->Request->getParam("id_cat");
		
		$filter = $search=='' ? "" : "AND ( sm.name like '%{$search}%' OR con.title like '%{$search}%' OR con.brief like '%{$search}%' OR con.content like '%{$search}%')";
		$filter .= $status=='' ? "" : " AND con.n_status = {$status}";
		$filter .= $startdate=='' ? "" : " AND con.posted_date >= '{$startdate}'";
		$filter .= $enddate=='' ? "" : " AND con.posted_date < '{$enddate}'";
		
		//check klo ada specified role nya
		if ($this->Request->getParam("cari")=='cari' && $id_cat!='') {
			$filter .= "AND con.categoryid IN ({$id_cat}) ";
		} else {
			if($this->category) {
				$filter .= "AND con.categoryid IN ({$this->category}) ";
			}
		}
		
		$time['time'] = '%H:%M:%S';
		$start = intval($this->Request->getParam('st'));
		$total_per_page = 20;
		$sql = "
			SELECT con.*,sm.name,cat.category,typ.type as type_name
			FROM  social_news_content con
			LEFT JOIN social_member sm ON con.userid = sm.id
			LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
			WHERE con.n_status<>3 {$filter} ORDER BY con.created_date DESC LIMIT {$start},{$total_per_page}
		";
		
		$totalSql = "SELECT count(*) total FROM social_news_content con WHERE n_status<>3 {$filter}";
	
		$this->open(0);
		$list = $this->fetch($sql,1);
		$member = $this->fetch($totalSql);
		$this->close();
		$total = $member['total'];
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
		}
		
		$category = $this->getCategoryList();
		$cek_cat = count($category);
		$this->View->assign('list',$data);
		$this->View->assign('time',$time);
		$this->View->assign('search',$search);
		$this->View->assign('status',$status);
		$this->View->assign('start',$start);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('cat',$category);
		$this->View->assign('cek_cat',$cek_cat);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=article_user&search={$search}&n_status={$status}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/article_user/userpost_list.html");
	}
	
	function edit(){
		global $CONFIG;
		
		$id 		= $this->Request->getParam('id');
		$search 	= $this->Request->getParam('search');
		$status 	= $this->Request->getParam('status');
		$startdate 	= $this->Request->getParam('startdate');
		$enddate 	= $this->Request->getParam('enddate');
		$page 		= $this->Request->getParam('page');
		$this->View->assign('id',$id);
		$this->View->assign('search',$search);
		$this->View->assign('status',$status);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('page',$page);
		
		$title 		= $this->Request->getPost('title');
		$brief 		= $this->Request->getPost('brief');
		$url 		= $this->Request->getPost('url');
		$content 	= $this->Request->getPost('content');
		$content 	= $this->fixTinyEditor($content);
		
		if( $id > 0 && $title != ''){
			$qry = "UPDATE social_news_content SET title='{$title}',brief='{$brief}',content=\"{$content}\" WHERE id={$id}";
			if($this->query($qry)){
				if ($_FILES['image']['name']!=NULL) {
					include_once '../../engines/Utility/phpthumb/ThumbLib.inc.php';
					list($file_name,$ext) = explode('.',$_FILES['image']['name']);
					$img = md5($_FILES['image']['name'].rand(1000,9999)).".".$ext;
					try{
						$thumb = PhpThumbFactory::create( $_FILES['image']['tmp_name']);
					}catch (Exception $e){
						// handle error here however you'd like
					}
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}user/content/".$img)){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}user/content/{$img}");
						
						//resize the image
						$thumb->adaptiveResize($width,$height);
						$big = $thumb->save("{$CONFIG['LOCAL_PUBLIC_ASSET']}user/content/".$img);
					}
					$this->inputImage($id,$img);
				}
				return $this->View->showMessage('Berhasil', "index.php?s=article_user&search={$search}&n_status={$status}&startdate={$startdate}&enddate={$enddate}&st={$page}");
			}else{
				$this->View->assign('msg','Error, please fill all field!');
			}
		}else{
			//$this->View->assign('msg','Error, please fill all field!');
		}
		
		$list_content = $this->fetch("SELECT * FROM social_news_content WHERE id={$id}");
		$list_url = $this->fetch("SELECT * FROM social_news_content WHERE n_status<>3 AND url like '%http%'",1);
		foreach ($list_url as $k => $v) {
			$url[$v['id']] = $v['url'];
		}
		
		if( is_array($list_content)){
			$url_error = $url[$list_content['id']] ? true : false;
			$this->View->assign("id_type",$list_content['id']);
			$this->View->assign("title",$list_content['title']);
			$this->View->assign("brief",$list_content['brief']);
			$this->View->assign("content",$list_content['content']);
			$this->View->assign("url",$list_content['url']);
			$this->View->assign("url_status",$url_error);
			$this->View->assign("image",$list_content['image']);
			return $this->View->toString("application/admin/article_user/userpost_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=article_user&act=edit");
		}
		return $this->View->toString("application/admin/article_user/userpost_edit.html");
	}
	
	function hapus(){
		$id = $this->Request->getParam('id');
		if( !$this->query("UPDATE social_news_content SET n_status=3 WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=article_user");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=article_user");
		}
	}
	
	function user_content(){
		$userid = $this->Request->getParam('userid');
		$search = $this->Request->getParam("search") == NULL ? '' : $this->Request->getParam("search");
		$startdate = $this->Request->getParam("startdate") == NULL ? '' : $this->Request->getParam("startdate");
		$enddate = $this->Request->getParam("enddate") == NULL ? '' : $this->Request->getParam("enddate");
		
		$filter  = $search=='' ? "" : "AND (news.title LIKE '%{$search}%' OR news.brief LIKE '%{$search}%' OR news.content LIKE '%{$search}%') ";
		$filter .= $startdate=='' ? "" : "AND news.posted_date >= '{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND news.posted_date < '{$enddate}' ";		
		
		$time['time'] = '%H:%M:%S';
		$total_per_page = 20;
		$start = intval($this->Request->getParam('st'));		
		
		$sql = "
			SELECT news.*,cat.category 
			FROM social_news_content news
			LEFT JOIN axis_news_content_category cat ON news.categoryid = cat.id
			WHERE userid={$userid} {$filter}
			ORDER BY posted_date DESC 
			LIMIT {$start},{$total_per_page}
		";
		//print_r($sql);
		$totalSql = "SELECT count(*) total FROM social_news_content WHERE userid={$userid} {$filter}";
		$sql_member = "SELECT * FROM social_member WHERE id={$userid}";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$arrUser = $this->fetch($sql_member);
		$content = $this->fetch($totalSql);
		$this->close();
		$total = $content['total'];
		
		$no=1+$start;
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
		}
		
		$this->View->assign('list',$data);
		$this->View->assign('nama',$arrUser['name']);
		$this->View->assign('userid',$userid);
		$this->View->assign('time',$time);
		$this->View->assign('search',$search);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=article_user&userid={$userid}&search={$search}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/article_user/my_article.html");
	}
	
	function viewPublish(){
		$time['time'] = '%H:%M:%S';
		$id = $this->Request->getParam('id');
		$userid = $this->Request->getParam('userid');
		
		$this->View->assign('id',$id);
		$this->View->assign('userid',$userid);
		$this->View->assign('time',$time);
		
		$status = $this->Request->getParam('n_status');
		//print_r($status);exit;
		if( $id > 0 && $status != ''){
			$qry = "UPDATE social_news_content SET n_status='{$status}' WHERE id={$id}";
			if($this->query($qry)){
				return $this->View->showMessage('Berhasil', "index.php?s=article_user&act=user_content&userid={$userid}");
			}else{
				$this->View->assign('msg','Error, please fill all field!');
			}
		}else{
			$this->View->assign('msg','Error, please fill all field!');
		}
		
		$list_content = $this->fetch("SELECT * FROM social_news_content WHERE id={$id}");
		if( is_array($list_content)){
			$this->View->assign("id",$list_content['id']);
			$this->View->assign("title",$list_content['title']);
			$this->View->assign("brief",$list_content['brief']);
			$this->View->assign("content",$list_content['content']);
			$this->View->assign("image",$list_content['image']);
			$this->View->assign("categoryid",$list_content['categoryid']);
			$this->View->assign("posted_date",$list_content['posted_date']);
			$this->View->assign("status",$list_content['n_status']);
			return $this->View->toString("application/admin/article_user/view_publish.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=article_user&act=viewPublish");
		}
		return $this->View->toString("application/admin/article_user/view_publish.html");
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
	
	function getCategoryList(){
		if($this->category) {
		 $qCat = " id IN ({$this->category}) AND used = 0 ";
		}else $qCat = " used = 0  ";
		$type = $this->fetch("SELECT * FROM axis_news_content_category WHERE {$qCat} ",1);
		return $type;
	}
	
	function inputImage($id,$img){
		$this->query("UPDATE social_news_content SET image='{$img}' WHERE id={$id};");
	}
	
	function change_status(){
		$id = intval($this->Request->getParam('id'));
		$status = intval($this->Request->getParam('status'));
		if($this->query("UPDATE social_news_content SET n_status={$status} WHERE id={$id};")){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0));
		}
		exit;
	}
	
	function export_excel(){
		$search = intval($this->Request->getParam('search'));
		$status = $this->Request->getParam('status');
		$startdate = intval($this->Request->getParam('startdate'));
		$enddate = intval($this->Request->getParam('enddate'));
		
		$filter = $search=='' ? "" : "AND ( sm.name like '%{$search}%' OR con.title like '%{$search}%' OR con.brief like '%{$search}%' OR con.content like '%{$search}%')";
		$filter .= $status=='' ? "" : " AND con.n_status = {$status}";
		$filter .= $startdate=='' ? "" : " AND con.created_date >= '{$startdate}'";
		$filter .= $enddate=='' ? "" : " AND con.created_date < '{$enddate}'";
		
		$sql = "
			SELECT '' as no,sm.name,con.title,con.brief,con.content,cat.category,typ.type as type_name
			,con.created_date,con.posted_date,con.n_status,con.url
			FROM social_news_content con
			LEFT JOIN social_member sm ON con.userid = sm.id
			LEFT JOIN axis_news_content_category cat ON con.categoryid = cat.id
			LEFT JOIN axis_news_content_type typ ON con.articleType = typ.id
			WHERE con.n_status<>3 
			{$filter}
			ORDER BY con.created_date DESC
		";
		$r = $this->fetch($sql,1);
		$status = array(0=>"Non Publishing",1=>"Publishing");
		
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
		$excel->setHeader(array('No','Name','Title','Brief','Content','Category','Type','Created Date','Posted Date','Status','URL'));
		$excel->getExcel($data,'User_Content');
		exit;
	}
}