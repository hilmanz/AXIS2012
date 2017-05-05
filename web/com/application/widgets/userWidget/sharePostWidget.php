<?php
class sharePostWidget{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
	}

	function main(){
			return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/profile/posting.html');
	}


}


?>