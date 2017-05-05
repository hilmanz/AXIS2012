<?php
class gcs extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		$result = mysql_escape_string(cleanXSS(strip_tags($this->_p('postGCS'))));
		$this->View->assign('postGCS', $result);
		return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/home.html');
	}
	
}
?>