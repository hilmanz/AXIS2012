<?php
class kenapaAxis extends App{
	
	
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->View->assign('slider_whyaxis',$this->setWidgets('sliderWhyAxis'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$favCount = $this->contentHelper->getFavoriteUrl(1);
		$this->View->assign('fav',$favCount['1']);
		
		// print_r($this);exit;
		$this->log('globalAction','kenapa-axis');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/kenapa-axis.html');
	}

}
?>