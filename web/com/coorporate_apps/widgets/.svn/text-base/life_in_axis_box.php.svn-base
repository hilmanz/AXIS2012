<?php
class life_in_axis_box{
	
	function __construct($apps=null){		
			$this->apps = $apps;
			global $LOCALE_CORPORATE,$CONFIG;
			$this->apps->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
			$this->apps->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->apps->assign('locale',$LOCALE_CORPORATE[$this->apps->lid]);
			$this->apps->assign('base_url_path',$CONFIG['BASE_DOMAIN']);
	}

	function main(){
		//$content=$this->apps->lifeInAxisHelper->getContent(0,1);
		//$this->apps->assign('content',$content);
		
		return $this->apps->View->toString(TEMPLATE_DOMAIN_COORPORATE .'widgets/life-in-axis-box.html');
	
	}


}


?>