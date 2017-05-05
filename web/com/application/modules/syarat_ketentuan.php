<?php
class syarat_ketentuan extends App{	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	
	function main(){
		$this->log('globalAction','syarat_ketentuan');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/syarat_ketentuan.html');
	}	
}
?>