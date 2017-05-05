<?php
class device_settings extends App{
	
	
	
	function beforeFilter(){
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->cdmHelper = $this->useHelper('cdmHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
		
	}
	function main(){
		global $LOCALE;
		$product = $this->contentHelper->getAxisProduct("bantuan");
		// pr($product);
		$this->View->assign('product',$product);
		$this->View->assign('type',$LOCALE[$this->lid]['footnav']['bantuan']);
		$this->View->assign('slider_produk',$this->setWidgets('sliderProduk'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		// print_r($this);exit;
		$this->log('globalAction','axis-bantuan');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/bantuan.html');
	}
	
	function checkUserDataToCDM(){
	
		$data = $this->cdmHelper->checkUserDataToCDM();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');	
		$this->log('globalAction','check device ');		
		print json_encode($data);exit;
	}
	
}
?>