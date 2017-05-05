<?php
class promo extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
			$this->assign('mobiledomain', $CONFIG['MOBILE_SITE']);
		$this->assign('assets_mobile', $CONFIG['ASSETS_DOMAIN_MOBILE']);
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		global $CONFIG;
		$promo = $this->contentHelper->getPromo(0,3);
		// pr($promo);exit;
		$this->View->assign('promo',$promo);
		$this->log('globalAction','mobile-promo');
		//return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/promo.html');
		sendRedirect("{$CONFIG['MOBILE_SITE']}promo/hot");
	}
	
	function hot(){
		GLOBAL $CONFIG;
		$id = intval($this->_g("id"));
		if($id != ''){
			$promo= $this->contentHelper->getDetailContent();
			if($this->user) $this->assign('user',$this->user);
			if($promo) {
				$this->View->assign('promo',$promo);
				$this->View->assign('URL',$CONFIG['BASE_DOMAIN_PATH'].'promo/detail/'.$id);
				$this->View->assign('twitURL',$CONFIG['BASE_DOMAIN_PATH'].'promo/detail/'.$id);
			}	
			$this->log('globalAction','mobile-hot-promo');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/promo-hot-detail.html');
		}else{
			$this->log('globalAction','mobile-hot-promo');
			if(intval($this->_p("hot_list")) == '1'){
				$_SESSION['promoPageWeb'] = intval($this->_p("start"));
				$promo = $this->contentHelper->getPromo(intval($this->_p("start")),5);
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header('Content-type: application/json');		
				echo json_encode($promo);exit;
			}else{
				if(isset($_SESSION['promoPageWeb']))$start=intval($_SESSION['promoPageWeb']);
				else $start=0;
				
				$current = (ceil($start)/5)+1;
				
				$this->View->assign('promoPage',$current);
				$promo = $this->contentHelper->getPromo($start,5);
				$this->View->assign('promo',$promo);
				return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/promo-hot.html');
			}
		}
	}
	
	function axisLife(){
		$id = intval($this->_g("id"));
		if($id != ''){
			$promo = $this->contentHelper->getAxisHot(0,1,$id);
			$this->View->assign('promo',$promo);
			$this->log('globalAction','mobile-hot-promo');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/promo-axisLife-detail.html');
		}else{
			$promo = $this->contentHelper->getAxisHot(0,5);
			// pr($promo);exit;
			$this->View->assign('promo',$promo);
			$this->log('globalAction','mobile-hot-promo');
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/promo-axisLife.html');
		}
	}
}
?>