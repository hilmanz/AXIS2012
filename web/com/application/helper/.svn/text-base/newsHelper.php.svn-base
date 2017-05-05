<?php

class newsHelper {
	
	
	function __construct($apps){
	global $logger,$CONFIG;
	$this->logger = $logger;
	$this->apps = $apps;
	if($this->apps->isUserOnline())  {
			if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
	}
	else $this->uid = 0;
	
	}
	
	function sendMessage(){
		global $CONFIG;
		
		$name 	 	= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtName'))));
		$email		= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtEmail'))));
		$propinsi	= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtPropinisi'))));
		$telepon	= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtTelepon'))));
		$kota		= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtKota'))));
		$tipe		= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtTipe'))));
		$message	= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('txtMessage'))));
		$checked 	= mysql_escape_string(cleanXSS(strip_tags($this->apps->_p('checkTXT'))));
		
		if($name == '') return array('message'=>'please fill form','result'=>false);
		if($email == '') return array('message'=>'please fill form','result'=>false);
		if($propinsi == '') return array('message'=>'please fill form','result'=>false);
		if($telepon == '') return array('message'=>'please fill form','result'=>false);
		if($kota == '') return array('message'=>'please fill form','result'=>false);
		if($tipe == '') return array('message'=>'please fill form','result'=>false);
		if($message == '') return array('message'=>'please fill form','result'=>false);
		// if($checked == '') return array('message'=>'please fill form','result'=>false);
		if($checked=='on')$checked=1;
		else $checked=0;
		
		$sql ="INSERT INTO axis_message (nama, 	userid ,	email 	,propinsi 	,kota ,	tipe ,telepon ,	message ,	date_time, 	n_status,syarat) 
		VALUES ('{$name}',{$this->uid},'{$email}','{$propinsi}','{$kota}','{$tipe}','{$telepon}','{$message}',NOW(),0,'{$checked}')
		" ;
			$this->logger->log($sql);
		$this->apps->query($sql);
		if($this->apps->getLastInsertId()){
			
			$to= $CONFIG['EMAIL_AXIS']['web'];
			$from = $email;
			$msg = $message;
			$result = $this->sendGlobalMail($name,$to,$from,$msg, $telepon, $checked,$propinsi,$kota,$tipe);
			$this->logger->log($result['message']);
			if($result['result']){
				$sql = "UPDATE axis_message SET n_status=1 WHERE id={$this->apps->getLastInsertId()} LIMIT 1";
				$this->apps->query($sql);
				return $result;
			}else return $result;
			
		}
		return false;
	}
	
	function sendGlobalMail($name,$to,$from,$msg,$telepon,$checked,$propinsi,$kota,$tipe){
		GLOBAL $ENGINE_PATH, $CONFIG, $LOCALE;
		require_once $ENGINE_PATH."Utility/PHPMailer/class.phpmailer.php";
		
		//get Province
		$prov = "SELECT province FROM axis_province_reference WHERE id={$propinsi} LIMIT 1";
		$province = $this->apps->fetch($prov);
		
		//get City
		$city = "SELECT city FROM axis_city_reference WHERE id={$kota} LIMIT 1";
		$cityName = $this->apps->fetch($city);
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = $CONFIG['EMAIL_SMTP_HOST'];  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $CONFIG['EMAIL_SMTP_USER'];  // SMTP username
		$mail->Password = $CONFIG['EMAIL_SMTP_PASSWORD']; // SMTP password

		$mail->From = $from;
		$mail->FromName = $from;
		$mail->AddAddress($to);

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = '[Web Feedback] '.$telepon.' '.$from.' '.date("d/m/Y h:i:s A");
		if($checked==1){
			$mail->Body    = 'Name: '.$name.'<br />Email: '.$from.'<br /> Phone Number: '.$telepon.'<br /> Province: '.$province['province'].'<br /> City: '.$cityName['city'].'<br /> Question type: '.$tipe.'<br /> Message: '.$msg.'<br /><br />Saya bersedia dihubungi melalui telepon';
		}else{
			$mail->Body    = 'Name: '.$name.'<br />Email: '.$from.'<br /> Phone Number: '.$telepon.'<br /> Province: '.$province['province'].'<br /> City: '.$cityName['city'].'<br /> Question type: '.$tipe.'<br /> Message: '.$msg;
		}
		$mail->AltBody = $msg;
		$result = $mail->Send();
	
		if($result) return array('message'=>'success send mail','result'=>true);
		else return array('message'=>'error mail setting','result'=>false);
	}
	
	
	
}