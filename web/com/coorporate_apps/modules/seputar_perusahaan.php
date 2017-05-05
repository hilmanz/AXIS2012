<?php
class seputar_perusahaan extends App{
	
	function beforeFilter(){
		global $LOCALE_CORPORATE,$CONFIG;
		$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
		$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
	}
	function main(){


		$this->log('globalAction','coorporate-seputar_perusahaan');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/seputar-perusahaan.html');
	}
	
	function interkoneksi(){
		$this->log('globalAction','coorporate-interkoneksi');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/interkoneksi.html');
	}
	
	function lembar_fakta(){
		$this->log('globalAction','coorporate-lembar-fakta');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/lembar-fakta.html');
	}
}
?>