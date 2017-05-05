<?php
class home extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG,$detect;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
		
		
		if($detect->isTablet()){
			$this->assign('mobiletype',1);
		}else{
			$this->assign('mobiletype',2);
		}
		
		
	}
	function main(){
		$slider = $this->contentHelper->getBanner('home','header',1,3);
		// pr($slider);exit;
		$this->assign('banner', $slider);
		$this->log('globalAction','mobile-home');
		return $this->View->toString(APPLICATION .'/mobile/home.html');
	}
}
?>