<?php
class coverage extends App{
	function beforeFilter(){
		global $LOCALE,$CONFIG,$GPLUS;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->assign('developerkey', $GPLUS['developer_key']);

	}
	function main(){
		if(isset($_SESSION['coveragePage']))$start=intval($_SESSION['coveragePage']);
		else $start=0;
		
		$current = (ceil($start)/3)+1;
		
		$this->View->assign('coveragePage',$current);
	
		if(isset($_SESSION['coverageProvince'])){
			$lokasiID=$_SESSION['coverageProvince'];
		}else{
			$lokasiID=37;
		}

		$lokasi = $this->contentHelper->getProvince('coverage',$lokasiID);
		$this->View->assign('province2',$lokasi);
	
		$data = $this->contentHelper->getCoverageArea($start,3,null,$lokasiID);
		$datamaps = $this->contentHelper->getCoverageAreaMaps();
		$this->View->assign('datamaps',json_encode($datamaps));
		$this->View->assign('coverage',$data);
		$this->log('globalAction','coverage');
		
		$data = $this->contentHelper->getProvince('coveragemap',null);
		
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		
		$this->View->assign('province',$data);
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/coverage.html');
	}
	
	function detail(){
		$data = $this->contentHelper->getCoverageArea(0,1,intval($this->_p("id")), intval($this->_p('provinceID')));
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		$this->log('globalAction',"coverage_detail_{$this->_p("id")}");
		if($data) print json_encode($data[0]);
		else print json_encode(false);
		exit;
	}
	
	function coverage_ajax(){
		$start = intval($this->_p('start'));
		$_SESSION['coveragePage'] = $start;
		$provinceID = intval($this->_p('provinceID'));
		$_SESSION['coverageProvince'] = $provinceID;
		$rs = $data = $this->contentHelper->getCoverageArea($start, 3, null, $provinceID);
		$this->log('globalAction',"coverage_ajax_{$provinceID}_{$start}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($rs);exit;
	}
	
	function coverage_area_maps_ajax(){
		$provinceid = intval($this->_p('provinceid'));
		$datamaps = $this->contentHelper->getCoverageAreaMaps();
		$this->log('globalAction',"coverage_area_maps_ajax_{$provinceid}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($datamaps);exit;
	}

}
?>