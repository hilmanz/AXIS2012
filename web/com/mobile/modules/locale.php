<?php
class locale extends App{
	
	function main(){
		global $CONFIG,$DOMAIN;
		$locale = $this->_g('country');
		$nexturl = $this->_g('nexturl');
		$arrNexurl = unserialize(urldecode64($nexturl));
		// pr($arrNexurl);exit;
		if(!$arrNexurl) {
			header("location:{$CONFIG['MOBILE_SITE']}404.html");
			exit;
			}
		if(array_key_exists('basedomain',$arrNexurl)){
			if($arrNexurl['basedomain']!=$CONFIG['MOBILE_SITE']) {
				header("location:{$CONFIG['MOBILE_SITE']}404.html");
				exit;
			}
		}else {
			header("location:{$CONFIG['MOBILE_SITE']}404.html");
			exit;
			}
		$nexturl = $arrNexurl['nexturl'];
		// pr($CONFIG['BASE_DOMAIN_PATH'].$nexturl);exit;
		if($locale=='')$locale=1;
		$_SESSION['lid'] = $locale;		
		$this->log('globalAction','change-mobile-locale-'.$locale);
		header("location:{$nexturl}");
		exit;
	}
}
?>