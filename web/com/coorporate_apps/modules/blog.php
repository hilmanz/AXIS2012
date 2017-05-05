<?php
class blog extends App{
		
	function beforeFilter(){
			global $LOCALE_CORPORATE,$CONFIG;
			$this->assign('base_web_path',$CONFIG['BASE_DOMAIN']);
			$this->assign('basedomain', $CONFIG['COORPORATE_DOMAIN']);
			$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_COORPORATE']);
			$this->assign('locale',$LOCALE_CORPORATE[$this->lid]);
			$this->blogHelper =  $this->useHelper('blogHelper');
			$this->newsHelper =  $this->useHelper('newsHelper');
			$this->detailcontent =$this->blogHelper->getLatestBlog();
	}
	
	function getDetailContent(){
		return $this->detailcontent;
	}
	
	function main(){
	
		$this->assign('blog',$this->detailcontent);
		$this->View->assign('arsip_blog',$this->setWidgets('arsip_blog'));
		$this->View->assign('recent_news',$this->setWidgets('recent_news'));
		$this->log('globalAction','coorporate-blog');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/blog.html');
	}
	
	function detail(){
	
		$this->assign('blog',$this->detailcontent);
		$this->View->assign('arsip_blog',$this->setWidgets('arsip_blog'));
		$this->View->assign('recent_news',$this->setWidgets('recent_news'));
		$this->log('globalAction','coorporate-blog-detail');
		return $this->View->toString(TEMPLATE_DOMAIN_COORPORATE .'application/blog.html');
	}
	
	function arsip_blog_ajax(){
		$start = $this->_p('start');
		$data = $this->blogHelper->getBlog($start, 4);
		$this->log('globalAction','coorporate-blog-paging');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($data);exit;
	}
	
}
?>