<?php
class kontak extends App{
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
		
		$data = $this->contentHelper->getProvince();	
		$this->View->assign('province',$data);
		
		$type = $this->contentHelper->getMsgType();
		$this->View->assign('msgType', $type);
		
		$this->log('globalAction','mobile-costumerCare');
		return $this->View->toString(APPLICATION .'/'.MOBILE_APPS.'/costumerCare.html');
	}
	
	function getCitybyProvince(){
		$province = intval($this->_p('province'));
		$data = $this->contentHelper->getCity($province);
		$this->log('globalAction',"lokasi-isiulang-province-{$province}");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');		
		echo json_encode($data);exit;
	}
	
	function saveMessage(){
		$data =  $this->sendMessage();
		$this->log('globalAction','mobile - hubungi kami');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		print(json_encode($data));exit;
	}
	
	function sendMessage(){
		GLOBAL $CONFIG;
		if($this->isUserOnline())  $this->uid = intval($this->user->id);
		else $this->uid = 0;
	
		$name 	 	= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtName'))));
		$email		= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtEmail'))));
		$propinsi	= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtPropinisi'))));
		$telepon	= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtTelepon'))));
		$kota		= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtKota'))));
		$tipe		= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtTipe'))));
		$message	= mysql_escape_string(cleanXSS(strip_tags($this->_p('txtMessage'))));
		$checked 	= mysql_escape_string(cleanXSS(strip_tags($this->_p('checkTXT'))));
		
		if($name == '') return array('message'=>'please fill form','result'=>false);
		if($email == '') return array('message'=>'please fill form','result'=>false);
		if($propinsi == '') return array('message'=>'please fill form','result'=>false);
		if($telepon == '') return array('message'=>'please fill form','result'=>false);
		if($kota == '') return array('message'=>'please fill form','result'=>false);
		if($tipe == '') return array('message'=>'please fill form','result'=>false);
		if($message == '') return array('message'=>'please fill form','result'=>false);
		
		if($checked=='on')$checked=1;
		else $checked=0;
		
		$sql ="INSERT INTO axis_message (nama, 	userid ,	email 	,propinsi 	,kota ,	tipe ,telepon ,	message ,	date_time, 	n_status,syarat) 
		VALUES ('{$name}',{$this->uid},'{$email}','{$propinsi}','{$kota}','{$tipe}','{$telepon}','{$message}',NOW(),0,'{$checked}')
		" ;
			$this->log($sql);
		$this->query($sql);
		if($this->getLastInsertId()){
			
			$to= $CONFIG['EMAIL_AXIS'][0];
			$from = $email;
			$msg = $message;
			$result = $this->sendGlobalMail($to,$from,$msg);
			$this->log($result['message']);
			if($result['result']){
				$sql = "UPDATE axis_message SET n_status=1 WHERE id={$this->getLastInsertId()} LIMIT 1";
				$this->query($sql);
				return $result;
			}else return $result;
			
		}
		return false;
	}
	
	function sendGlobalMail($to,$from,$msg){
		GLOBAL $ENGINE_PATH;
		require_once $ENGINE_PATH."Utility/Mailer.php";
		
		$mail = new Mailer();
		$mail->setRecipient($to);	
		$mail->setSubject('Notification AXIS');
		$mail->setMessage($msg);
		$result = $mail->send();
	
		if($result) return array('message'=>'success send mail','result'=>true);
		else return array('message'=>'error mail setting','result'=>false);
	}
}
?>