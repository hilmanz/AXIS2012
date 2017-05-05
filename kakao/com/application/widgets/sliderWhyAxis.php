<?php
class sliderWhyAxis{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);	
	}

	function main(){
		$page = $this->apps->_g('page');
		if($page=='')$page='home';
		$this->apps->assign('banner',$this->apps->contentHelper->getBanner($page));
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/slider-whyaxis.html");
	
	}


}


?>