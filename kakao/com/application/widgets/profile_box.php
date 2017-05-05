<?php
class profile_box{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			$global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		$userAttribute =  $this->apps->userHelper->getUserAttribute();
		$this->apps->assign('userAttribute',$userAttribute);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/profile_box.html");
	
	}


}


?>