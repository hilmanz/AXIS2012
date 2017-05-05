<?php
class login extends App{
		
	function beforeFilter(){	
			global $CONFIG;
		$this->loginNonFormHelper = $this->useHelper('loginNonFormHelper');
		$this->socialMediaHelper = $this->useHelper('socialMediaHelper');
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
	}
	function main(){
		global $CONFIG;
		$this->log('globalAction','login');
		$res = $this->loginNonFormHelper->loginin();
		if($res){
			$this->assign("msg","login-in.. please wait");
			$this->assign("link","{$CONFIG['MOBILE_SITE']}myworld");
			sendRedirect("{$CONFIG['MOBILE_SITE']}myworld");
		}else{
			$this->assign("msg","gagal login");
			$this->assign("link","{$CONFIG['MOBILE_SITE']}myworld");
			sendRedirect("{$CONFIG['MOBILE_SITE']}myworld");
		}
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB . '/message.html');
	}
	
}
?>