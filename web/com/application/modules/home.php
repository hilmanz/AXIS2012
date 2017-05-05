<?php
class home extends App{
	
	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
	}
	function main(){
		// $this->View->assign('isi_pulsa',$this->setWidgets('isi_pulsa'));
		$this->View->assign('slider_default',$this->setWidgets('slider_default'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('slider_hot_news',$this->setWidgets('slider_hot_news'));
		$this->View->assign('featured',$this->setWidgets('featured'));
		// print_r($this);exit;
		$this->log('globalAction','home');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/home.html');
	}
	
}
?>