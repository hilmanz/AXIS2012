<?php
class avatar{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
	}

	function main(){
		$this->apps->assign('urlAvatar','');
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/profile/avatar.html');
	
	}


}


?>