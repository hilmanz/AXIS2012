<?php
class promo extends App{
	
	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['WAP_DOMAIN']);
		$this->assign('basepath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WAP']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){		
		$promo = $this->contentHelper->getPromo();
		$this->View->assign('promo',$promo);
		// print_r($promo);
		$this->log('globalAction','promo-lagi-in');

		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/promo-category.html');
	}
	
	function detail(){
		global $CONFIG;
		
		$qData = $this->contentHelper->getDetailContent();
		$this->log('article',intval($this->Request->getParam('id')));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
			$this->assign('data',$qData);
		}		
		
		// $this->log('globalAction','axis-promo-detail');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/promo-detail.html');
	
	}
	
	
}
?>