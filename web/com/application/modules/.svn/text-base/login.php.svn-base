<?php
class login extends App{
		
	function beforeFilter(){
		$this->loginNonFormHelper = $this->useHelper('loginNonFormHelper');
		$this->socialMediaHelper = $this->useHelper('socialMediaHelper');
		$this->twitterHelper = $this->useHelper('twitterHelper');
	}
	function main(){
		global $CONFIG,$logger;
		$basedomain = $CONFIG['BASE_DOMAIN'];
		$this->assign('basedomain',$basedomain);
		$this->log('globalAction','LOGIN');
		$res = $this->loginNonFormHelper->loginin();
		$tab = '#';
		if($res){	
			if(isset($this->session->getSession('facebook_session','facebook')->user)){
				$tab = '#bnettab0';
			}
			if(isset($this->session->getSession('gplus_session','gplus')->user)){
				$tab = '#bnettab2';
			}
			if($this->twitterHelper->getUserLogin()){
				$tab = '#bnettab1';
			}
			$this->assign('tab',$tab);
			sendRedirect("{$basedomain}{$this->userpage}{$tab}");
		}else{
			sendRedirect("{$basedomain}{$this->userpage}");
		}
			
		return $this->View->toString(TEMPLATE_DOMAIN_WEB . '/login_message.html');
	}
	
}
?>