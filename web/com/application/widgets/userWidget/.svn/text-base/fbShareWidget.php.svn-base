<?php


class fbShareWidget{
	
	function __construct($apps=null){		
			$this->apps = $apps;
			$this->facebookSession = $this->apps->session->getSession('facebook_session','facebook');
	}

	function main(){
			global $FB, $ENGINE_PATH;
			require_once $ENGINE_PATH."functions.php";
			
			
			$ac = $this->facebookSession->ac;
			$urlGet = curlGet('https://graph.facebook.com/me/feed?access_token='.$ac);
			// pr($ac);
			$this->apps->assign('fbFeeds',$urlGet);
			$this->apps->assign('appID',$FB['appID']);
			return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'/widgets/profile/fbShare.html');
	}


}


?>