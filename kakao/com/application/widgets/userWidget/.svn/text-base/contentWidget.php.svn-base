<?php
class contentWidget{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			$this->contentHelper = $this->apps->useHelper('contentHelper');
	}

	function main(){
		$this->apps->assign('contentUser',$this->contentHelper->getContent());
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/profile/contentUser.html');
	
	}


}


?>