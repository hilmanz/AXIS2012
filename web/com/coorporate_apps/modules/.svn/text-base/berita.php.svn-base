<?php
class berita extends App{
	
	
	function beforeFilter(){
			global $LOCALE_CORPORATE,$CONFIG;
			$this->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
			$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
			$this->newsHelper =  $this->useHelper('newsHelper');
			$this->lifeInAxisHelper =  $this->useHelper('lifeInAxisHelper');
			$this->blogHelper =  $this->useHelper('blogHelper');
			$this->detailcontent =$this->newsHelper->getLatestNews();
	}
	
	function getDetailContent(){
		return $this->detailcontent;
	}
	
	function main(){
	
		
		$this->assign('news',$this->detailcontent);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->View->assign('arsip_berita',$this->setWidgets('arsip_berita'));
		$this->log('globalAction','coorporate-berita');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/berita.html');
	}
	
	function detail(){
	

		$this->assign('news',$this->detailcontent);
		$this->View->assign('life_in_axis_box',$this->setWidgets('life_in_axis_box'));
		$this->View->assign('arsip_berita',$this->setWidgets('arsip_berita'));
		$this->log('globalAction','coorporate-berita');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/berita.html');
	}
	
	function arsip_berita_ajax(){
		$start = $this->_p('start');
		$_SESSION['corpBeritaPage'] = $start;
		$data = $this->newsHelper->getNews($start, 4);
		$this->log('globalAction','coorporate-arsip-berita-paging');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($data);exit;
	}
	
}
?>