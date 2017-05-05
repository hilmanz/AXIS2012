<?php	
class cdm_service {
	var $API;

	
	function __construct($API=null){
		$this->API = $API;
		// $this->API->is_valid_access_token(strip_tags($this->API->_g('access_token')));
		
		$this->url = "http://10.9.11.173:8080/provisioning.php";
	}
	
	function saveDataFromCDM(){
		global $CONFIG;
		$outdir = "{$CONFIG['BASE_DOMAIN']}public_assets/cdm/";
		$trashdir = "{$CONFIG['BASE_DOMAIN']}public_assets/cdm/notused/";
		
		$file = strip_tags($this->API->_p('file'));
		$myContent = file_get_contents($file);
		// $file = curlGet($file);
		$filename = basename($file);
		if(file_put_contents($outdir.$filename, utf8_encode($myContent))){ 
		// if(move_uploaded_file($file,$outdir.$filename)){
				//send to unarchieveDataCDM
				$this->unarchieveDataCDM();
				$files = glob($outdir."*.*",GLOB_BRACE);
				// pr($files);
				foreach($files as $val){
					rename($val,$trashdir.basename($val));
					$arrFile[] = basename($val);
				}
			
			//else return false
		}else {
			pr($file);
			return false;
		}
		
		
	}
	
	function saveDataFromUploader(){
		global $CONFIG;
		$outdir = "{$CONFIG['BASE_DOMAIN']}public_assets/cdm/";
		$trashdir = "{$CONFIG['BASE_DOMAIN']}public_assets/cdm/notused/";
		
		if(!isset($_FILES)) return false;
		
		$file = $_FILES['uploader'];
		if($file['error']!=0) return false;
		
		if(array_key_exists('name',$file)) $filename = $file['name'];
		else return false;
		if(move_uploaded_file($file['tmp_name'],$outdir.$filename)){
				//send to unarchieveDataCDM
				$this->unarchieveDataCDM();
				$files = glob($outdir."*.*",GLOB_BRACE);
				// pr($files);
				foreach($files as $val){
					rename($val,$trashdir.basename($val));
					$arrFile[] = basename($val);
				}
			
		
		}else {
			pr($file);
			return false;
		}
		
		
	}
	
	function checkUserDataToCDM(){
		// username	String		User login
		// password	String		User password
		// msisdn	String	Using International format, starts with 62, ex : 6283812345	Phone number
		// handset	String		Handset Brand, in case of Automatic provisioning, fill value with Auto
		// handset_type	String		Handset Type, in case of Automatic provisioning, fill value with Auto
		// feature	String		Feature setting, example : gprs, mms. To send all setting, fill value with All 
		// language	String	0 : Bahasa, 1 : English	Language selection, default value will be Bahasa.
	
		//cek user device data in DB
			$authdata['username'] = 'newportal';
			$authdata['password'] = 'newportal123';
			
			//testing
			$authdata['msisdn'] = '083891122801';
			$authdata['feature'] = 'gprs';
			$authdata['language'] = 0;
			
			// $authdata['msisdn'] = strip_tags($this->API->_p('phonenumber'));
			// $authdata['feature'] = strip_tags($this->API->_p('feature'));
			// $authdata['language'] = strip_tags(intval($this->API->_p('language')));
			
			//if has data in db
			$data['device'] = 'ACE';
			$data['type'] =  'C900';
			
			// $data['device'] = strip_tags($this->API->_p('device'));
			// $data['type'] = strip_tags($this->API->_p('devicetype'));
				$devicedata = $this->checkDeviceOnDb($data);
				if(!$devicedata) return false;
			
			//testing
			$authdata['handset'] = 'ACE';
			$authdata['handset_type'] = 'C900';
			
			// $authdata['handset'] = $devicedata['device'];
			// $authdata['handset_type'] = $devicedata['type'];
		
			$rsData = $this->sendToAPICDM($authdata);
			if(!$rsData) return false;
			if($rsData['result']=="FAILED") return false;
			
			//else return false
			pr($rsData);exit;
		return true;
	}
	
	
	function sendToAPICDM($authdata=null){
		
		if($authdata==null) return false;
		$url = $this->url;
		// $url = 'http://localhost/axis2012/trunk/web/service/?service=cdm&m=testPOST';
		$param = $authdata;
		$data = curlPOST($url,$param);
		return $data;
	}
	function testPOST(){
		return strip_tags($this->API->_p('name'));
	}
	
	function uncompress($srcName, $dstName) {
		$sfp = gzopen($srcName, "rb");
		$fp = fopen($dstName, "w");

		while ($string = gzread($sfp, 4096)) {
		fwrite($fp ,$string, strlen($string));
		}
		gzclose($sfp);
		fclose($fp);
	}
	
	function unarchieveDataCDM(){
		//unzip it
			global $CONFIG;
			set_time_limit(0) ;
			$outdir = "{$CONFIG['BASE_DOMAIN']}public_assets/cdm/";
			//get all file with ext tar.gz , .txt
			$files = glob($outdir . "*.tar*" );
			$devicefile = $outdir."new_device_".date("YmdHis").".txt";
			if(array_key_exists(0,$files)) $zipfile = $files[0];
			else return false;
			$infile = $this->uncompress($zipfile,$devicefile);
			// exit;
			//read file
			$urlfile = $devicefile;
			//device|model,model,model				
				$file = fopen($urlfile,"r+");
				
				if ($file) {
				   $rawData = explode("\n", fread($file, filesize($urlfile)));
				}
										
				//close file txt yang di buka tadi
				fclose($file);
		
		if(!$rawData) return false;
		foreach($rawData as $key => $val){
			if($key>2)$arrData[] = $val;
		}
		if(!$arrData) return false;
		//if success
			
			foreach($arrData as $val){
				// 17VEE|DSN100,F200,G6,V1000,V60,V80
				$device = explode("|",$val);
				if($device){					
					if(array_key_exists(1,$device)) $devicetype = explode(",",$device[1]);
					if($devicetype){
						$arrDevice[] = array('device'=>$device[0],'type'=>$devicetype);
					}
				}
			}
			
			if(!$arrDevice) return false;
			//check device on DB 
			$n=1;
			$nq=0;
			
			foreach($arrDevice as $val){
				//if has device continue
					//save device data to db
				
				foreach($val['type'] as $types){
					$data['queue'] = $n;
					$data['device'] = $val['device'];
					$data['type'] = $types;
					
					pr($data);
										
					if($nq>500) {
						$nq=0;
						sleep(10);
					}else $nq++;
					$n++;
					
					if($this->checkDeviceOnDb($data)) continue;
					else $this->saveDataToDb($data);
				}
				
			}
				
		return true;
	}
	
	function checkDeviceOnDb($arrData=null){
		if($arrData==null) return false;
		$sql = " SELECT count(*) total FROM axis_device_setting WHERE device=\"{$arrData['device']}\" AND type=\"{$arrData['type']}\" LIMIT 2 ";
		$qData = $this->API->fetch($sql);
		if($qData['total']>=1) return true;
		return false;
	}
	
	function saveDataToDb($arrData=null){
		if($arrData==null) return false;		
		$sql = " INSERT INTO axis_device_setting (device,type,created_date, n_status) VALUES (\"{$arrData['device']}\",\"{$arrData['type']}\",NOW(),1) ";
		$this->API->query($sql);
		return true;
	}
	

	
		
}
?>
