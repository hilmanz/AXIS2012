<?php
class home extends App{
	
	function beforeFilter(){
		global $CONFIG;
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->facebookHelper = $this->useHelper('FacebookHelper');
		$voteurl = $this->Request->encrypt_params(array("page"=>"home","act"=>"dovote","uid"=>@$this->session->getSession('facebook_session','facebook')->user,"st"=>$this->_g("st")));
		
		if($this->facebookHelper->fb->getUser()){
			$this->assign('fbConnect',"index.php?".$voteurl);
			$this->assign('facebookButton',false);
		}else {
			$params = array('scope' => 'email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream');
			$this->assign('fbConnect',$this->facebookHelper->fb->getLoginUrl($params));
			$this->assign('facebookButton',true);
		}
		//$this->assign('paging_ajax',$this->Request->encrypt_params(array("page"=>"home","act"=>"paging_ajax")));
		//$this->assign('detail_page',"index.php?".$this->Request->encrypt_params(array("page"=>"home","act"=>"detail")));
		$this->assign('galeri_page',"index.php?".$this->Request->encrypt_params(array("page"=>"home","act"=>"galery","st"=>"")));
		return $this->View->toString(APPLICATION .'/mobile/galeri.html');
	}
	
	function main(){
		$this->assign('emoticon',$this->contentHelper->getEmoticon());
		$this->log('globalAction','home');
		return $this->View->toString(TEMPLATE_DOMAIN_MOBILE .'/home.html');
	}
	
	function faq(){
		$this->log('globalAction','faq');
		return $this->View->toString(TEMPLATE_DOMAIN_MOBILE .'/faq.html');
	}
	
	function tnc(){
		$this->assign('emoticon',$this->contentHelper->getEmoticon());
		$this->log('globalAction','tnc');
		return $this->View->toString(TEMPLATE_DOMAIN_MOBILE .'/tnc.html');
	}
	
	function gallery(){
		$data = $this->contentHelper->gallery();
		$this->assign('list',$data);
		return $this->View->toString(APPLICATION .'/mobile/galeri.html');
	}
	
	function dovote(){
		global $FB,$CONFIG;
		$start = $this->_g('st');
		$fbid = $this->facebookHelper->fb->getUser();
		try{
			if($fbid) $profile = $this->facebookHelper->fb->api('/me');
			else $profile = null;
			$ac = $this->facebookHelper->fb->getAccessToken();
		}catch (Exception $e){
			$profile = null;
			$ac = null;
		}
		if(!$fbid) $fbid = null;
		$emoticon = $this->contentHelper->getEmoticon();
		if(!$emoticon) {
			$data['status'] = false;
			return $data;
		}
		
		$description = "{$emoticon[0]['name']} finalist : {$emoticon[0]['owner']} dari {$emoticon[0]['city']} dengan total vote : {$emoticon[0]['vote']}";
		$rs = $this->contentHelper->saveVote($fbid,$profile,$description);
		
		$fbfeed = "https://www.facebook.com/dialog/feed/?";
		$params['app_id'] = $FB['appID'];
		$params['link'] = $CONFIG['MOBILE_SITE'];
		$params['picture'] = $CONFIG['BASE_DOMAIN']."public_assets/galeri/".$emoticon[0]['image'];
		$params['name'] = $profile['name'];
		$params['caption'] = "Kakao Contest 2012";
		$params['description'] = $description;
		$params['redirect_uri'] = $CONFIG['MOBILE_SITE']."?".$this->Request->encrypt_params(array("page"=>"home","act"=>"gallery","st"=>$start));
		$data['dialogurl'] = $fbfeed.http_build_query($params);
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		$data['status'] = $rs;
			
		if($fbid){
			$data['facebook'] = true;
			header("location:{$data['dialogurl']}");
			exit;
			// echo json_encode($data);exit;
		}else{
			$data['facebook'] = false;
			header("location:{$data['dialogurl']}");
			exit;
			// echo json_encode($data);exit;
		}	
	}
	
	function detail(){
		$this->assign('emoticon',$this->contentHelper->getEmoticon());
		$this->log('globalAction','home');
		return $this->View->toString(TEMPLATE_DOMAIN_MOBILE .'/home.html');
	}
}
?>