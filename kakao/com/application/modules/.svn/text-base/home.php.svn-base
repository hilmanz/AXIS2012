<?php
class home extends App{
	
	
	
	function beforeFilter(){
		global $CONFIG,$LOCALE;
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->facebookHelper = $this->useHelper('FacebookHelper');
		$voteurl = $this->Request->encrypt_params(array("page"=>"home","act"=>"dovote","uid"=>@$this->session->getSession('facebook_session','facebook')->user));

		if($this->facebookHelper->fb->getUser()){
				$this->assign('fbConnect',"index.php?".$voteurl);
				$this->assign('facebookButton',false);
			}else {	
				$params = array('scope' => 'email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream');
				$this->assign('fbConnect',$this->facebookHelper->fb->getLoginUrl($params));
				$this->assign('facebookButton',true);
		}
		$this->assign('paging_ajax',$this->Request->encrypt_params(array("page"=>"home","act"=>"paging_ajax")));
		$this->assign('detail_page',"index.php?".$this->Request->encrypt_params(array("page"=>"home","act"=>"detail")));
		$this->assign('localpublicassets',$CONFIG['BASE_DOMAIN']."public_assets/");
		$this->assign('locale',$LOCALE);
	}
	
	function getLogoutUrl(){
		try{
			// if($this->facebookHelper->fb->getUser()){
				$data['status'] = true;
				$data['urlLogout'] = $this->facebookHelper->fb->getLogoutUrl();
			// }else{
				// $data['status'] = false;
				// $data['urlLogout'] = false;
			// }
		}catch (Exception $e){
			$data['status'] = false;
			$data['urlLogout'] = false;
		}
		
		return $data;
		
	}
	function main(){
		
		$this->assign('emoticon',$this->contentHelper->getEmoticon(0,15));
		$this->log('globalAction','home');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/home.html');
	}
	
	function paging_ajax(){
		$start = $this->_p('start');
		$rs = $this->contentHelper->getEmoticon($start,15);
		echo json_encode($rs);exit;
	}
	
	function dovote(){
		global $FB,$CONFIG;
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
		
		$description = "Telah ikutan nge-vote di AXIS KAKAOTALK EMOTICONTEST";
		$rs = $this->contentHelper->saveVote($fbid,$profile,$description);
		
		$fbfeed = "https://www.facebook.com/dialog/feed/?";
		$params['app_id'] = $FB['appID'];
		$params['link'] = $CONFIG['BASE_DOMAIN'];
		$params['picture'] = $CONFIG['BASE_DOMAIN']."public_assets/galeri/".$emoticon[0]['image'];
		$params['name'] = $profile['name'];
		$params['caption'] = "";
		$params['description'] = $description;
		$params['redirect_uri'] = $CONFIG['BASE_DOMAIN']."?".$this->Request->encrypt_params(array("page"=>"home","act"=>"closeit"));
		$data['dialogurl'] = $fbfeed.http_build_query($params);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		$data['status'] = $rs;
			
		if($fbid){
			$data['facebook'] = true;
			echo json_encode($data);exit;
		}else{
			$data['facebook'] = false;
			echo json_encode($data);exit;
		}
	
	}
	
	function detail(){
		$qData = $this->contentHelper->getEmoticon();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($qData[0]);exit;
	}
	
	function closeit(){
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/closeit.html');	
	}
}
?>