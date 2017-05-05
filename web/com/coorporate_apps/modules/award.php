<?php
class award extends App{
	
	
	
	function beforeFilter(){

		global $LOCALE_CORPORATE,$CONFIG;
		$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
		$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
		
	}
	function main(){
		
		$this->View->assign('slider',$this->setWidgets('slider'));
		$this->log('globalAction','coorporate-home');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/home.html');
	}
	
}
?>