<?php
class social_network{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		global $FB, $ENGINE_PATH, $GPLUS, $GPLUSBOT;
		require_once $ENGINE_PATH."functions.php";
		
		$this->GPlusHelper = $this->apps->useHelper('GPlusHelper');
		
		if($this->GPlusHelper->isLogin()){
			$this->apps->assign('gplus_check',1);
			//AXIS Gplus
			$gplus_query_url_default = "https://www.googleapis.com/plus/v1/people/".$GPLUSBOT['target_id']."/activities/public?maxResults=1&fields=items(actor(displayName%2Cid%2Cimage)%2Cobject%2Cverb%2Cpublished%2Cid)&key=".$GPLUS['developer_key'];
			$gplus_query_result_default = file_get_contents($gplus_query_url_default);
			$plus_query_obj_default = json_decode($gplus_query_result_default, true);
			$this->apps->assign('gplusDefault',$plus_query_obj_default['items'][0]);
			
			$gplusID = $this->apps->session->getSession('gplus_session','gplus')->userProfile->id;
			$gplus_query_url = "https://www.googleapis.com/plus/v1/people/".$gplusID."/activities/public?maxResults=10&fields=items(actor(displayName%2Cid%2Cimage)%2Cobject%2Cverb%2Cpublished%2Cid)&key=".$GPLUS['developer_key'];
			$gplus_query_result = file_get_contents($gplus_query_url);
			$plus_query_obj = json_decode($gplus_query_result, true);
			$this->apps->assign('gplusList',$plus_query_obj['items']);
		}else{
			$connectUrl = $this->GPlusHelper->getLoginUrl();
			$this->apps->assign('gplusURL',$connectUrl);
		}
		
		if(isset($this->apps->session->getSession('facebook_session','facebook')->ac)){
			$fb = $this->apps->session->getSession('facebook_session','facebook')->ac;
			$fbID =  $this->apps->session->getSession('facebook_session','facebook')->user;
			$this->apps->assign('at', $fb);
			$this->apps->assign('fbID',$fbID);
			
			
			$fql_query_url = 'https://graph.facebook.com/'
				. '/fql?q=SELECT+post_id,actor_id,updated_time,message+FROM+stream+WHERE+source_id=me()'
				. '&access_token=' . $fb;
			  $fql_query_result = file_get_contents($fql_query_url);
			  $fql_query_obj = json_decode($fql_query_result, true);
			  
			$this->apps->assign('fbUser',$this->apps->session->getSession('facebook_session','facebook')->userProfile->first_name);

			$fql_query_url2 = 'https://graph.facebook.com/186172338083633/feed?limit=1&access_token='.$fb;
			  $fql_query_result2 = file_get_contents($fql_query_url2);
			  $fql_query_obj2 = json_decode($fql_query_result2, true);
				
			if(isset($fql_query_obj['error']['code']) == '190'){
				$this->apps->assign('fbURL',@$this->apps->session->getSession('facebook_session','facebook')->urlConnect);
			}else{
				$this->apps->assign('facebook_check',1);
				$this->apps->assign('fbList',$fql_query_obj['data']);
				$this->apps->assign('fbAXIS',$fql_query_obj2['data']['0']);
			}
			
		}else{
			$this->apps->assign('fbURL',@$this->apps->session->getSession('facebook_session','facebook')->urlConnect);
		}
		

		$twitter_check = @$this->apps->session->getSession('twitter_session','twitter')->login;
		if($twitter_check){
			$this->apps->assign('twitter_check',$twitter_check);
			$this->apps->assign('twitter_id',$this->apps->session->getSession('twitter_session','twitter')->twitter_id);
			$updateTwitStatus = $this->apps->_p('updateTwitStatus');
			$contentPost = $this->apps->_p('status');
			if($updateTwitStatus){
				$updateTwitterStatus = $this->apps->twitterHelper->update_tweet($contentPost);
			}
		}else{
			$this->apps->assign('twitURL',@$this->apps->session->getSession('twitter_session','twitter')->urlConnect);
		}

		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/social_network.html");
	}


}


?>