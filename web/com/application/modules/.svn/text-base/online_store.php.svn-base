<?php
class online_store extends App{
	
	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		$this->View->assign('isi_pulsa',$this->setWidgets('isi_pulsa'));
		$this->View->assign('slider_store',$this->setWidgets('slider_store'));
		$this->View->assign('mcp',$this->contentHelper->getMContentPreference());
		// pr($this->contentHelper->getMContentPreference());exit;
		$this->log('globalAction','online store');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/online-store.html');
	}
	
	function detail(){
		global $CONFIG;
		$qData = $this->contentHelper->getDetailContent();
		$this->log('article',$this->Request->getParam('id'));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
			$this->assign('content',$qData);
			$this->assign('URL',$CONFIG['BASE_DOMAIN'].'index.php?page%3Donline_store%26act%3Ddetail%26id%3D'.$this->Request->getParam('id'));
			$this->assign('twitURL',$CONFIG['BASE_DOMAIN'].'index.php?page=online_store&act=detail&id='.$this->Request->getParam('id'));
		}
		$this->View->assign('store_terkait',$this->setWidgets('store_terkait'));
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		$this->log('globalAction','online store detail');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/online-store-detail.html');
	}

}
?>