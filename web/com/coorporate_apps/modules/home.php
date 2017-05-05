<?php
class home extends App{
	
	
	
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
	
	function gcs(){
		$result = $this->_p('postGCS');
		$this->View->assign('postGCS', $result);
		$this->log('globalAction','coorporate-search-404');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/home.html');
	}
	
}
?>