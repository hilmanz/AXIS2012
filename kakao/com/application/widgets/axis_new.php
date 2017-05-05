<?php
class axis_new{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		$qDataContent = $this->apps->contentHelper->getAxisLatest();
		$this->apps->assign('latest',$qDataContent);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/axis_new.html");
	
	}


}


?>