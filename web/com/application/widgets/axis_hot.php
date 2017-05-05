<?php
class axis_hot{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE,$CONFIG;
			$this->apps->assign('basedomain', $CONFIG['BASE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		 
		$qDataContent = $this->apps->contentHelper->getAxisHot();
		$this->apps->assign('content',$qDataContent);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/axis_hot.html");
	
	}


}


?>