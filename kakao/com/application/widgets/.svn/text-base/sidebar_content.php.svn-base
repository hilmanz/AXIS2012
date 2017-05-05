<?php
class sidebar_content{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		
		if($this->apps->user) {
		$this->apps->View->assign('recent_news',$this->apps->setWidgets('recent_news'));
		$this->apps->View->assign('profile_box',$this->apps->setWidgets('profile_box'));
		}
		else {
		$this->apps->View->assign('socialLogin',$this->apps->setWidgets('socialLogin'));
		$this->apps->View->assign('axis_login',$this->apps->setWidgets('axis_login'));
		}
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/sidebar-content.html");
	
	}


}


?>