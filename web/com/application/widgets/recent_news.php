<?php
class recent_news{
	
	function __construct($apps=null){		
			$this->apps = $apps;	
			global $LOCALE,$CONFIG;
			$this->apps->assign('basedomain', $CONFIG['BASE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
			$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
		if(!$this->apps->user) $qDataContent = $this->apps->contentHelper->getPublicContent(null,3);
		else $qDataContent = $this->apps->contentHelper->getContent(null,3);
		$this->apps->assign('renews',$qDataContent);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/recent_news.html");
	
	}


}


?>