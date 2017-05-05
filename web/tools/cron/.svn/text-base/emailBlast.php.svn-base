<?php
include "../../config/config.inc.php";
include "db.php";
error_reporting(E_ALL);
print_r('<pre>');
class emailBlast extends db{
	var $mail;

	function generateData(){
		global $ENGINE_PATH;
		require_once  '../'.$ENGINE_PATH."Utility/Mailer_Blast.php";
		$this->mail = new Mailer_Blast();
		
		$data[] = $this->email_blast();
		
		print_r($data);
	}
	
	
	function email_blast(){
		$emailTo[0] ='bummi@kana.co.id';
		$emailTo[1] ='darkrad99@gmail.com';
		
		$sql = "
		 select gift.voucher_id,gift.code_voucher,gift.serial_number,ugift.user_id,ugift.gift_id,date_time,email 
		 from axis.tbl_user_gift ugift 
		 INNER JOIN axis.tbl_gift gift ON gift.id=ugift.gift_id 
		 INNER JOIN axis.axis_member am ON am.id=ugift.user_id 
		 WHERE date_time >= '2012-07-28 00:00:01' 
		 AND date_time <='2012-07-29 23:59:59' 

		";
		$emailTo = $this->fetch($sql,true);
		
		foreach($emailTo as $gift){
			$to[0] = 'bummi@kana.co.id';//email
			$to[1] = 'impstrg@yahoo.com';//email
			// $to[0]     = $gift->email;
			// $to[1]     = 'hemat@axisworld.co.id';
			// $to[2]     = 'admin@tangkapberkahaxis.com';
		
				
			//proses email
			$cptx['kode'][2] =  'Rp . 50.000';
			$cptx['kode'][3] =  'Rp . 20.000';
			$cptx['kode'][4] =  'Rp . 10.000';
			$cptx['kode'][5] =  'Rp . 5.000';

			$serial_number = $gift->serial_number;
			$kode = $gift->code_voucher;
			$rupiah = '';
			if(in_array($gift->voucher_id,array(2,3,4,5))) $rupiah = $cptx['kode'][$gift->voucher_id];
			
			include "../../config/email.php";
			
			$cptx['msg'][6]  = $EMAIL['blibli'];
			$cptx['msg'][7]  = $EMAIL['zelora'];
			$cptx['msg'][8]  = $EMAIL['LivingSocial'];
			$cptx['msg'][1]  = $EMAIL['facebook'];
			
			$msg = $EMAIL['voucher'];		
			if(in_array($gift->voucher_id,array(1,6,7,8))) $msg = $cptx['msg'][$gift->voucher_id];
			
			$result = $this->sendMail($to,$msg);
			
			print_r(array($gift->email,$rupiah,$gift->voucher_id));
			$data[] = $result['message'];
			// sleep(10);
		}
		
		return $data;
	}
	
	
	function sendMail($to,$msg){
		// $to =  array('bummi@kana.co.id');
		$from = 'noreply@tangkapberkahaxis.com';
		
		// $msg = 'test';
		// $flag='<br />Kalau kamu ada kendala atau pertanyaan, kamu bisa email ke : hemat@axisworld.co.id';
	
		
		$this->mail->setRecipient($to);	
		$this->mail->setSubject('Notification AXIS');
		$this->mail->setMessage($msg);
		$result = $this->mail->send();
	
		if($result) return array('message'=>'success send mail');
		else return array('message'=>'error mail setting');
	
	}
	
	
	
	
}


$class = new emailBlast;
$class->generateData();

die();

?>
