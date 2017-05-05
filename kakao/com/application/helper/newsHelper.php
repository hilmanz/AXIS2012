<?php

class newsHelper {
	
	
	function __construct($apps){
	global $logger,$CONFIG;
	$this->logger = $logger;
	$this->apps = $apps;
	if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
	else $this->uid = false;
	
	}
	
	function sendMessage(){

		
		$name 	 	= mysql_escape_string(cleanXSS($this->apps->_p('txtName')));
		$email		= mysql_escape_string(cleanXSS($this->apps->_p('txtEmail')));
		$propinsi	= mysql_escape_string(cleanXSS($this->apps->_p('txtPropinisi')));
		$telepon	= mysql_escape_string(cleanXSS($this->apps->_p('txtTelepon')));
		$kota		= mysql_escape_string(cleanXSS($this->apps->_p('txtKota')));
		$tipe		= mysql_escape_string(cleanXSS($this->apps->_p('txtTipe')));
		$message	= mysql_escape_string(cleanXSS($this->apps->_p('txtMessage')));
		
		$sql ="INSERT INTO axis_message (nama, 	userid ,	email 	,propinsi 	,kota ,	tipe ,telepon ,	message ,	date_time, 	n_status) 
		VALUES ('{$name}','{$this->uid}','{$email}','{$propinsi}','{$kota}','{$tipe}','{$telepon}','{$message}',NOW(),0)
		" ;
	
		$this->apps->query($sql);
		if($this->apps->getLastInsertId()){
			
			$to= 'bummi@kana.co.id';
			$from = $email;
			$msg = $message;
			$result = $this->sendGlobalMail($to,$from,$msg);
			if($result['result']){
				$sql = "UPDATE axis_message SET n_status=1 WHERE id={$this->apps->getLastInsertId()} LIMIT 1";
				$this->apps->query($sql);
				return $result;
			}else return $result;
			
		}
		return false;
	}
	
	function sendGlobalMail($to,$from,$msg){
		
		// $to =  'bummi@kana.co.id';
		// $from = 'noreply@tangkapberkahaxis.com';
		
		
		// $flag='<br />Kalau kamu ada kendala atau pertanyaan, kamu bisa email ke : hemat@axisworld.co.id';
	
		GLOBAL $ENGINE_PATH;
		require_once $ENGINE_PATH."Utility/Mailer.php";
		// if(file_exists($ENGINE_PATH."Utility/Mailer.php"))	print_r('ada');exit;		
		$mail = new Mailer();
		$mail->setRecipient($to);	
		$mail->setSubject('Notification AXIS');
		$mail->setMessage($msg);
		$result = $mail->send();
	
		if($result) return array('message'=>'success send mail','result'=>true);
		else return array('message'=>'error mail setting','result'=>false);
	}
	
	
	
}