<?php
class hubungi_kami extends App{
	
	
	
	function beforeFilter(){
		global $LOCALE_CORPORATE,$CONFIG;
		$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
		$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
		$this->newsHelper = $this->useHelper('newsHelper');
		$this->lifeInAxisHelper = $this->useHelper('lifeInAxisHelper');
		$this->distributorHelper =  $this->useHelper('distributorHelper');
	}
	
	function main(){		
		$this->View->assign('life_in_axis_box',$this->setWidgets('life_in_axis_box'));
		$this->View->assign('msgType', $this->newsHelper->getMsgType());
		$data = $this->distributorHelper->getProvince();
		$this->View->assign('province',$data);
		
		$sendmail = intval($this->_p('sendingEmail'));
		if($sendmail==1){
			$_captcha = strip_tags($this->_p('captcha'));
			$_valid = (md5($_captcha) == $_SESSION['captcha']) ? true : false;
			$_SESSION['captcha'] = "bed" . rand(00000000,99999999) . "bed";
			
			if ($_valid) {
				$data =  $this->newsHelper->sendMessage();
			} else {
				$data= "captcha failed";
			}
			$this->log('globalAction','kirim pesan customer care');
			$this->View->assign('msg', $data);
		}else{
			$this->log('globalAction','coorporate-hubungi-kami');
		}
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/hubungi-kami.html');
	}
}
?>