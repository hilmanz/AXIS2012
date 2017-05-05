<?php
class promo extends App{
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){		
		$this->View->assign('slider_default',$this->setWidgets('slider_default'));
		
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		
		if(isset($_SESSION['promoPage']))$start=$_SESSION['promoPage'];
		else $start=0;
		
		$current = (ceil($start)/6)+1;
		
		$this->View->assign('promoPage',$current);
		$this->View->assign('promo',$this->contentHelper->getPromo($start,6));
		
		$this->log('globalAction','promo-lagi-in');

		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/promo.html');
	}
	
	function detail(){
		global $CONFIG;
		$qData = $this->contentHelper->getDetailContent();
		$this->log('article',intval($this->Request->getParam('id')));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
			$this->assign('content',$qData);
			$this->assign('URL',$CONFIG['BASE_DOMAIN'].'index.php?page%3Dpromo%26act%3Ddetail%26id%3D'.intval($this->Request->getParam('id')));
			$this->assign('twitURL',$CONFIG['BASE_DOMAIN'].'index.php?page=promo&act=detail&id='.intval($this->Request->getParam('id')));
		}else {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
		}		
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_promo'));

		// $this->log('globalAction','axis-promo-detail');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/promo-detail.html');
	
	}
	
	function promo_ajax(){
		$start = intval($this->_p('start'));
		$_SESSION['promoPage'] = intval($this->_p("start"));
		$rs = $this->contentHelper->getPromo($start,6);
		echo json_encode($rs);exit;
	}
	
	
	function hot_promo(){
		global $CONFIG;
		$whats_promo = strip_tags($this->_g('whats_promo')) ;
		/*
		$token = $this->_g('token') ;
		if($token){
			$data = unserialize(urldecode64($token));
			if(array_key_exists('templates',$data)) {
				$whats_promo = $data['templates'];
			}
			else{
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
			}
		}else{
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
			}
		*/
		if($this->lid==1) $country = "ind";
		if($this->lid==2) $country = "eng";
		
		if(file_exists("../templates/".TEMPLATE_DOMAIN_WEB ."/static_locale/{$country}/{$whats_promo}.html")) {
			$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
			$this->View->assign('whats_promo',$whats_promo);
			$this->log('globalAction',$whats_promo);
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/promo-external.html');
		}else{
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
		}
	}
}
?>