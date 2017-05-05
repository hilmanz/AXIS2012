<?php
class sidebar_axis_life{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		
		if($this->apps->user) {
			$this->apps->View->assign('axis_new',$this->apps->setWidgets('axis_new'));
			$this->apps->View->assign('social_network',$this->apps->setWidgets('social_network'));
			$this->apps->View->assign('profile_box',$this->apps->setWidgets('profile_box'));
		}
		else {
		$this->apps->View->assign('socialLogin',$this->apps->setWidgets('socialLogin'));
		$this->apps->View->assign('axis_login',$this->apps->setWidgets('axis_login'));
		}
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/sidebar-axis-life.html");
	
	}


}


?>