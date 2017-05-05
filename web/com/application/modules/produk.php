<?php
class produk extends App{
	
	
	
	function beforeFilter(){
		
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->View->assign('slider_produk',$this->setWidgets('sliderProduk'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		// print_r($this);exit;
		$this->log('globalAction','axis-produk');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/produk.html');
	}
	
	function detail(){
		
		$product = $this->contentHelper->getAxisProduct();
		// pr($product);
		if($product){
		$this->View->assign('product',$product);
		$this->View->assign('type',strip_tags($this->_g("type")));
		$this->View->assign('slider_produk',$this->setWidgets('sliderProduk'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		// print_r($this);exit;
		$this->log('globalAction','axis-produk-detail');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/produk-detail.html');
		}else {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
		}
	
	}
	
	function article(){
		global $CONFIG;
		$qData = $this->contentHelper->getDetailContent();
		$this->log('article','product_article_'.$this->Request->getParam('id'));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
			$this->assign('content',$qData);
			$this->assign('URL',$CONFIG['BASE_DOMAIN'].'?page=product&act=article&id='.intval($this->Request->getParam('id')));
			$this->assign('twitURL',$CONFIG['BASE_DOMAIN'].'?page=product&act=article&id='.intval($this->Request->getParam('id')));
		}else {
			header("location:{$CONFIG['BASE_DOMAIN']}404.html");
			exit;
		}		
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_promo'));

		$this->log('globalAction','axis-product-article');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/product-article-detail.html');
	}
	
	function product_special(){
		//title,whats_product
		global $CONFIG;
		$whats_product = strip_tags($this->_g('whats_product')) ;
		/*
		$token = $this->_g('token') ;
		if($token){
			$data = unserialize(urldecode64($token));
			if(array_key_exists('templates',$data)) {
				$whats_product = $data['templates'];
			}else{
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
		
		if(file_exists("../templates/".TEMPLATE_DOMAIN_WEB ."/static_locale/{$country}/{$whats_product}.html")) {
			$title = strip_tags($this->_g('title')) ;
			$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
			$this->View->assign('whats_product',$whats_product);
			$this->View->assign('title',$title);
			$this->log('globalAction',$whats_product);
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/product-special.html');
		}else{
				header("location:{$CONFIG['BASE_DOMAIN']}404.html");
				exit;
		}
	}
}
?>