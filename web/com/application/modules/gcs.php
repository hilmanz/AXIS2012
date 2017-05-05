<?php
class gcs extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->searchHelper = $this->useHelper('searchHelper');
		$this->sharePostHelper = $this->useHelper('sharePostHelper');
	}
	function main(){
		$result = mysql_escape_string(cleanXSS(strip_tags($this->_p('postGCS'))));
		$this->View->assign('postGCS', $result);
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/home.html');
	}
	
	function search_ajax(){
		echo $this->setWidgets('medium_banner');exit;
	}
	
	function searchcontent(){
		$keywords =  strip_tags($this->_p('q'));
		$this->assign('keywords',$keywords);
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		$result = $this->searchHelper->searchit(null,10,null,$keywords);
		if($result){
			$this->assign('contentlist', $result['content']);
	
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'gcs/search-result.html');
		}else return $this->View->toString(TEMPLATE_DOMAIN_WEB .'gcs/search-result-notfound.html');
		
		
	}
	
}
?>