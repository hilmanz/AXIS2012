<?php
class kenapaAxis extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
			$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		$favCount = $this->contentHelper->getFavoriteUrl(1);
		$this->View->assign('fav',$favCount['1']);
		$this->log('globalAction','mobile-kenapaAxis');
		return $this->View->toString(APPLICATION .'/mobile/kenapaAxis.html');
	}
}
?>