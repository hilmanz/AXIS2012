<?php
class petasitus extends App{	
	function beforeFilter(){
		global $CONFIG,$LOCALE_CORPORATE;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('localecoorporate',$LOCALE_CORPORATE[$this->lid]);
		$this->assign('coorporate_base_path',$CONFIG['COORPORATE_DOMAIN']);
	}
	
	function main(){
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));	
		$this->log('globalAction','sitemap');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/sitemap.html');
	}
}
?>