<?php
class gaulbanget1 extends App{

	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	
	function main(){		
		

		$this->log('globalAction','gaulbanget1-page-promotional');
		$this->assign("promotionalpage","gaulbanget1");
	
		print $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/gaulbanget1.html');
		exit;
	}
	
	
}
?>