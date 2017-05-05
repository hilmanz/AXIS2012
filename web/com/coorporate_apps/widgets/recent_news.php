<?php
class recent_news{
	
	function __construct($apps=null){		
			$this->apps = $apps;
			global $LOCALE_CORPORATE,$CONFIG;
			$this->apps->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
			$this->apps->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->apps->assign('locale',$LOCALE_CORPORATE[$this->apps->lid]);
	}

	function main(){
		$arsipberita=$this->apps->newsHelper->getNews(0,1);
		$this->apps->assign('arsipberita',$arsipberita);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_COORPORATE .'widgets/recent_news.html');
	
	}


}


?>