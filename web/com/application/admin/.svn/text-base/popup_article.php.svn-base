<?php
error_reporting(0);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
	
class popup_article extends Admin{
	function __construct(){
		parent::__construct();		
	}
	
	function admin(){
		$act = $this->Request->getParam('act');		
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$time['time'] = "%H:%M:%S";
		$start = intval($this->Request->getParam('st'));
		$search = $this->Request->getParam('search');
		$startdate = $this->Request->getParam('startdate');
		$enddate = $this->Request->getParam('enddate');
		
		$filter = $search=='' ? "" : " WHERE (pop.title LIKE '%{$search}%' OR pop.description LIKE '%{$search}%' OR con.title LIKE '%{$search}%') ";
		if ($search!='') {
			$filter .= $startdate=='' ? "" : "AND pop.date >= '{$startdate}' ";
		} else {
			$filter .= $startdate=='' ? "" : "WHERE pop.date >= '{$startdate}' ";
		}
		if ($startdate!='' || $search!='') {
			$filter .= $enddate=='' ? "" : "AND pop.date < '{$enddate}' ";
		} else {
			$filter .= $enddate=='' ? "" : "WHERE pop.date < '{$enddate}' ";
		}		
		
		$total_per_page = 20;
		$sql = "
			SELECT pop.*,con.title as title_article ,con.id conid
			FROM axis_news_content_popup_description pop
			LEFT JOIN axis_news_content con ON pop.contentid = con.id
			{$filter} 
			ORDER BY id DESC 
			LIMIT {$start},{$total_per_page}
		";
		
		$totalSql = "SELECT count(*) total FROM axis_news_content_popup_description {$filter}";
		$this->open(0);
		$list = $this->fetch($sql,1);
		$tot_type = $this->fetch($totalSql);
		$this->close();
		$total = $tot_type['total'];
		
		$no=1+$start;		
		foreach($list as $k => $v){
			$v['no'] = $no++;
			$data[] = $v;
		}
		
		$this->View->assign('list',$data);
		$this->View->assign('time',$time);
		$this->View->assign('search',$search);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=popup_article&search={$search}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/popup_article/popup_list.html");
	}
	
	function add(){
		$title 		= $this->Request->getPost('title');
		$id_type 	= $this->Request->getPost('articleType');
		$id_article = $this->Request->getPost('article');
		$desc 		= $this->Request->getPost('description');
		$desc 	  	= $this->fixTinyEditor( $desc );
		$status 	= $this->Request->getPost('n_status');
		
		$type 	= $this->getTypeList();
		$this->View->assign('type',$type);
		if($this->Request->getPost('cmd') == 'add'){
			if( $id_type != ''){
				$qry = "INSERT INTO axis_news_content_popup_description (contentid,title,description,date,n_status) 
				VALUES ('{$id_article}','{$title}',\"{$desc}\",NOW(),'{$status}')";
				if(!$this->query($qry)){
					$this->View->assign("msg","Add process failure");
					return $this->View->toString("application/admin/popup_article/popup_new.html");
				}else{
					return $this->View->showMessage('Berhasil', "index.php?s=popup_article");
				}
			}else{
				$this->View->assign('msg','Error, please fill all field!');
			}
		}
		return $this->View->toString("application/admin/popup_article/popup_new.html");
	}
	
	function edit(){
		$id = $this->Request->getParam('id');
		$title 		= $this->Request->getPost('title');
		$id_type 	= $this->Request->getPost('articleType');
		$id_article = $this->Request->getPost('article');
		$desc 		= $this->Request->getPost('description');
		$desc 	  	= $this->fixTinyEditor( $desc );
		$status 	= $this->Request->getPost('n_status');
		
		$type 	= $this->getTypeList();
		$this->View->assign('type',$type);
		
		if( $id > 0 && $id_type != ''){
			$qry = "UPDATE axis_news_content_popup_description SET contentid='{$id_article}',title='{$title}',description='{$desc}',date=NOW(),n_status='{$status}' WHERE id={$id}";
			if($this->query($qry)){
				return $this->View->showMessage('Berhasil', "index.php?s=popup_article");
			}else{
				$this->View->assign('msg','Error, please fill all field!');
			}
		}else{
			$this->View->assign('msg','Error, please fill all field!');
		}
		
		$list_popup = $this->fetch("SELECT * FROM axis_news_content_popup_description WHERE id={$id}");
		if( is_array($list_popup) ){
			$this->View->assign("id",$list_popup['id']);
			$this->View->assign("title",$list_popup['title']);
			$this->View->assign("contentid",$list_popup['contentid']);
			$this->View->assign("desc",$list_popup['description']);
			$this->View->assign("status",$list_popup['n_status']);
			$arrArticle = $this->fetch("SELECT * FROM axis_news_content WHERE id={$list_popup['contentid']}");
			if( is_array($arrArticle) ){
				$this->View->assign("id_type",$arrArticle['articleType']);
				$this->View->assign("id_article",$arrArticle['id']);
				$this->View->assign("title_article",$arrArticle['title']);
				$this->View->assign("lid",$arrArticle['lid']);
				$this->View->assign("brief",$arrArticle['brief']);
			}
			return $this->View->toString("application/admin/popup_article/popup_edit.html");
		}else{
			return $this->View->showMessage('Invalid id', "index.php?s=popup_article");
		}
		return $this->View->toString("application/admin/popup_article/popup_edit.html");
	}
	
	function hapus(){
		$id = $this->Request->getParam('id');
		if( !$this->query("DELETE FROM axis_news_content_popup_description WHERE id={$id}")){
			return $this->View->showMessage('Gagal', "index.php?s=popup_article");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=popup_article");
		}
	}
	
	function getTypeList(){
		$type = $this->fetch("SELECT * FROM axis_news_content_type",1);
		return $type;
	}
	
	function get_article() {
		$type_id = $this->Request->getParam('type_id');
		$article = $this->fetch("SELECT * FROM axis_news_content WHERE n_Status<>3 AND articleType={$type_id} ORDER BY title ASC",1);
		//$data .= "<option value=''>"."--Pilih--"."</option>";
		foreach ($article as $val){
			$lang = $val['lid']==1 ? "Indonesia" : "English";
			$title = ucfirst($val['title'].", ".substr($val['brief'],0,100)." ({$lang}) ");
			$data .= "<option value='{$val[id]}' >".$title;
		}
		echo json_encode($data);
		exit;
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