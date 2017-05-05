<?php 

class karirHelper {

	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(isset($_SESSION['lid'])) $this->lid = intval($_SESSION['lid']);
		else $this->lid = 1;
	}
	
	function sendCV(){
		GLOBAL $CONFIG, $LOCALE;
		$posisi = mysql_escape_string(cleanXSS($this->apps->_p('jobPosition')));
		if($posisi == '') $posisi = "Others";
		if(isset($_FILES['fileCV']['name'])){
			$name = $_FILES['fileCV']['name'];
			$path = $CONFIG['PUBLIC_ASSET']."cv/";
			$allowedExts = array('zip', 'rar', 'doc', 'docx', 'xls', 'xlsx', 'pdf');
			$extension = end(explode(".", $_FILES["fileCV"]["name"]));			
				if(
					($_FILES['fileCV']['type'] == 'application/rar') ||
					($_FILES['fileCV']['type'] == 'application/zip') ||				
					($_FILES['fileCV']['type'] == 'application/msword') ||				
					($_FILES['fileCV']['type'] == 'application/vnd.ms-excel') ||				
					($_FILES['fileCV']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') ||				
					($_FILES['fileCV']['type'] == 'application/x-gzip') ||				
					($_FILES['fileCV']['type'] == 'application/pdf') &&
					in_array($extension, $allowedExts)
				){
					if ($_FILES["fileCV"]["size"] < 200000){
						if(move_uploaded_file($_FILES['fileCV']['tmp_name'], $path.$name)){
							$qry = "INSERT INTO tbl_submit_cv (id, cv_name, tgl_submit) VALUES (null,'".mysql_escape_string(cleanXSS($name))."',NOW())";
							$rs = $this->apps->query($qry);
							//pr($rs);
							if($rs){
							$result = $this->sendingCV($name, $posisi);
							}
							
							// @unlink($path.$name);
						}else{
							$result =  $LOCALE[$this->lid]['cv']['err1'];
						}
					}else{
						$result = $LOCALE[$this->lid]['cv']['err2'];
					}
				}else{
					$result = $LOCALE[$this->lid]['cv']['err3'];
				}
		}else{
			$result =  $LOCALE[$this->lid]['cv']['err4'];
		}
		
		$this->logger->log("sending cv status => ".$result);
		
		echo $result;exit;
	}
	
	function sendingCV($cv, $position="others"){
		GLOBAL $ENGINE_PATH, $CONFIG, $LOCALE;
		require_once $ENGINE_PATH."Utility/PHPMailer/class.phpmailer.php";

		$mail = new PHPMailer();
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = $CONFIG['EMAIL_SMTP_HOST'];  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $CONFIG['EMAIL_SMTP_USER'];  // SMTP username
		$mail->Password = $CONFIG['EMAIL_SMTP_PASSWORD']; // SMTP password

		$mail->From = $CONFIG['EMAIL_FROM_DEFAULT'];
		$mail->FromName = "Life in AXIS";
		
		$mail->AddAddress($CONFIG['EMAIL_AXIS']['upload_cv']);

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->AddAttachment($CONFIG['PUBLIC_ASSET']."cv/".$cv);         // add attachments
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = "Career Inquiry";
		$mail->Body    = "Please see the attached application for my desired position.";
		$mail->AltBody = "Please see the attached application for my desired position.";

		if(!$mail->Send())
		{
			// echo $LOCALE[$this->lid]['cv']['err1']."<p>";
		   echo $LOCALE[$this->lid]['cv']['scd']."<p>";
		   // echo "Mailer Error: " . $mail->ErrorInfo;
		   exit;
		}

		echo $LOCALE[$this->lid]['cv']['scd'];
	}
	
	function getContentCareer(){
		
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=2
					ORDER BY posted_date DESC
					";
			$qData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			return $qData;
	}
	
	function getContentCareerById(){
		$careerId = intval($this->apps->_g('id'));
		if($careerId) $qCareer = "AND parentid = {$careerId} ";
		else  return false;
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=2
					{$qCareer}
					ORDER BY posted_date DESC LIMIT 1
					";
			$qData = $this->apps->fetch($sql);
			$this->logger->log($sql);
			return $qData;
	}
	
}	

?>

