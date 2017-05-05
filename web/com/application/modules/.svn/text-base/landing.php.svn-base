<?php
class landing extends App{
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){		
		global $CONFIG;
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
		
	}
	
	function page(){		
		global $CONFIG;
		$type = strip_tags($this->_g('type')) ;
		
		if($this->lid==1) $country = "ind";
		if($this->lid==2) $country = "eng";
		
		if(file_exists("../templates/".TEMPLATE_DOMAIN_WEB ."/static_locale/{$country}/landing-page-{$type}.html")) {
			$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
			$this->View->assign('type',$type);
			$this->log('globalAction',"landing page {$type}");
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/landing.html');
		}else{
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
		}
	}
}
?>