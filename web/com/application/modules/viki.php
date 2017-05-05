<?php
class viki extends App{
	
	
	
	function beforeFilter(){
			global $LOCALE,$CONFIG;
			$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
			$this->vikiHelper = $this->useHelper("VikiHelper");
	}
	function main(){
		if($this->_g('vType')){
			$vikiData = $this->vikiHelper->movies($this->_g('vType'));
			$this->assign('viki_data',$vikiData);
		}
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/viki/vikiDisplay.html');
	}
		
	
}
?>