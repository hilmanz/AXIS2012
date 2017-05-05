<?php
class slider{
	
	function __construct($apps=null){		
			$this->apps = $apps;
			global $LOCALE_CORPORATE,$CONFIG;
			$this->apps->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->apps->assign('locale',$LOCALE_CORPORATE[$this->apps->lid]);
	}

	function main(){
		
		return $this->apps->View->toString(TEMPLATE_DOMAIN_COORPORATE .'widgets/slider.html');
	
	}


}


?>