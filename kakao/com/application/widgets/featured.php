<?php
class featured{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		$page = $this->apps->_g('page');
		if($page=='')$page='home';
		$this->apps->assign('banner',$this->apps->contentHelper->getAxisLatest());
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/featured.html");
	
	}


}


?>