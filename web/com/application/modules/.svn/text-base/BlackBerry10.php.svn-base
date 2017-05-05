<?php
class BlackBerry10 extends App{
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){		
		
		$targettime = $this->getTime();
		$this->log('globalAction','bb10-page-promotional');
		$this->assign("promotionalpage","bb10");
		$this->assign("targettime",$targettime);
		print $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/promotional.html');
		exit;
	}
	
	function getTime(){
		$LAUNCHING_DATE = strtotime('2013-03-15 00:00:01');
		$launchdate = array('day'=>intval(date("d",$LAUNCHING_DATE)),
			'month'=>intval(date("m",$LAUNCHING_DATE)),
			'year'=>intval(date("Y",$LAUNCHING_DATE)),
			'hour'=>intval(date("H",$LAUNCHING_DATE)),
			'min'=>intval(date("i",$LAUNCHING_DATE)),
			'sec'=>intval(date("s",$LAUNCHING_DATE))
			);
		return json_encode($launchdate);
					
	}
}
?>