<?php
class international extends App{
	
	
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$product = $this->contentHelper->getAxisProduct("international");
		$this->View->assign('product',$product);
		$this->View->assign('type',"international");
		$this->View->assign('slider_produk',$this->setWidgets('sliderProduk'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		// print_r($this);exit;
		$this->log('globalAction','axis-international');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/international.html');
	}

	function countryList(){
		$countryList = $this->contentHelper->getRoamingCountry();
		$this->log('globalAction','axis-country-list');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($countryList);exit;
	}
	
	function roamingData(){
		$country = $this->_p('countryName');
		$roamingData = $this->contentHelper->getRoamingData($country);
		$this->log('globalAction',"axis-country-roaming_{$country}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($roamingData);exit;
	}
}
?>