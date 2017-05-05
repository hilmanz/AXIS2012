<?php
class userAttribute{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
		
	}

	function main(){
		$userAttribute =  $this->apps->userHelper->getUserAttribute();
		$this->apps->assign('userProfile',$this->apps->userHelper->getUserProfile());
		$this->apps->assign('userAttribute',$userAttribute);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/profile/userAttribute.html');
	
	}


}


?>