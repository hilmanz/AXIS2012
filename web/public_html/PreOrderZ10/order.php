<?php include("includes/dbconnector.php");

$querycolor="select color_white,color_black from axisbb10_color";
$hasilcolor = mysql_query($querycolor);
$rowcolor = mysql_fetch_array($hasilcolor);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Gabung di serunya DUNIA AXIS yang baru dan dapatkan segala info yang kamu butuhkan tentang operator GSM dengan pertumbuhan paling pesat di Indonesia">
	<meta name="keywords" content="axis internet,axis blackberry,axis unlimited,kartu axis,internet unlimited axis,axis transfer pulsa,promo axis,internet unlimited,paket blackberry,paket internet,internet murah">
<title>The revolutionary BlackBerry® Z10</title>
<style type="text/css">
body {
	height: 100%; margin: 0px;
}


@font-face {
		font-family: 'HelveticaLTStd-Light';
		src: url('fonts/helveticaltstdlight.eot');
		src: url('fonts/helveticaltstdlight.eot?#iefix') format('embedded-opentype'),
				 url('fonts/helveticaltstdlight.woff') format('woff'),
				 url('fonts/helveticaltstdlight.ttf') format('truetype'),
				 url('fonts/helveticaltstdlight.svg#helveticaltstdlight') format('svg');
		font-weight: normal;
		font-style: normal;
}
	

.tulisantitle {font: 24px 'HelveticaLTStd-Light', arial, san-serif; color:#000; text-shadow: 0 2px 0 #cccccc; }
.tulisan14 {font: 20px 'HelveticaLTStd-Light', arial, san-serif; color:#292927;text-shadow: 0 2px 0 #cccccc;-webkit-font-smoothing: antialiased;}
.tulisanfooter {font: 9px 'tahoma', arial, san-serif; color:#666;}
.tulisansocial{font: 12px 'HelveticaLTStd-Light', arial, san-serif; color:#666;}

.tulisancounter {font: 30px 'HelveticaLTStd-Light', arial, san-serif; color:#Fff; letter-spacing:6px; }
.tulisan18 {font: 20px 'HelveticaLTStd-Light', arial, san-serif; color:#000; }

.tulisanketcounter {font: 13px 'tahoma', arial, san-serif; color:#000;  }
.tulisanabu2 {font: 18px 'tahoma', arial, san-serif; color:#595959; }
.tulisanhitam13 {font: 16px 'tahoma', arial, san-serif; color:#000; }
.tulisanhitam12 {font: 12px 'tahoma', arial, san-serif; color:#000; }

form legend {
	color: #333;
	padding: 0 0 20px 0;
	text-transform: uppercase;
}

form {
	padding: 0 0px 0px 0px;
}

form, form fieldset input, form fieldset textarea, form label {
	font-family: Helvetica, Arial; width:400px;
	font-size: 12px;
}
form p { position: relative; margin: 10px 0;}
form p label { position: absolute; top: 0; left: 0;}
form p br {display: none;}


form fieldset p input,
form fieldset p textarea {
	display: block;
	padding: 4px;
	width: 400px;-moz-border-radius: 5px;border-radius: 5px;
	margin: 0;
}

form fieldset p label {
	width: 380px;
	display: block;
	margin: 5px 5px 5px 6px;
	padding: 0;
}

form fieldset p textarea {
	padding: 2px;-moz-border-radius: 5px;border-radius: 5px;
	width: 404px;
}

form fieldset p textarea,
form fieldset p input {
	border: solid 2px #8064a2;
}
form fieldset p label {
	color: #777;
}


</style>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="src/jquery.infieldlabel.min.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript" charset="utf-8">
		$(function(){ $("label").inFieldLabels(); });
	</script>
	<!--[if lte IE 6]>
		<style type="text/css" media="screen">
			form label {
					background: #fff;
			}
		</style>
	<![endif]-->
 
<SCRIPT LANGUAGE="JavaScript" src="src/mandat.js"></script>
<script>


	function cekform(form){
		
		
		if(document.form.prefix.value == "0838" || document.form.prefix.value == "0831" )
		{
	
		} else {
			alert("<?php if($_REQUEST['ver']=="ind") {?>Bukan No Telp AXIS<?php } else {?>Not an AXIS number <?php }?>");
			document.form.prefix.focus();
			return false;
		}
		

		
		if (!validRequired(form.prefix,"<?php if($_REQUEST['ver']=="ind") {?>No AXIS<?php } else {?>AXIS No<?php }?>"))
		return false;
	
		if (!validRequired(form.noaxis,"<?php if($_REQUEST['ver']=="ind") {?>No AXIS<?php } else {?>AXIS No<?php }?>"))
		return false;
		
		if (!validRequired(form.name,"<?php if($_REQUEST['ver']=="ind") {?>Nama<?php } else {?>Name<?php }?>"))
		return false;
		
		if (!validRequired(form.noktp,"<?php if($_REQUEST['ver']=="ind") {?>No. KTP<?php } else {?>ID Card<?php }?>"))
		return false;

	
		if (!validRequired(form.email,"<?php if($_REQUEST['ver']=="ind") {?>Alamat E-mail<?php } else {?>Email Address<?php }?>"))
			return false;
	
		if (!validEmail(form.email,"<?php if($_REQUEST['ver']=="ind") {?>Alamat E-mail<?php } else {?>Email Address<?php }?>",true))
			return false;
		
		if (!validRequired(form.address,"<?php if($_REQUEST['ver']=="ind") {?>Alamat Rumah<?php } else {?>Home Address<?php }?>"))
			return false;
		
		if (!validRequired(form.color,"<?php if($_REQUEST['ver']=="ind") {?>Pilihan Warna<?php } else {?>Preferred Color<?php }?>"))
			return false;
		
		
		return true;
	
	
	
	}
</script>   
</head>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="89" valign="top" style="background:url(images/dotted.gif) repeat-x bottom;"><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="770" valign="top"><a href="http://www.axisworld.co.id/" target="_blank"><img src="images/axis_logo.gif" width="122" height="85" border="0" /></a></td>
        <td width="130" align="right" valign="middle"><table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php if($_REQUEST['ver']=="eng" or $_REQUEST['ver']=="") { ?><img src="images/en.gif" width="36" height="12" border="0" /><?php } else { ?><a href="order.php?ver=eng"><img src="images/en1.gif" width="36" height="12" /></a><?php } ?></td>
            <td><?php if($_REQUEST['ver']=="ind") { ?><img src="images/id.gif" width="36" height="12" border="0" /><?php } else { ?><a href="order.php?ver=ind"><img src="images/id1.gif" width="36" height="12" /></a><?php } ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="507" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="480" height="434" align="center" valign="middle"><img src="images/bb10.png" width="352" height="400" /><br /></td>
        <td width="480" valign="top"><br />
          <p><img src="images/maintextind2.jpg"/></p>
        </td>
      </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="45" valign="top" style="background:url(images/dotted.gif) repeat-x top;"><div align="center" class="tulisanfooter" style="height:10px; padding-top:8px;">Blackberry®, RIM®, Research In Motion® and related trademark, names and logos are the property of Research In Motion Limited and are registered and/or used in the US, and countries around the world. Used under license from Research In Motion Limited </div></td>
  </tr>
</table>
</body>
</html>


<?php

if ($_REQUEST['prefix'] <> "" and $_REQUEST['noaxis'] <> "")
{
	
		$prefix=mysql_real_escape_string($_REQUEST['prefix']);
		$noaxis=mysql_real_escape_string($_REQUEST['noaxis']);
		$name=mysql_real_escape_string($_REQUEST['name']);
		$noktp=mysql_real_escape_string($_REQUEST['noktp']);
		$email=mysql_real_escape_string($_REQUEST['email']);
		$address=mysql_real_escape_string($_REQUEST['address']);
		$color=mysql_real_escape_string($_REQUEST['color']);
		
		
		$query="select axisbb10_counter from axisbb10_counter";
		$hasil = mysql_query($query);
		$row = mysql_fetch_array($hasil);
		
		
		$code="AXIS - BBZ10 - ".$color.$row[axisbb10_counter];
		
		$date = date("Y-m-d H:i:s");
		
		$nomorxis=$prefix.$noaxis;
		
		$sql  = "INSERT INTO axisbb10_order ";
		$sql .= "(order_axis_no,
				order_code,
				order_name,
				order_noktp,
				order_email,
				order_homeaddress,
				order_color,
				dateadd) ";
		$sql .= "VALUES ";		
		$sql .= "(
				'$nomorxis',
				'$code',
				'$name',
				'$noktp',
				'$email',
				'$address',
				'$color',
				'$date')";	
				
				
	 // print_r($sql);
	$result = mysql_query($sql);
	
	//--------------update counter----------------
	$nourut =$row[axisbb10_counter]+1;
	
	$sql  = "UPDATE axisbb10_counter ";
	$sql .= "SET ";
	$sql .= "axisbb10_counter='$nourut'";
	$result = mysql_query($sql);
	
	//--------------update jumlah----------------

	if($_REQUEST[color]=="BLK") {
		
		$warnahitam=$rowcolor[color_black]-1;
		
		$sqlw  = "UPDATE axisbb10_color ";
		$sqlw .= "SET ";
		$sqlw .= "color_black='$warnahitam'";
		$result = mysql_query($sqlw);
		
		$warnanya="BLACK";
		
	} else if($_REQUEST[color]=="WHT") {
		
		$warnaputih=$rowcolor[color_white]-1;
		
		$sqlw  = "UPDATE axisbb10_color ";
		$sqlw .= "SET ";
		$sqlw .= "color_white='$warnaputih'";
		$result = mysql_query($sqlw);
		
		$warnanya="WHITE";
		
	}
	
	
	//send email
	  $nameto = $name;
	  $to = $email; 
	  $namefrom = "AXIS"; 
	  $from = "digital@axisworld.co.id" ; 
	  $subject = "Terima kasih ".$name." telah melakukan pre-order BlackBerry® Z10 empowered by AXIS Pasti Plus." ;
	  $body = "<table width=750 border=0 cellspacing=0 cellpadding=0 style=font:12 Tahoma, Geneva, sans-serif;>";
	$body .= "<tr>";
	$body .= "<td height=89 colspan=2 style=border-bottom:1px dotted #666;><img src=http://koidigi.com/bb10/preorder/images/axis_logo.gif width=122 height=85></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=53 colspan=2>Hai " .$name.",</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td colspan=2>Terima kasih telah melakukan pre-order BlackBerry&reg; Z10 empowered by AXIS  Pasti Plus.</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td width=288 height=303><img src=http://koidigi.com/bb10/preorder/images/bb10_1.png width=250 height=284></td>";
	$body .= "<td width=412><p><strong>Kode  Unik kamu:</strong></p>";
	$body .= "<p>".$code."<br>";
	$body .= "<br>";
	$body .= "</p></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=29 colspan=2><p>Berikut data pesanan  yang telah kami terima:</p></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>Nama pemesan</strong></td>";
	$body .= "<td>".$name."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>No. Identitas</strong></td>";
	$body .= "<td>".$noktp."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>No. AXIS</strong></td>";
	$body .= "<td>".$nomorxis."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>Alamat</strong></td>";
	$body .= "<td>".$address."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>E-mail</strong></td>";
	$body .= "<td>".$email."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=25><strong>Warna pilihan</strong></td>";
	$body .= "<td>".$warnanya."</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td>&nbsp;</td>";
	$body .= "<td>&nbsp;</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=49 colspan=2><p><strong>Silakan print isi  email ini sebagai bukti pemesanan, dan bawa ke booth AXIS di lokasi launching BlackBerry®  Z10.</strong></p></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=51 colspan=2><p>Tunggu email undangan resmi untuk detail acara launchingnya. Have a good day!</p></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=73 colspan=2 style=border-bottom:1px dotted #666;><p>Best Regards,<br>";
	$body .= "<br>";
	$body .= "AXIS<br><br>";
	$body .= "</p></td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=40 colspan=2 align=center>     <hr size=1> ";
	$body .= "</td>";
	$body .= "</tr>";
	$body .= "<tr>";
	$body .= "<td height=40 colspan=2 align=center><p align=center>Untuk informasi lebih  lanjut silakan hubungi Layanan Pelanggan AXIS di 0838 8000 838 atau 838 dari  nomor AXIS kamu atau email&nbsp;<a href=mailto:cs@axisworld.co.id target=_blank>cs@axisworld.co.id</a>.</p>";
	$body .= "<a href=http://www.facebook.com/AXISgsm target=_blank>Find AXIS on Facebook</a> | <a href=https://twitter.com/AXISgsm target=_blank>Follow  AXIS on Twitter</a></td>";
	$body .= "</tr>";
	$body .= "</table>";
		  
		  
		
		
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	$headers .= "From: ".$namefrom." <".$from.">\r\n";
	$headers .= "Cc: andika.rahmawati@axisworld.co.id\r\n";
  
	$sendmail = mail($to, $subject,$body,$headers);
	
?>	
	
	<Script>
        alert("Thank you for your Order");
        location.href = 'index.php';
    </Script>

<?php
}

?>