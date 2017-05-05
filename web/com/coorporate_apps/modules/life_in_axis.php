<?php
class life_in_axis extends App{
	
	function beforeFilter(){
		global $LOCALE_CORPORATE,$CONFIG;
		$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
		$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
		$this->blogHelper =  $this->useHelper('blogHelper');
		$this->karirHelper = $this->useHelper('karirHelper');
		$this->galeriHelper = $this->useHelper('galeriHelper');
		$this->divisiHelper = $this->useHelper('divisiHelper');
		
		$act = $this->_g('act');
		$this->View->assign('act',$act);
	}
	function main(){
		
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-seputar_perusahaan');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/life-in-axis.html');
	}
	
	function kegiatan_ekstrakurikuler(){
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-kegiatan-ekstrakurikuler');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/kegiatan-ekstrakurikuler.html');
	}
	
	function meet_our_people(){
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-meet-our-people');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/meet-our-people.html');
	}
	
	function peranan_divisi(){
		global $CONFIG;
		$data = $this->divisiHelper->getBlogCoorporate();
		
		//a little hack for english version
		if($this->lid==2){
			foreach($data as $n=>$v){
				if(strtolower($v['title'])=="lainnya"){
					$data[$n]['title'] = "Others";
				}
			}
		}
		$this->View->assign('content',$data);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-peranan-divisi');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/peranan-divisi.html');
	}
	
	function galeri(){
		global $CONFIG;
		$data = $this->galeriHelper->getGallery();
		$this->View->assign('content',$data);
		$this->View->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-galeri');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/galeri.html');
	}
	
	function galeri_ajax(){
		$start = $this->_p('start');
		$data = $this->galeriHelper->getGallery($start,18);
		$this->log('globalAction','coorporate-galeri-paging');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($data);exit;
	}
	
	function karir(){
		$data = $this->karirHelper->getContentCareer();
		$this->View->assign('content',$data);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-karir');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/karir.html');
	
	}
	
	function karir_detail(){
		// pr($_SESSION);
		$data = $this->karirHelper->getContentCareerById();
		$dataKarir = $this->karirHelper->getContentCareer();
		$this->View->assign('content',$data);
		$this->View->assign('karirList',$dataKarir);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-karir');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/karir-detail.html');
	
	}
	
	function submit_cv(){
		$dataKarir = $this->karirHelper->getContentCareer();
		$this->View->assign('karirList',$dataKarir);
		if($this->_p('submitCV') == 1){
			$this->log('globalAction','coorporate-submit-cv');
			echo $this->karirHelper->sendCV();exit;
		}else{
			$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
			$this->log('globalAction','coorporate-list-karir');
			return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/submit-cv.html');
		}
	}
}
?>