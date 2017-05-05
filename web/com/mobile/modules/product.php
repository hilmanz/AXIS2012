<?php
class product extends App{
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
		
		$this->log('globalAction','mobile-productAxis');
		return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/product.html');
	}
	
	function tab(){
		$id = intval($this->_g("id"));
		$type = strip_tags($this->_g("type"));
		$this->assign('type',$type);
		if($id != ''){
			$product = $this->contentHelper->getAxisProduct($type,10,$id);
			if(!$product) {
				header("location:{$CONFIG['MOBILE_SITE']}404.html");
				exit;
			}
			$this->log('globalAction',$product[0]['title']);
			$this->View->assign('product',$product);
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/product-tab-detail.html');
		}else{
			$product = $this->contentHelper->getAxisProduct($type);
			if(!$product) {
				header("location:{$CONFIG['MOBILE_SITE']}404.html");
				exit;
			}
			$this->View->assign('product',$product);
			$this->log('globalAction',"axis-produk-{$type}");
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/product-tab.html');
		}
	}

	function article(){
		$id = intval($this->_g("id"));
		
		if($id != 0){
			$product = $this->contentHelper->getDetailContent();
			
			if(!$product) {
				header("location:{$CONFIG['MOBILE_SITE']}404.html");
				exit;
			}			
			$this->log('globalAction',$product['title']);
			$this->View->assign('product',$product);
			return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/product-tab-detail-article.html');
		}else{
			header("location:{$CONFIG['MOBILE_SITE']}404.html");
				exit;
		}
	}
	

}
?>