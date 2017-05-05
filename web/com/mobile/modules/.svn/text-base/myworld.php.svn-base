<?php
class myworld extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->bookmarkHelper = $this->useHelper('bookmarkHelper');
		$this->sharePostHelper = $this->useHelper("sharePostHelper");
		$this->assign('locale',$LOCALE[$this->lid]);
		$this->assign('userpage', $this->userpage);
		
		if($this->getUserOnline()) $this->assign('user',$this->user);
		if($this->getUserOnline()) $this->userHelper->getRankUser();
		
	}
	function main(){
		$id = intval($this->_g("cid"));
		 // pr($id);exit;
		//buat tab
		if($id!=0){
			$maxRow = 4;
			if(isset($_SESSION['myworldDetail'][$id]))$start=intval($_SESSION['myworldDetail'][$id]);
			else $start=0;
			
			$current = (ceil($start)/4)+1;
			$this->View->assign('myworldDetail',$current);
			$this->View->assign('cid',$id);
			
			$category = $this->contentHelper->getCategoryType(0,1,$id);
			$this->View->assign('category',$category);
			
			if(!$this->user) $listAxis = $this->contentHelper->getPublicContent($start,$maxRow,$id);
			else $listAxis = $this->contentHelper->getContent($start,$maxRow,$id);
		
			 // pr($listAxis);exit;
			$this->View->assign('listAxis',$listAxis);
			
			$this->log('globalAction','mobile-axisku-'.$id);
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku-list.html');
		}else{
			if(intval($this->_p('axiskuList')) == 1){
				$_SESSION['myworldPage'] = intval($this->_p('start'));
				$category = $this->contentHelper->getCategoryType(intval($this->_p('start')),5);
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header('Content-type: application/json');		
				echo json_encode($category);exit;
			}else{
				if(isset($_SESSION['myworldPage']))$start=intval($_SESSION['myworldPage']);
				else $start=0;
				
				$current = (ceil($start)/5)+1;
				
				//buat category nya
				$category = $this->contentHelper->getCategoryType($start,5);
				$this->View->assign('myworldPage',$current);
				$this->View->assign('category',$category);
				
				$this->log('globalAction','mobile-axisku');
				return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku.html');
			}
		}
	}
	
	function myWordContent(){
		if(intval($this->_p('axiskuList')) == 1){
			$cid = intval($this->_p('catid'));
			$start = intval($this->_p('start'));
			$_SESSION['myworldDetail'][$cid] = $start;
			if(!$this->user) $listAxis = $this->contentHelper->getPublicContent($start,4,$cid);
			else $listAxis = $this->contentHelper->getContent($start,4,$cid);
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			echo json_encode($listAxis);exit;
		}
	}
	
	function detail(){
		global $CONFIG;
		$id = intval($this->_g("id"));
		$cid =  intval($this->_g("cid"));
		
		if($id){
			$axis= $this->contentHelper->getDetailContent();
			if($axis) {
				$this->View->assign('URL',"{$CONFIG['BASE_DOMAIN_PATH']}content/detail/{$id}");
				$this->View->assign('twitURL',"{$CONFIG['BASE_DOMAIN_PATH']}content/detail/{$id}");
			}	
			$this->View->assign('axis',$axis);
			$this->View->assign('cid',$cid);
			$this->log('globalAction','mobile-axisku-detail');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku-detail.html');
		}
	}
	
	function sdetail(){
		global $CONFIG;
		$id = intval($this->_g("id"));
		$cid =  intval($this->_g("cid"));
		
		if($id){
			$axis= $this->sharePostHelper->getDetailContent();
			// pr($axis);exit;
			if($axis) {
				$this->View->assign('URL',"{$CONFIG['BASE_DOMAIN_PATH']}content/sdetail/{$id}");
				$this->View->assign('twitURL',"{$CONFIG['BASE_DOMAIN_PATH']}content/sdetail/{$id}");
			}	
			$this->View->assign('axis',$axis);
			$this->View->assign('cid',$cid);
			$this->log('globalAction','mobile-axisku-detail-social');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku-detail-social.html');
		}
	}
	
	function addMyFavorite(){
		global $LOCALE,$CONFIG;
		$id = intval($this->Request->getParam('id'));
		$data = $this->bookmarkHelper->saveBookmark();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		$this->log('bookmark',"{$id}");
		print json_encode($data);exit;
	}
}
?>