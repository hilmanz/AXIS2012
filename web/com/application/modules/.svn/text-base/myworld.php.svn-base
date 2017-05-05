<?php

class myworld extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;	
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->bookmarkHelper = $this->useHelper('bookmarkHelper');
		if($this->getUserOnline()) $this->userHelper->getRankUser();
		$this->sharePostHelper = $this->useHelper("sharePostHelper");
		// $this->twitterHelper = $this->useHelper("twitterHelper");
		if($this->getUserOnline()) $this->assign('user',$this->user);
		
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('userpage', $this->userpage);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
		$this->assign('getContent_ajax',$this->Request->encrypt_params(array('page'=>$this->userpage,'act'=>'getContent_ajax')));
		$this->assign('deleteLikeFB',$this->Request->encrypt_params(array('page'=>$this->userpage,'act'=>'unlikeFB')));
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
		if(isset($_SESSION['myworldDetailWeb']))$start=intval($_SESSION['myworldDetailWeb']);
		else $start=0;
		
		$current = (ceil($start)/4)+1;
	
		if(!$this->user) $qDataContent = $this->contentHelper->getPublicContent($start);
		else $qDataContent = $this->contentHelper->getContent($start);
		$this->assign('myworldDetailWeb',$current);
		
		$qDataCategory = $this->contentHelper->getCategoryType(0,50);
	
		$this->assign('category',$qDataCategory);
		$this->assign('typeCategory',intval($this->_request('cid')));
		$this->assign('content',$qDataContent);
		$this->assign('type',intval($this->_request('type')));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		$this->log('globalAction','User Page');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-life.html');
	}

	function myfavorite(){
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
			
		$this->assign('bookmark',$this->bookmarkHelper->getBookmark());
	
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		// print_r($this);exit;
		$this->log('globalAction','my Favorite Page');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-favorite.html');
	}
	
	function myarticle(){
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
	
		$data = $this->sharePostHelper->getContent();

		$this->assign('article',$data);
	
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		// print_r($data);exit;
		$this->log('globalAction','my Favorite Page');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-myarticle.html');
	}
	
	function mycomment(){
	
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
	
	
		$data = $this->sharePostHelper->getCommentList();
		$this->assign('comment',$data);
	
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		// print_r($this);exit;
		$this->log('globalAction','my Favorite Page');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-mycomment.html');
	}
	
	
	
	function addMyFavorite(){
		if(!$this->getUserOnline()){
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');		
			print json_encode(false);exit;
		}
		$data = $this->bookmarkHelper->saveBookmark();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		$this->log('bookmark',"{$this->Request->getParam('content')}_{$this->Request->getParam('id')}");
		print json_encode($data);exit;
	}
	
	function unMyFavorite(){
		if(!$this->getUserOnline()){
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');		
			print json_encode(false);exit;
		}
		
		$data = $this->bookmarkHelper->deleteBookmark();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		$this->log('globalAction',"{$this->Request->getParam('content')}_{$this->Request->getParam('id')}");
		print json_encode($data);exit;
	}
	
	function submit_article(){
	
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
		
		$qDataCategory = $this->contentHelper->getCategoryType(0,30,null,false);
	
		$this->assign('category',$qDataCategory);
	
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		// print_r($this);exit;
		$this->log('globalAction','submit article');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-life-submit-article.html');
	}
	
	function submit_url(){
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
		
		$qDataCategory = $this->contentHelper->getCategoryType(0,30,null,false);
	
		$this->assign('category',$qDataCategory);
	
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('sidebar_axis_life',$this->setWidgets('sidebar_axis_life'));
		// print_r($this);exit;
		$this->log('globalAction','submit url');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/axis-life-submit-url.html');
		
	}
	function saveProfile(){
	
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
	
		if($this->Request->getPost('updateProfile')==1){
			$this->userHelper->updateUserProfile();
			$this->log('changeProfile',1);
		}else{
			$this->log('changeProfile',0);
		}
		sendRedirect('index.php?page={$this->userpage}');
		exit;
	}
	
	function changePreferance(){
		return false;
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
		
		
		$this->View->assign('title','Setting Preferences');
		$this->log('globalAction','Change Preferences');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisLife/profile/preferanceSetting.html');
	}
	
	function savePreferances(){
		global $CONFIG;
		if(!$this->getUserOnline()){
			
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}
		
		$savePreferances = $this->userHelper->savePreferenceThemeUser();
		$this->log('customPage');
	
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($savePreferances));exit;
		
	}
	
	function getUrlContent(){
		
		if(!$this->getUserOnline()){
			return false;
		}
	
		$data = $this->sharePostHelper->getUrlContent();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($data));exit;
	}
	
	function posting(){
		global $LOCALE,$CONFIG;
		if(!$this->getUserOnline()){
			global $CONFIG;
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$this->userpage}");
			die();
		}	
		$this->log('share');
		$data = $this->sharePostHelper->sharePosting();
		if($data){
			$result = true;
			$msg = $LOCALE[$this->lid]['msg']['SUCCESSSUBMITARTICLE'] ;
		}else {
			$result = false;
			$msg = $LOCALE[$this->lid]['msg']['CANNOTSUBMITARTICLE'] ;
		}
		$data = array ('result'=>$result,'msg'=>$msg);
		$this->assign('notification',$data['msg']);
		sendRedirect("{$CONFIG['BASE_DOMAIN']}index.php?page={$this->userpage}&act=myarticle");
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/message.html');
	}
	
	function shareUrl(){
		return false;
		if(!$this->getUserOnline()){
			return false;
		}
	
		$this->log('share');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		$data = $this->Request->getPost('url');
		print(json_encode($data));exit;
	}
	
	function saveImage(){
	
		if(!$this->getUserOnline()){
			return false;
		}
	
		$data =  $this->userHelper->saveImage();
		$this->log('changeProfile','photo');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode(array('filename' => $data,'url'=>'public_assets/user/photo/')));exit;
	}
	
	function saveCropImage(){
		
		if(!$this->getUserOnline()){
			return false;
		}
	
		$data =  $this->userHelper->saveCropImage();
		$this->log('changeProfile','photo');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode(array('filename' => $data,'url'=>'public_assets/user/photo/')));exit;
	}
	
	function getContent_ajax(){
		$_SESSION['myworldDetailWeb'] = intval($this->_p("start"));
		if(!$this->user) $qDataContent = $this->contentHelper->getPublicContent();
		else $qDataContent = $this->contentHelper->getContent();
		
		$qDataCategory = $this->contentHelper->getCategoryType();
				
		$this->log('globalAction','User Page');

		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($qDataContent));exit;
	}
	function unlikeFB(){
		//UNLIKE FB
		$access_token = $this->session->getSession('facebook_session','facebook')->ac;
		if(isset($access_token)){
			$ch = curl_init();
			$url = 'https://graph.facebook.com/'.$this->_p("post_id").'/likes?access_token='.$access_token;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			$result = curl_exec($ch);
			curl_close ($ch);
		}else{
			$result = false;
		}
		echo $result;exit;
	}
	function regetTwitter(){
		if(isset($this->session->getSession('twitter_session','twitter')->user)){
			$this->twitterHelper = $this->useHelper("twitterHelper");
			$list = $this->twitterHelper->getHomeTimeline();
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			print(json_encode($list));exit;
		}else{
			return false;
		}
	}
	function regetFB(){
		if(isset($this->session->getSession('facebook_session','facebook')->user)){
			$fb = @$this->session->getSession('facebook_session','facebook')->ac;
			$fql_query_url = 'https://graph.facebook.com/me/home?access_token='.$fb;
			$fql_query_result = file_get_contents($fql_query_url);
			$fql_query_obj = json_decode($fql_query_result, true);
			
			if(array_key_exists('data',$fql_query_obj)){
				foreach($fql_query_obj['data'] as $k => $v){
					if(array_key_exists('likes',$fql_query_obj['data'][$k])){
						foreach($fql_query_obj['data'][$k]['likes']['data'] as $kk => $vv){
							if($vv['id'] == $this->session->getSession('facebook_session','facebook')->user){
								$fql_query_obj['data'][$k]['likes']['can_like'] = 1;
							}
						}
					}
				}
			}
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			print(json_encode($fql_query_obj['data']));exit;
		}else{
			return false;
		}
	}
	function regetGplus(){
		global $FB, $ENGINE_PATH, $GPLUS, $GPLUSBOT;
		require_once $ENGINE_PATH."functions.php";
		
		if(isset($this->session->getSession('gplus_session','gplus')->user)){
			
			$gplusID = $this->session->getSession('gplus_session','gplus')->userProfile->id;
			$gplus_query_url = "https://www.googleapis.com/plus/v1/people/".$gplusID."/activities/public?maxResults=10&fields=items(actor(displayName%2Cid%2Cimage)%2Cobject%2Cverb%2Cpublished%2Cid)&key=".$GPLUS['developer_key'];
			$gplus_query_result = file_get_contents($gplus_query_url);
			
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			$plus_query_obj = json_decode($gplus_query_result, true);

			print(json_encode($plus_query_obj['items']));exit;
		}else{
			return false;
		}
	}
}


?>