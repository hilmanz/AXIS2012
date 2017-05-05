<?php
class bookmarkWidget{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			$this->bookmarkHelper = $this->apps->useHelper('bookmarkHelper');
	}

	function main(){
		$this->apps->assign('bookmark',$this->bookmarkHelper->getBookmark());
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/profile/bookmarkPage.html');
	
	}


}


?>