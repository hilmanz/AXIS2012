<?php
class sliderIsiUlang{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE;
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);	
	}

	function main(){

		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/slider-isiulang.html");
	
	}


}


?>