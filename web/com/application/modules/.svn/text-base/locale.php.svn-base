<?php
class locale extends App{
	
	function main(){
		global $CONFIG;
		$locale = $this->_g('country');
		$nexturl = $this->_g('nexturl');
		$arrNexurl = unserialize(urldecode64($nexturl));
		
		if(!$arrNexurl) {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
			}
		if(array_key_exists('basedomain',$arrNexurl)){
			if($arrNexurl['basedomain']!=$CONFIG['BASE_DOMAIN']) {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
			}
		}else {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
			}
		$nexturl = $arrNexurl['nexturl'];
		// pr($CONFIG['BASE_DOMAIN'].$nexturl);exit;
		if($locale=='')$locale=1;
		$_SESSION['lid'] = $locale;		
		$this->log('globalAction','change-locale-'.$locale);
		header("location:{$nexturl}");
		exit;
	}
	
		


}
?>