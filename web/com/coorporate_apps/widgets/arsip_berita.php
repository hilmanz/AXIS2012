<?php
class arsip_berita{
	
	function __construct($apps=null){		
			$this->apps = $apps;
			global $LOCALE_CORPORATE,$CONFIG;
			$this->apps->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
			$this->apps->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->apps->assign('locale',$LOCALE_CORPORATE[$this->apps->lid]);			
	}

	function main(){
		if(isset($_SESSION['corpBeritaPage']))$start=$_SESSION['corpBeritaPage'];
		else $start=0;
		
		$current = (ceil($start)/4)+1;
		
		$this->apps->View->assign('corpBeritaPage',$current);
		$arsipberita=$this->apps->newsHelper->getNews($start,4);
		$this->apps->assign('arsipberita',$arsipberita);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_COORPORATE .'widgets/arsip_berita.html');
	
	}


}


?>