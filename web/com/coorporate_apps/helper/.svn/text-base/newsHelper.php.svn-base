<?php 

class newsHelper {

	var $uid;
		
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		// if($this->apps->isUserOnline())  $this->uid = $this->apps->user->id;
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;
		
		$this->server = $CONFIG['VIEW_ON'];
	
	}
	
	
	
	function getNews($start=0,$limit =4){
		
		
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=1
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			$qData = $this->apps->fetch($sql,1);
			
			$row ="	SELECT COUNT(id) as total_rows FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=1
					";
			
			$qRow = $this->apps->fetch($row);
			
			foreach($qData as $n=>$v){
				$qData[$n]['posted_date'] = date("d-m-Y",strtotime($qData[$n]['posted_date']));
			}
			
			if($qRow['total_rows'] != '0'){		
				$qData[0]['total_rows'] = $qRow['total_rows'];
			}
			// pr($qData);
			$this->logger->log($sql);
			if(!$qData) return false;
		
			return $qData;
		

	}
	
	function getLatestNews($limit=1){
	
			if($this->apps->_g('page')=='berita') $cid = intval($this->apps->_g('id'));
			else $cid = false;
			
			if($cid) $qIdContent = " AND parentid = {$cid} ";
			else $qIdContent = "";
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=1
					{$qIdContent}
					ORDER BY posted_date DESC LIMIT {$limit}
					";
			$qData = $this->apps->fetch($sql);
			
			$qData['posted_date'] = date("d-m-Y",strtotime($qData['posted_date']));
			
			// pr($sql);exit;
			$this->logger->log($sql);
			if(!$qData) return false;
		
			return $qData;
	
	}
	
	function sendMessage(){
		global $CONFIG;
		
		$name 	 	= mysql_escape_string(cleanXSS($this->apps->_p('txtName')));
		$email		= mysql_escape_string(cleanXSS($this->apps->_p('txtEmail')));
		$propinsi	= mysql_escape_string(cleanXSS($this->apps->_p('txtPropinsi')));
		$telepon	= mysql_escape_string(cleanXSS($this->apps->_p('txtTelepon')));
		$kota		= mysql_escape_string(cleanXSS($this->apps->_p('txtKota')));
		$tipe		= intval(mysql_escape_string(cleanXSS($this->apps->_p('txtTipe'))));
		$message	= mysql_escape_string(cleanXSS($this->apps->_p('txtMessage')));
		$checkbox	= mysql_escape_string(cleanXSS($this->apps->_p('checkPhone')));
		if($checkbox == 'on') $checkbox = 1;
		else $checkbox = 0;
		
		if(
			$name != 'Name' && $name != 'Nama' && $name != '' &&
			$email != 'Email' && $email != '' &&
			$propinsi != '' &&
			$telepon != '' && $telepon != 'Phone Number' && $telepon != 'No. Tlp' &&
			$kota != '' &&
			$message != '' && $message != 'Pesan' && $message != 'Message' &&
			$tipe != ''
		){	
			$sql ="INSERT INTO axis_message (nama, 	userid ,	email 	,propinsi 	,kota ,	tipe ,telepon ,	message , syarat, date_time, 	n_status) 
			VALUES ('{$name}','{$this->uid}','{$email}','{$propinsi}','{$kota}','{$tipe}','{$telepon}','{$message}',{$checkbox},NOW(),0)
			" ;
			$this->apps->query($sql);
			$this->logger->log($sql);
			$sq = "SELECT * FROM axis_message_type WHERE web_type = 2 AND id = {$tipe} LIMIT 1";
			$rs = $this->apps->fetch($sq);
			
			if($this->apps->getLastInsertId()){
				
				$to= $CONFIG['EMAIL_AXIS']['corporate'];
				$from = $email;
				$msg = $message;
				$result = $this->sendGlobalMail($name,$to,$from,$msg,$telepon,$checkbox,$propinsi,$kota,$rs['type']);
				if($result['result']){
					$sql = "UPDATE axis_message SET n_status=1 WHERE id={$this->apps->getLastInsertId()} LIMIT 1";
					$this->apps->query($sql);
					return "terkirim";
				}else {
					//wait for smtp done
					// return "tidak";
					return "terkirim";
				}
				
			}
		}else{
			return "tidak";
		}
	}
	
	function sendGlobalMail($name,$to,$from,$msg,$telepon,$checkbox,$propinsi,$kota,$tipe){
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

		$mail->Subject = '[Corporate Feedback] '.$telepon.' '.$from.' '.date("d/m/Y h:i:s A");
		if($checkbox==1){
			$mail->Body    = 'Name: '.$name.'<br />Email: '.$from.'<br /> Phone Number: '.$telepon.'<br /> Province: '.$province['province'].'<br /> City: '.$cityName['city'].'<br /> Question type: '.$tipe.'<br /> Message: '.$msg.'<br /><br />Saya bersedia dihubungi melalui telepon';
		}else{
			$mail->Body    = 'Name: '.$name.'<br />Email: '.$from.'<br /> Phone Number: '.$telepon.'<br /> Province: '.$province['province'].'<br /> City: '.$cityName['city'].'<br /> Question type: '.$tipe.'<br /> Message: '.$msg;
		}
		$mail->AltBody = $msg;
		$result = $mail->Send();
		
		$this->logger->log($result);
		if($result) return array('message'=>'success send mail','result'=>true);
		else return array('message'=>'error mail setting','result'=>false);
	}
	
	function getMsgType(){
		$sql = "SELECT * FROM axis_message_type WHERE web_type=2 AND lid={$this->lid}";
		$rs = $this->apps->fetch($sql, 1);
		$this->logger->log($sql);
		return $rs;
	}
}	
?>

