<?php
class relasi extends App{
	
	
	
	function beforeFilter(){
			global $LOCALE_CORPORATE,$CONFIG;
			$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
	}
	function main(){


		$this->log('globalAction','coorporate-relasi');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/relasi.html');
	}
	
}
?>