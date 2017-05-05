<?php
class ask_axis extends App{
		
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->newsHelper = $this->useHelper('newsHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['WAP_DOMAIN']);
		$this->assign('basepath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WAP']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->log('globalAction','wap customer care');
		$data = $this->contentHelper->getProvince();	
		$this->View->assign('province',$data);
		$type = $this->contentHelper->getMsgType();
		$this->View->assign('msgType', $type);
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/ask.html');
	}
	
	function saveMessage(){
	
		$rs =  $this->newsHelper->sendMessage();
		$data = $this->contentHelper->getProvince();	
		$this->View->assign('province',$data);
		$type = $this->contentHelper->getMsgType();
		$this->View->assign('msgType', $type);
		$this->View->assign('result', $rs);
		$this->log('globalAction','wap customer care submit');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/ask.html');
	}

}
?>