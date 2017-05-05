<?php
class slider_hot_news{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		$page = $this->apps->_g('page');
		if($page=='')$page='home';
		$this->apps->assign('banner',$this->apps->contentHelper->getAxisHot());
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/slider_hot_news.html");
	
	}


}


?>