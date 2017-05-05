<?php
class tentang_axis extends App{
	
	
	
	function beforeFilter(){
			global $LOCALE_CORPORATE,$CONFIG;
			$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
			$this->blogHelper =  $this->useHelper('blogHelper');
			$this->layananHelper =  $this->useHelper('layananHelper');
			$act = $this->_g('act');
			$this->View->assign('act',$act);
	}
	function main(){
		
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-tentang-axis');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/tentang-axis.html');
	}
	
	function tanggung_jawab(){
		
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-tanggung-jawab');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/tanggung-jawab.html');
	
	}
	
	
	function media_siaran(){
		
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-media-siaran');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/media-siaran-pers.html');
	
	}
	
	
	function kualitas_layanan(){
		$dataLayanan = $this->layananHelper->getLayanan();
		$data = $this->layananHelper->getLatestLayanan();
		if(is_array($dataLayanan)){
			foreach($dataLayanan as $n=>$v){
				$dataLayanan[$n]['title'] = str_replace("PERIODE","",$dataLayanan[$n]['title']);
			}
		}
		$this->View->assign('content',$data);
		$this->View->assign('layanan',$dataLayanan);
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-kualitas-layanan');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/kualitas-layanan.html');
	
	}
	
	
	function grup_kami(){
		
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-grup-kami');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/grup-kami.html');
	
	}
	
	function karyawan_dan_managemen(){
		$this->View->assign('recent_blog',$this->setWidgets('recent_blog'));
		$this->log('globalAction','coorporate-karyawan-manajemen');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/karyawan.html');
	
	
	}
	
}
?>