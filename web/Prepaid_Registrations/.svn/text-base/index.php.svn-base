<?php
session_start();
session_destroy();
include_once "common.php";

$db = new SQLData();
$msg = "";
if(isset($_POST['registering'])==1){
	$nomorHP = mysql_escape_string(cleanXSS(strip_tags($_POST['phone'])));
		/*Check nomor HP*/
		$zero = substr($nomorHP,0,1);
		$null = $nomorHP;
		$enamDuaNol = substr($nomorHP,0,3);
		$enamDuaPlus = substr($nomorHP,0,3);
		if($zero == '0'){
			$nomorHP = '62'.substr($nomorHP,1);
		}else if($enamDuaPlus == '+62'){
			$nomorHP = '62'.substr($nomorHP,3);
		}else if($enamDuaNol == '620'){
			$nomorHP = '62'.substr($nomorHP,3);
		}
	$name = mysql_escape_string(cleanXSS(strip_tags($_POST['name'])));
	$id_type = mysql_escape_string(cleanXSS(strip_tags($_POST['id_type'])));
	$id_number = mysql_escape_string(cleanXSS(strip_tags($_POST['id_number'])));
	$email = mysql_escape_string(cleanXSS(strip_tags($_POST['email'])));
	$place_birth = mysql_escape_string(cleanXSS(strip_tags($_POST['place_birth'])));
	$dob = mysql_escape_string(cleanXSS(strip_tags($_POST['dob'])));
	$religion = mysql_escape_string(cleanXSS(strip_tags($_POST['religion'])));
	$address = mysql_escape_string(cleanXSS(strip_tags($_POST['address'])));
	$city = mysql_escape_string(cleanXSS(strip_tags($_POST['city'])));
	$zipcode = mysql_escape_string(cleanXSS(strip_tags($_POST['zipcode'])));
	$alt_phone = mysql_escape_string(cleanXSS(strip_tags($_POST['alt_phone'])));
	$occupation = mysql_escape_string(cleanXSS(strip_tags($_POST['occupation'])));
	$hobby = mysql_escape_string(cleanXSS(strip_tags($_POST['hobby'])));
	
	$db->open(1);
		$sql = "INSERT INTO axis_customer_table
				VALUE (null,'{$name}',							
						'{$dob}',
						'{$place_birth}',
						'0',
						'{$address}',
						'0',
						'0',
						'0',
						'{$city}',
						'0',
						{$nomorHP},
						'{$alt_phone}',
						'{$religion}',
						'0',
						'{$id_number}',
						'{$id_type}',
						'0',
						'{$email}',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0','{$zipcode}','{$hobby}','{$occupation}',2,0)";
		$rs = $db->query($sql);
		$db->close();
		if($rs){
			$_SESSION['number'] = $nomorHP;
			$db->open(1);
				$sqll="UPDATE axis_registered_number
						SET n_status=1
						WHERE number=".$_SESSION['number'];
				$rss=$db->query($sqll);
			$db->close();
			if($rss){
				sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar&act=prabayar_form&f=1');
			}
		}else{
			$_SESSION['number'] = $nomorHP;
			sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar&act=prabayar_form&f=0');
		}
}else{
	if(isset($_POST['noHP'])!=null){
		$nomorHP = mysql_escape_string(cleanXSS(strip_tags($_POST['noHP'])));
			/*Check nomor HP*/
			$zero = substr($nomorHP,0,1);
			$null = $nomorHP;
			$enamDuaNol = substr($nomorHP,0,3);
			$enamDuaPlus = substr($nomorHP,0,3);
			if($zero == '0'){
				$nomorHP = '62'.substr($nomorHP,1);
			}else if($enamDuaPlus == '+62'){
				$nomorHP = '62'.substr($nomorHP,3);
			}else if($enamDuaNol == '620'){
				$nomorHP = '62'.substr($nomorHP,3);
			}
		$db->open(1);
			$sql="SELECT * FROM axis_registered_number
					WHERE number = {$nomorHP}";

			$rs = $db->fetch($sql);
		$db->close();
		if(!$rs){
			sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar&f=1');
		}else{
			if($rs['n_status'] == 0){
				$_SESSION['number'] = $nomorHP;
				sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar_form');
			}else{
				sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar&f=0');
			}
		}
		
	}else{
		sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&act=prabayar');
	}	
}
?>