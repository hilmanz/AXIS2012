<?php 

class galeriHelper {

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
	
	
	
	function getGalleryAlbum($start=0,$limit =4){
		
		
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=5
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			$qData = $this->apps->fetch($sql,1);
			$this->logger->log($sql);
			if(!$qData) return false;
		
			return $qData;
		

	}
	function getGallery($start=0,$limit =18){
		
			global $CONFIG;
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=5
					ORDER BY posted_date DESC LIMIT {$start},{$limit}
					";
			// pr($sql);
			$qData = $this->apps->fetch($sql,1);
			$jml ="	SELECT COUNT(id) as total_rows FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=5
					";
			$qjml = $this->apps->fetch($jml);
			if($qjml['total_rows'] != '0'){
				$qData[0]['total_rows'] = $qjml['total_rows'];
			}
			$this->logger->log($sql);
			if(!$qData) return false;
			foreach($qData as $key => $val){
				if(file_exists("{$CONFIG['LOCAL_PUBLIC_ASSET']}galeri/thumb_{$val['image']}")) $qData[$key]['thumb_image']="thumb_{$val['image']}";
				else  $qData[$key]['thumb_image']=false;
			}
			// pr($qData);
			return $qData;
		

	}
	
	
	function getGalleryDetail($limit=1){
	
			$cid = intval($this->apps->_g('id'));
			if($cid) $qIdContent = " AND id = {$cid} ";
			else $qIdContent = "";
			$sql ="	SELECT * FROM  axis_coorporate_blog 
					WHERE n_status = 1 AND lid={$this->lid} AND type=5
					{$qIdContent}
					ORDER BY posted_date DESC LIMIT {$limit}
					";
			$qData = $this->apps->fetch($sql);
			// pr($sql);exit;
			$this->logger->log($sql);
			if(!$qData) return false;
		
			return $qData;
	
	}
	
	function sendMessage(){

		$name 	 	= $this->apps->_p('txtName');
		$email		= $this->apps->_p('txtEmail');
		$propinsi	= $this->apps->_p('txtPropinsi');
		$telepon	= $this->apps->_p('txtTelepon');
		$kota		= $this->apps->_p('txtKota');
		$tipe		= $this->apps->_p('txtTipe');
		$message	= $this->apps->_p('txtMessage');
		
		$sql ="INSERT INTO axis_message (nama, 	userid ,	email 	,propinsi 	,kota ,	tipe ,telepon ,	message ,	date_time, 	n_status) 
		VALUES ('{$name}','{$this->uid}','{$email}','{$propinsi}','{$kota}','{$tipe}','{$telepon}','{$message}',NOW(),0)
		" ;
		$this->apps->query($sql);
		$this->logger->log($sql);
		$sq = "SELECT * FROM axis_message_type WHERE web_type = 2 AND id = ".$tipe;
		$rs = $this->apps->fetch($sq);
		
		if($this->apps->getLastInsertId()){
			
			$to= 'cendiqkrn@gmail.com';
			$from = $email;
			$msg = $message;
			$result = $this->sendGlobalMail($to,$from,$msg,$rs['type']);
			if($result['result']){
				$sql = "UPDATE axis_message SET n_status=1 WHERE id={$this->apps->getLastInsertId()} LIMIT 1";
				$this->apps->query($sql);
				return $result;
			}else return $result;
			
		}
		return false;
	}
	
	function sendGlobalMail($to,$from,$msg, $subject){
	
		GLOBAL $ENGINE_PATH;
		require_once $ENGINE_PATH."Utility/Mailer.php";		
		$mail = new Mailer();
		$mail->setRecipient($to);	
		$mail->setSubject($subject);
		$mail->setMessage($msg);
		$result = $mail->send();
	
		if($result) return array('message'=>'success send mail','result'=>true);
		else return array('message'=>'error mail setting','result'=>false);
	}
	
	function getMsgType(){
		$sql = "SELECT * FROM axis_message_type WHERE web_type=2";
		$rs = $this->apps->fetch($sql, 1);
		$this->logger->log($sql);
		return $rs;
	}
}	
?>

