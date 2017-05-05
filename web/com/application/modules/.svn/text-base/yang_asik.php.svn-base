<?php
class yang_asik extends App{
	
	
	
	function beforeFilter(){
		
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$product = $this->contentHelper->getAxisProduct("yangasik");
		// pr($product);
		$this->View->assign('product',$product);
		$this->View->assign('type',"yangasik");
		$this->View->assign('slider_produk',$this->setWidgets('sliderProduk'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		// print_r($this);exit;
		$this->log('globalAction','axis-yang-asik');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/yang-asik.html');
	}
	
}
?>