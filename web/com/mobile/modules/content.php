<?php
class content extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
	
		$this->sharePostHelper = $this->useHelper("sharePostHelper");
		$this->assign('locale',$LOCALE[$this->lid]);
		$this->assign('userpage', $this->userpage);
		
		if($this->getUserOnline()) $this->assign('user',$this->user);
		if($this->getUserOnline()) $this->userHelper->getRankUser();
	}

		
	function saveRate(){
	
		$qData = $this->contentHelper->saveRating();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		if($qData) {
		$this->log('rating',intval($this->Request->getPost('cid')));
			echo(json_encode($qData));exit;
		}else{
			echo(json_encode($qData));exit;
		}
			
	}
	
	function sendComment(){
	
		$this->log('comment');
		$data = $this->contentHelper->addComment();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		print(json_encode($data));exit;
	
	}
	
	function saveRateSocial(){
	
		$qData = $this->contentHelper->saveRatingSocial();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		if($qData) {
		$this->log('rating','social_'.intval($this->Request->getPost('cid')));
			echo(json_encode($qData));exit;
		}else{
			echo(json_encode($qData));exit;
		}
			
	}
	
	function sendCommentSocial(){
	
		$this->log('comment','social');
		$data = $this->contentHelper->addCommentSocial();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		print(json_encode($data));exit;
	
	}
	
	
	function detail(){
		global $CONFIG;
		$id = intval($this->_g("id"));
		
		
		if($id){
			$axis= $this->contentHelper->getDetailContent();
			if($axis) {
				$this->View->assign('URL',"{$CONFIG['BASE_DOMAIN_PATH']}content/detail/{$id}");
				$this->View->assign('twitURL',"{$CONFIG['BASE_DOMAIN_PATH']}content/detail/{$id}");
			}	
			$this->View->assign('axis',$axis);
		
			$this->log('globalAction','mobile-axisku-detail');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku-detail.html');
		}
	}
	
	function sdetail(){
		global $CONFIG;
		$id = intval($this->_g("id"));

		
		if($id){
			$axis= $this->sharePostHelper->getDetailContent();
			if($axis) {
				$this->View->assign('URL',"{$CONFIG['BASE_DOMAIN_PATH']}content/sdetail/{$id}");
				$this->View->assign('twitURL',"{$CONFIG['BASE_DOMAIN_PATH']}content/sdetail/{$id}");
			}	
			$this->View->assign('axis',$axis);
		
			$this->log('globalAction','mobile-axisku-detail');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/axisku-detail-social.html');
		}
	}
	
	
}


?>