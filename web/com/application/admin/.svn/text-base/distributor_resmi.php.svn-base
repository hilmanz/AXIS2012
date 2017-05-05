<?php
error_reporting(E_ALL);
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class distributor_resmi extends Admin{
	function __construct(){	
		parent::__construct();	
		$this->type = 24;
	}
	
	function admin(){
		if($this->_g("lid")) $this->lid = $this->_g("lid");
		else  $this->lid = 1;
		
		
		//helper
		$this->language = $this->getLanguageList();
		$this->View->assign('language',$this->language);
			global $CONFIG;$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$filter ="";			
		$time['time'] = '%H:%M:%S';
		$start = intval($this->_g('st'));
		$total_per_page = 5;
		$search = $this->_g("search");
		if($search) $filter .=" AND (con.title like '%{$search}%' OR ct.city like '%{$search}%') ";
		$this->View->assign('search',$search);
		/* list article */
		$sql = "
			SELECT con.*,ct.city
			FROM axis_news_content con
			LEFT JOIN axis_city_reference ct ON con.cityid = ct.id
			WHERE n_status<>3
			AND con.articleType={$this->type}
			AND con.lid={$this->lid}
			{$filter}
			ORDER BY con.created_date DESC
			LIMIT {$start},{$total_per_page}
		";
		
		$list = $this->fetch($sql,1);
		if($list){
			
			foreach($list as $val){
				$arrPid[] = $val['parentid'];
			}
			if($arrPid) $strPid = implode(',',$arrPid);
			else $strPid = false;
			$langData = $this->checkLanguage($strPid);
			
			//merge with language
			foreach($list as $key => $val){
				$list[$key]['language_data'] = $langData[$val['parentid']];
			
			}
		}
		
		/* Hitung banyak record data */
		$totalList = $this->fetch("SELECT count(*) total
			FROM axis_news_content con
			LEFT JOIN axis_city_reference ct ON con.cityid = ct.id
			WHERE n_status<>3
			AND con.articleType={$this->type}
			AND con.lid={$this->lid}
			{$filter} GROUP BY con.parentid",1);		
		
		$total = intval(count($totalList));

		$this->View->assign('list',$list);
		$this->View->assign('time',$time);
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total, "?s=distributor_resmi&lid={$this->lid}"));	
		return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_list.html");
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
		$province 	= $this->getProvince();
		$this->View->assign('province',$province);
		
		if($this->_p('save')){
			$lid 			= $this->Request->getPost('lid');
			$title 			= $this->Request->getPost('title');
			$brief 			= $this->Request->getPost('brief');
			$content 		= $this->Request->getPost('content');		
			$content 		  = $this->fixTinyEditor( $content );
			$status 		= $this->Request->getPost('n_status');
			$cityid 		= $this->Request->getPost('cityid');
	
			if($lid==''){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_new.html");
			}
			$sql = "INSERT INTO axis_news_content (lid,title,brief,content,articleType,n_status,created_date,authorid,cityid) 
				VALUES 
				('{$lid}','{$title}','{$brief}',\"{$content}\",'{$this->type}','{$status}',NOW(),{$this->Session->getVariable("uid")},'{$cityid}')";
			
			
			$this->query($sql);
			
			$last_id = $this->getLastInsertId();
			// pr($sql);exit;
			if(!$last_id){
				$this->View->assign("msg","Add process failure");
				return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_new.html");
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
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/{$img}")){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/{$img}");
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
						$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=distributor_resmi");
			}
		}
		return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_new.html");
	}
	
	function add_language(){
		$id = $this->_g('id');
		$lid = $this->Request->getParam('id_lang');
		$sql = "SELECT * FROM axis_news_content WHERE id={$id} LIMIT 1";
		$qData = $this->fetch($sql);
		
		$sql ="
		INSERT INTO axis_news_content (parentid,lid,title,brief,content,image,articleType,n_status,created_date,authorid,cityid) 
		VALUES 
		({$qData['parentid']},{$lid},'{$qData['title']}','{$qData['brief']}',\"{$qData['content']}\",'{$qData['image']}',{$qData['articleType']},'{$qData['n_status']}',NOW(),{$this->Session->getVariable("uid")},'{$qData['cityid']}')";
		// pr($sql);exit;
		$this->query($sql);
		if(!$this->getLastInsertId()){
			return $this->View->showMessage('Gagal', "index.php?s=distributor_resmi");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=distributor_resmi");
		}
	}
	
	function edit(){
		global $CONFIG;
		$parentid 		= $this->_g('id');
		$lid 			= $this->_g('lid');
		
		$province 	= $this->getProvince();
		$this->View->assign('province',$province);
		
		if(! $this->_p('save')){
			$sql = "SELECT * FROM axis_news_content WHERE parentid={$parentid} AND lid = {$lid} AND articleType={$this->type} LIMIT 1";
			$qData = $this->fetch($sql);
			foreach($qData as $key => $val){
				$this->View->assign($key,$val);
				$province = $this->fetch("SELECT * FROM axis_city_reference WHERE id={$qData['cityid']}");
				$city = $this->fetch("SELECT * FROM axis_city_reference WHERE provinceid={$province['provinceid']}",1);
				$this->View->assign("provinceid",$province['provinceid']);
				$this->View->assign("id_city",$province['id']);
				$this->View->assign("city",$city);
			}
			$deviceData = $this->getDeviceContent($parentid);
			$this->View->assign('deviceData',$deviceData);
		}else{
			$id 			= $this->_p('id');
			$lid 			= $this->_p('lid');
			$title 			= $this->_p('title');
			$brief 			= $this->_p('brief');
			$content 		= $this->_p('content');		
			$content 		  = $this->fixTinyEditor( $content );
			$status 		= $this->_p('n_status');
			$parentid		= $this->_p('parentid');
			$cityid			= $this->_p('cityid');
		
			
			if($lid==''){
				$this->View->assign('msg',"Please complete the form!");
				return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_edit.html");
			}
			$sql = "UPDATE axis_news_content SET title='{$title}',brief='{$brief}',
														content=\"{$content}\",
														n_status='{$status}',
														cityid='{$cityid}',
														authorid = {$this->Session->getVariable("uid")}
														WHERE id={$id} AND lid={$lid} LIMIT 1";
			
			
			$last_id = $parentid;
		
			if(!$this->query($sql)){
				$this->View->assign("msg","edit process failure");
				return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_edit.html");
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
					
					if(move_uploaded_file($_FILES['image']['tmp_name'],"{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/{$img}")){
						list($width, $height, $type, $attr) = getimagesize("{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/{$img}");
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
						$big = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/".$img);
						$thumb->adaptiveResize($w_small,$h_small);
						$small = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/small_".$img );
						$thumb->adaptiveResize($w_tiny,$h_tiny);
						$tiny = $thumb->save( "{$CONFIG['LOCAL_PUBLIC_ASSET']}distributor_resmi/tiny_".$img );
					}
					
					$this->inputImage($last_id,$img);
					
				}
				
				
				return $this->View->showMessage('Berhasil', "index.php?s=distributor_resmi");
			}
		}
		
		return $this->View->toString("application/admin/distributor_resmi/distributor_resmi_edit.html");
	}
	
	function delete(){
		$parentid = $this->_g('parentid');
		if( !$this->query("UPDATE axis_news_content SET n_status=3 WHERE parentid={$parentid}")){
			return $this->View->showMessage('Gagal', "index.php?s=distributor_resmi");
		}else{
			return $this->View->showMessage('Berhasil', "index.php?s=distributor_resmi");
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
	
	function getProvince(){
		$province = $this->fetch("SELECT * FROM axis_province_reference WHERE  id NOT IN (3,15,23,7,33,34,31,35,29,36,12)   ORDER BY province ASC",1);
		return $province;
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
	
	function get_city() {
		$province_id = $this->Request->getPost('province_id');
		$city = $this->fetch("SELECT * FROM axis_city_reference WHERE provinceid={$province_id} ORDER BY city ASC",1);
		foreach ($city as $val){
			$title = $val['city'];
			$data .= "<option value='{$val[id]}' >{$title}";
		}
		echo $data;
		exit;
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