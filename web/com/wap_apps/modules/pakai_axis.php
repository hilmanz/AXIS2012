<?php
class pakai_axis extends App{
	
	
	
	function beforeFilter(){
			global $LOCALE,$CONFIG;
			$this->assign('basedomain', $CONFIG['WAP_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WAP']);
			$this->assign('basepath', $CONFIG['BASE_DOMAIN_PATH']);
			$this->assign('locale',$LOCALE[$this->lid]);
		
	}
	function main(){
		
		
		$this->log('globalAction','wap-pakai_axis');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'application/pakai-axis.html');
	}
	
	
	
}
?>