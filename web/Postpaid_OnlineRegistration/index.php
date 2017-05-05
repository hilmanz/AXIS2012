<?php
	include_once "common.php";
	$db = new SQLData();
	
	global $CONFIG;
	
	$msg="";
	if(isset($_POST['registering'])==1){
		
		$name = mysql_escape_string(cleanXSS(strip_tags($_POST['name'])));
		$birthplace = mysql_escape_string(cleanXSS(strip_tags($_POST['place_of_birth'])));
		$bod = mysql_escape_string(cleanXSS(strip_tags($_POST['bod'])));
		$gender = mysql_escape_string(cleanXSS(strip_tags($_POST['gender'])));
		$address = mysql_escape_string(cleanXSS(strip_tags($_POST['address'])));
		$rtrw = mysql_escape_string(cleanXSS(strip_tags($_POST['rtrw'])));
		$kelurahan = mysql_escape_string(cleanXSS(strip_tags($_POST['kelurahankecamatan'])));
		$kecamatan = mysql_escape_string(cleanXSS(strip_tags($_POST['kelurahankecamatan'])));
		$city = mysql_escape_string(cleanXSS(strip_tags($_POST['city'])));
		$province = mysql_escape_string(cleanXSS(strip_tags($_POST['province'])));		
		$phonenumber = mysql_escape_string(cleanXSS(strip_tags($_POST['prefix']))).''.mysql_escape_string(cleanXSS(strip_tags($_POST['phone'])));
		$mobilenumber = mysql_escape_string(cleanXSS(strip_tags($_POST['mobile_number'])));
		$religion = mysql_escape_string(cleanXSS(strip_tags($_POST['religion'])));
		$mothername = mysql_escape_string(cleanXSS(strip_tags($_POST['mother_name'])));
		$idnumber = mysql_escape_string(cleanXSS(strip_tags($_POST['id_number'])));
		$idtype = mysql_escape_string(cleanXSS(strip_tags($_POST['id_card_type'])));
		$npwp = mysql_escape_string(cleanXSS(strip_tags($_POST['npwp'])));
		$email = mysql_escape_string(cleanXSS(strip_tags($_POST['email'])));
		$contactperson = mysql_escape_string(cleanXSS(strip_tags($_POST['contactable_person'])));
		$contactrelation = mysql_escape_string(cleanXSS(strip_tags($_POST['contactable_relation'])));
		$contactaddress = mysql_escape_string(cleanXSS(strip_tags($_POST['contactable_address'])));
		$contactphone = mysql_escape_string(cleanXSS(strip_tags($_POST['contactable_phone'])));
		$packed = mysql_escape_string(cleanXSS(strip_tags($_POST['packed'])));
		$extra = mysql_escape_string(cleanXSS(strip_tags($_POST['extra'])));
		
		if( is_array($extra) && count($extra) > 1)
		{
			$extra = implode($extra,",");
		}
		
		$payment = $_POST['payment'];
		$db->open(1);
		$sql = "INSERT INTO axis_customer_table
				VALUE (null,'{$name}',							
						'{$bod}',
						'{$birthplace}',
						'{$gender}',
						'{$address}',
						'{$rtrw}',
						'{$kelurahan}',
						'{$kecamatan}',
						'{$city}',
						'{$province}',
						{$phonenumber},
						'{$mobilenumber}',
						'{$religion}',
						'{$mothername}',
						'{$idnumber}',
						'{$idtype}',
						'{$npwp}',
						'{$email}',
						'{$contactperson}',
						'{$contactrelation}',
						'{$contactaddress}',
						'{$contactphone}',
						'{$packed}',
						'{$extra}',
						'{$payment}',0,0,1,0)";
		$rs = $db->query($sql);	
		$db->close();
		
		if($rs){
			sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&f=0');
		}else{
			sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration&f=1');
		}
	}else{
		sendRedirect($CONFIG['BASE_DOMAIN'].'index.php?page=registration');
	}
?>