<?php
class produk extends App{
	
	
	
	function beforeFilter(){
		
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['WAP_DOMAIN']);
		$this->assign('basepath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WAP']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		
		$this->log('globalAction','axis-wap-produk');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/category.html');
	}
	
	function tab(){
	
		$product = $this->contentHelper->getAxisProduct();
		$this->View->assign('product',$product);
		$this->View->assign('type',strip_tags($this->_g("type")));
		$this->log('globalAction','axis-wap-produk');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/sub-category.html');
	
	}
	
	function detail(){
		$cid = intval($this->_g('id'));
		$product = $this->contentHelper->getAxisProduct();		
		$this->View->assign('data',$product);
		$this->View->assign('type',strip_tags($this->_g("type")));
		// print_r($product);exit;
		$this->log('globalAction','axis-wap-produk-detail');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/detail.html');
	
	}
	
	function article(){
		global $CONFIG;
		$qData = $this->contentHelper->getDetailContent();
		$this->log('article','wap_product_article_'.$this->Request->getParam('id'));
		if($this->user) $this->assign('user',$this->user);
		if($qData) {
			$this->assign('content',$qData);
			$this->assign('URL',$CONFIG['WAP_DOMAIN'].'?page=product&act=article&id='.$this->Request->getParam('id'));
			$this->assign('twitURL',$CONFIG['WAP_DOMAIN'].'?page=product&act=article&id='.$this->Request->getParam('id'));
		}		

		$this->log('globalAction','axis-wap-product-article');
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/product-article-detail.html');
	
	}
	
	function product_special(){
		//title,whats_product
		$whats_product = strip_tags($this->_g('whats_product')) ;
		$title = strip_tags($this->_g('title')) ;
		$this->View->assign('whats_product',$whats_product);
		$this->View->assign('title',$title);
		$this->log('globalAction',$whats_product);
		return $this->View->toString(TEMPLATE_DOMAIN_WAP .'/application/product-special.html');
	}
}
?>