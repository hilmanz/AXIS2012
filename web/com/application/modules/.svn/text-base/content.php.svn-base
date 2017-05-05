<?php
class content extends App{
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->sharePostHelper = $this->useHelper('sharePostHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
		$this->getaxiskulink();
	}
	
	function getaxiskulink(){
			global $CONFIG;
			
				if(isset($this->session->getSession('twitter_session','twitter')->user)) {
					$this->assign('twConnect',$CONFIG['BASE_DOMAIN']."logout.php");
					$this->assign('twConnectButton','loginTwitterActive');
				}else {
					$this->assign('twConnect',@$this->session->getSession('twitter_session','twitter')->urlConnect);
					$this->assign('twConnectButton','');
				}
							
				if(isset($this->session->getSession('facebook_session','facebook')->user)) {
					$this->assign('fbConnect',@$this->session->getSession('facebook_session','facebook')->urlConnect);
					$this->assign('facebookButton','loginFacebookActive');
				}else {
					$this->assign('fbConnect',@$this->session->getSession('facebook_session','facebook')->urlConnect);
					$this->assign('facebookButton','');
				}
				
				if(isset($this->session->getSession('gplus_session','gplus')->user)){
					$this->assign('gplusConnect',$CONFIG['BASE_DOMAIN']."logout.php");
					$this->assign('gplusConnectButton','loginGplusActive');
				}else{
					$this->assign('gplusConnect',@$this->session->getSession('gplus_session','gplus')->urlConnect);
					$this->assign('gplusConnectButton','');
				}
				
	}
	
	function main(){
		global $CONFIG;
		sendRedirect("{$CONFIG['BASE_DOMAIN']}/404.html");
		exit;
	
	}

	function detail(){
		global $CONFIG;
		
		$qData = $this->contentHelper->getDetailAxisArticle();
		$this->log('article',$this->Request->getParam('id'));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
		
			$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
			$this->View->assign('sidebar_content',$this->setWidgets('sidebar_content'));
			$this->assign('content',$qData);
			$this->assign('URL',urlencode($CONFIG['BASE_DOMAIN'].'index.php?page=content&act=detail&id='.$this->Request->getParam('id')));
			$this->assign('twitURL',$CONFIG['BASE_DOMAIN'].'index.php?page=content&act=detail&id='.$this->Request->getParam('id'));
		}
		
	
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'newsContent/newsContentDetail.html');
		
		// // using json return
		// $contentDetail = array(
					// 'title' => 'Detail News Content',
					// 'content' => $qData
		// );
		
		// echo(json_encode($contentDetail));exit;
	}
	
	
	function sdetail(){
		
		$qData = $this->sharePostHelper->getDetailContent();
		// pr($qData);exit;
		$this->log('article',"social_".$this->Request->getParam('id'));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
		
		
			$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
			$this->View->assign('sidebar_content',$this->setWidgets('sidebar_content'));
			$this->assign('content',$qData);
		
		}
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'newsContent/userContentDetail.html');
		
		// // using json return
		// $contentDetail = array(
					// 'title' => 'Detail News Content',
					// 'content' => $qData
		// );
		
		// echo(json_encode($contentDetail));exit;
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
		$this->log('rating','social_'.$this->Request->getPost('cid'));
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
	
	
	function getComment_ajax(){
		
		$this->log('comment','social');
		$data = $this->contentHelper->getComment();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($data));exit;
	}
	
	function gplusWinner(){
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'axisProduct/thewinner.html');
	}
}


?>