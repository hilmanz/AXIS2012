<?php
class customer_care extends App{
	
	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->newsHelper = $this->useHelper('newsHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		$this->log('globalAction','customer care');
		$data = $this->contentHelper->getProvince();	
		$this->View->assign('province',$data);
		$type = $this->contentHelper->getMsgType();
		$this->View->assign('msgType', $type);
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/customer-care.html');
	}
	
	function saveMessage(){
		$_captcha = strip_tags($this->_p('captcha'));
		$_valid = (md5($_captcha) == $_SESSION['captcha']) ? true : false;
		$_SESSION['captcha'] = "bed" . rand(00000000,99999999) . "bed";
		
		if ($_valid) {
			$data =  $this->newsHelper->sendMessage();
			$data['captcha'] = true;
		} else {
			$data= array('message'=>'captcha failed','result'=>false,'captcha'=>false);
		}
		$this->log('globalAction','corporate - hubungi kami');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($data));exit;
	}

}
?>