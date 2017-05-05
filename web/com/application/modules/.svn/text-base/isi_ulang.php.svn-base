<?php
class isi_ulang extends App{
	
	
	
	function beforeFilter(){
		$this->contentHelper = $this->useHelper('contentHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale',$LOCALE[$this->lid]);
	}
	function main(){
		$this->View->assign('slider_Isi_ulang',$this->setWidgets('sliderIsiUlang'));
		$this->View->assign('medium_banner',$this->setWidgets('medium_banner'));
		$this->View->assign('carousel_banner',$this->setWidgets('carousel_banner'));
		
		//SESSION PAGING,CITY,PROVINCE
			//Page
			if(isset($_SESSION['isiUlangPage']))$start=$_SESSION['isiUlangPage'];
			else $start=0;
			
			$current = (ceil($start)/7)+1;
			
			$this->View->assign('isiUlangPage',$current);
			
			//Province
			if(isset($_SESSION['isiUlangProvince'])){
				$provID=$_SESSION['isiUlangProvince'];
			}else{
				$provID = 37;
			}
			$this->View->assign('provID',$provID);
			// pr($provID);exit;
			//City
			if(isset($_SESSION['isiUlangCity'])){
				$cityID=$_SESSION['isiUlangCity'];
			}else{
				$cityID=73;
			}
			$this->View->assign('cityID',$cityID);
		
		//END -- SESSION PAGING,CITY,PROVINCE
		
		$data = $this->contentHelper->getProvince("topup",$provID);
		$this->View->assign('province',$data);
		
		$city = $this->contentHelper->getCity($provID,'topup',$cityID);
		$this->View->assign('city', $city);
		
		$rs = $this->contentHelper->getOnlineStore(null,$start,7,null,$cityID);
		$this->View->assign('default', $rs);
		
		$this->log('globalAction','isi ulang');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/isi-ulang.html');
	}
	
	function detail(){
		$data = $this->contentHelper->getOnlineStore(null,0,1,$this->_p("id"));
		$this->log('globalAction','detail-lokasi-isiulang');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		$this->log('globalAction',"lokasi_isiulang_detail_{$this->_p("id")}");
		if($data) print json_encode($data[0]);
		else print json_encode(false);
		exit;
	}
	
	function isi_ulang_ajax(){
		$start = $this->_p('start');
		$_SESSION['isiUlangPage']=$start;
		$city = $this->_p('city');
		$rs = $this->contentHelper->getOnlineStore(null,$start,7,null,$city);
		$this->log('globalAction',"lokasi-isiulang-city-{$city}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($rs);exit;
	}
	
	function getCitybyProvince(){
		$province = $this->_p('province');
		$data = $this->contentHelper->getCity($province);
		$this->log('globalAction',"lokasi-isiulang-province-{$province}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		echo json_encode($data);exit;
	}
	
	function getLocationIsiUlang(){
		$_SESSION['isiUlangPage'] = 0;
		$city = intval($this->_p('city'));
		$_SESSION['isiUlangCity'] = $city;
		$province = intval($this->_p('province'));
		$_SESSION['isiUlangProvince'] = $province;
		$locationByCity = $this->contentHelper->getOnlineStore(null,0,7,null,$city);
		$this->log('globalAction',"lokasi-isiulang-lokasi-{$city}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($locationByCity);exit;
	}
	
	// function updateCityID(){
	
		// $arr="SELECT a.city FROM axis_city_reference a
				// LEFT JOIN axis_news_content b ON b.cityName LIKE a.city
				// WHERE 1 GROUP BY a.id";
				
		// $arrRS = $this->fetch($arr,1);
		
		// foreach($arrRS as $val){
			// $city = $val['city'];
			// $upt = "UPDATE axis_news_content
					// SET cityid = (SELECT id FROM axis_city_reference WHERE city LIKE '%{$city}%')
					// WHERE cityName LIKE '%{$city}%'";
			// $this->query($upt);
		// }
	// }
	
	function cek_isi_ulang(){
			$this->View->assign('carousel_promo',$this->setWidgets('carousel_promo'));
		$this->log('globalAction','isi ulang');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/cekpulsa-isiulang.html');
	}
	
	function pulsa_electronic(){
		$this->View->assign('carousel_promo',$this->setWidgets('carousel_promo'));
		$this->log('globalAction','pulsa electronic');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/axisProduct/pulsa-electronic.html');
	}
	
}
?>