<?php
class locale extends App{
	
	function main(){
		global $CONFIG,$DOMAIN;
		$locale = $this->_g('country');
		$nexturl = $this->_g('nexturl');
		$arrNexurl = unserialize(urldecode64($nexturl));
		
		if(!$arrNexurl) {
			header("location:{$CONFIG['WAP_DOMAIN']}404.html");
			exit;
			}
		if(array_key_exists('basedomain',$arrNexurl)){
			if($arrNexurl['basedomain']!=$CONFIG['WAP_DOMAIN']) {
				header("location:{$CONFIG['WAP_DOMAIN']}404.html");
				exit;
			}
		}else {
			header("location:{$CONFIG['WAP_DOMAIN']}404.html");
			exit;
			}
		$nexturl = $arrNexurl['nexturl'];
		// pr($nexturl);exit;
		if($locale=='')$locale=1;
		$_SESSION['lid'] = $locale;		
		$this->log('globalAction','change-locale-'.$locale);
		header("location:{$nexturl}");
		exit;
	}
	
		


}
?>