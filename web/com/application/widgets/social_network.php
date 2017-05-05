<?php
class social_network{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE,$CONFIG;
			$this->apps->assign('basedomain', $CONFIG['BASE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
			$this->apps->assign('twitter_ajax',$this->apps->Request->encrypt_params(array('page'=>$this->apps->userpage,'act'=>'regetTwitter')));
			$this->apps->assign('fb_ajax',$this->apps->Request->encrypt_params(array('page'=>$this->apps->userpage,'act'=>'regetFB')));
			$this->apps->assign('gplus_ajax',$this->apps->Request->encrypt_params(array('page'=>$this->apps->userpage,'act'=>'regetGplus')));
	}

	function main(){
		global $FB, $GPLUS, $GPLUSBOT;
		
		if(isset($this->apps->session->getSession('gplus_session','gplus')->user)){
			$this->apps->assign('gplus_check',1);
			$this->apps->assign('tab_check','gplus');
			//AXIS Gplus
			$gplus_query_url_default = "https://www.googleapis.com/plus/v1/people/".$GPLUSBOT['target_id']."/activities/public?public?maxResults=1&fields=items(actor(displayName%2Cid%2Cimage)%2Cobject%2Cverb%2Cpublished%2Cid)&key=".$GPLUS['developer_key'];
			$gplus_query_result_default = file_get_contents($gplus_query_url_default);
			$plus_query_obj_default = json_decode($gplus_query_result_default, true);
			$this->apps->assign('gplusDefault',$plus_query_obj_default['items'][0]);
			
			$gplusID = $this->apps->session->getSession('gplus_session','gplus')->userProfile->id;
			$gplus_query_url = "https://www.googleapis.com/plus/v1/people/".$gplusID."/activities/public?maxResults=10&fields=items(actor(displayName%2Cid%2Cimage)%2Cobject%2Cverb%2Cpublished%2Cid)&key=".$GPLUS['developer_key'];
			$gplus_query_result = file_get_contents($gplus_query_url);
			$plus_query_obj = json_decode($gplus_query_result, true);
			$this->apps->assign('gplusList',$plus_query_obj['items']);
		}else{
			$this->apps->assign('gplusURL',@$this->apps->session->getSession('gplus_session','gplus')->urlConnect);
		}
		
		if(isset($this->apps->session->getSession('facebook_session','facebook')->user)){
			$fb = @$this->apps->session->getSession('facebook_session','facebook')->ac;
			$fbID =  @$this->apps->session->getSession('facebook_session','facebook')->user;
			$this->apps->assign('at', $fb);
			$this->apps->assign('fbID',$fbID);
				
			$fql_query_url = 'https://graph.facebook.com/me/home?access_token='.$fb;
			$fql_query_result = file_get_contents($fql_query_url);
			$fql_query_obj = json_decode($fql_query_result, true);
			if($fql_query_obj){
				if(array_key_exists('data',$fql_query_obj)){
					foreach($fql_query_obj['data'] as $k => $v){
						if(array_key_exists('likes',$fql_query_obj['data'][$k])){
							foreach($fql_query_obj['data'][$k]['likes']['data'] as $kk => $vv){
								if($vv['id'] == $this->apps->session->getSession('facebook_session','facebook')->user){
									$fql_query_obj['data'][$k]['likes']['can_like'] = 1;
								}
							}
						}
					}
				}
			}
			$this->apps->assign('fbUser',@$this->apps->session->getSession('facebook_session','facebook')->userProfile->first_name);
			
			//AXIS FB
			$fql_query_url2 = 'https://graph.facebook.com/186172338083633/feed?limit=1&access_token='.$fb;
			$fql_query_result2 = file_get_contents($fql_query_url2);
			$fql_query_obj2 = json_decode($fql_query_result2, true);
			
			
			
			if(isset($fql_query_obj['error']['code']) == '190'){
				$this->apps->assign('fbURL',@$this->apps->session->getSession('facebook_session','facebook')->urlConnect);
			}else{
				$this->apps->assign('facebook_check',1);
				$this->apps->assign('tab_check','fb');
				$this->apps->assign('fbNameSoc',$this->apps->session->getSession('facebook_session','facebook')->userProfile->name);
				$this->apps->assign('fbList',$fql_query_obj['data']);
				$this->apps->assign('fbAXIS',$fql_query_obj2['data']['0']);
			}
			
		}else{
			$this->apps->assign('fbURL',@$this->apps->session->getSession('facebook_session','facebook')->urlConnect);
		}
		

		// $twitter_check = @$this->apps->session->getSession('twitter_session','twitter')->user;
		if(isset($this->apps->session->getSession('twitter_session','twitter')->user)){
				$userhelper = $this->apps->useHelper('twitterHelper');
			//klo uda abis
				if(!isset($_SESSION['twitter_expire'])){
					$_SESSION['twitter_expire'] = time() + (60*3);
					$this->apps->assign('twitter_check',1);
					$this->apps->assign('tab_check','tw');
					$this->apps->assign('twitter_id',$this->apps->session->getSession('twitter_session','twitter')->twitter_id);
					
					$this->apps->assign('twitPic', $this->apps->session->getSession('twitter_session','twitter')->userProfile->socimg);
					$twitFeed = $userhelper->getHomeTimeline();
					$this->apps->assign('twitFeed', $twitFeed);
					
					//Data Twit Session
					$_SESSION['twitter_check'] = 1;
					$_SESSION['tab_check'] = 'tw';
					$_SESSION['twitter_id'] = $this->apps->session->getSession('twitter_session','twitter')->twitter_id;
					$_SESSION['twitPic'] = $this->apps->session->getSession('twitter_session','twitter')->userProfile->socimg;
					$_SESSION['twitFeed'] = json_encode($twitFeed);
				}else if($_SESSION['twitter_expire'] < time())  {
					$_SESSION['twitter_expire'] = time() + (60*3);
					$this->apps->assign('twitter_check',1);
					$this->apps->assign('tab_check','tw');
					$this->apps->assign('twitter_id',$this->apps->session->getSession('twitter_session','twitter')->twitter_id);
					
					$this->apps->assign('twitPic', $this->apps->session->getSession('twitter_session','twitter')->userProfile->socimg);
					$twitFeed = $userhelper->getHomeTimeline();
					$this->apps->assign('twitFeed', $twitFeed);
					
					//Data Twit Session
					$_SESSION['twitter_check'] = 1;
					$_SESSION['tab_check'] = 'tw';
					$_SESSION['twitter_id'] = $this->apps->session->getSession('twitter_session','twitter')->twitter_id;
					$_SESSION['twitPic'] = $this->apps->session->getSession('twitter_session','twitter')->userProfile->socimg;
					$_SESSION['twitFeed'] = json_encode($twitFeed);
				}else{
					$this->apps->assign('twitter_check', $_SESSION['twitter_check']);
					$this->apps->assign('tab_check', $_SESSION['tab_check']);
					$this->apps->assign('twitter_id', $_SESSION['twitter_id']);
					$this->apps->assign('twitPic', $_SESSION['twitPic']);
					$twitFeed = json_decode($_SESSION['twitFeed'],true);
					$this->apps->assign('twitFeed', $twitFeed);
				}
			
			
			$updateTwitStatus = $this->apps->_p('updateTwitStatus');
			$contentPost = $this->apps->_p('status');
			if($updateTwitStatus){
				$updateTwitterStatus = $userhelper->update_tweet($contentPost);
			}
		}else{
			$this->apps->assign('twitURL',$this->apps->session->getSession('twitter_session','twitter')->urlConnect);
		}

		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/social_network.html");
	}

	function getName($id){ 
		$facebookUrl = "https://graph.facebook.com/".$id; 
		$str = file_get_contents($facebookUrl); 
		$result = json_decode($str); 
		return $result->name; 
	}


}


?>