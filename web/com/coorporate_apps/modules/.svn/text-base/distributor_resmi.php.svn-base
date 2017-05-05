<?php
class distributor_resmi extends App{
		
	function beforeFilter(){
			global $LOCALE_CORPORATE,$CONFIG;
			$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
			$this->distributorHelper =  $this->useHelper('distributorHelper');
			$this->newsHelper =  $this->useHelper('newsHelper');
	}
	function main(){
		$this->View->assign('recent_news',$this->setWidgets('recent_news'));
		
		$data = $this->distributorHelper->getProvince("default");
		$this->View->assign('province',$data);
		
		$city = $this->distributorHelper->getCity(3,'default');
		$this->View->assign('city', $city);
		
		$rs = $this->distributorHelper->getDistributor(null,0,7,null,13);
		$this->View->assign('default', $rs);
		
		$this->log('globalAction','coorporate-distributor-resmi');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/distributor-resmi.html');
	}
	function getCitybyProvince(){
		$province = $this->_p('province');
		$data = $this->distributorHelper->getCity($province);
		$this->log('globalAction','coorporate-get-distributor-city');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		echo json_encode($data);exit;
	}
	function distributor_paging_ajax(){
		$start = $this->_p('start');
		$city = $this->_p('city');
		$rs = $this->distributorHelper->getDistributor(null,$start,7,null,$city);
		$this->log('globalAction','coorporate-distributor-paging');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($rs);exit;
	}
	function distributor_ajax(){
		$start = $this->_p('start');
		$city = $this->_p('city');
		$rs = $this->distributorHelper->getDistributor(null,0,7,null,$city);
		$this->log('globalAction','coorporate-distributor');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($rs);exit;
	}
	
	
	
}
?>