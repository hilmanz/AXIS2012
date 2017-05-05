<?php
class gaulbanget2 extends App{
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){		
		
	
		$this->log('globalAction','gaulbanget2-page-promotional');
		$this->assign("promotionalpage","gaulbanget2");

		print $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/gaulbanget2.html');
		exit;
	}
	
	
}
?>