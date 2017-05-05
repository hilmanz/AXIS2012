<?php
$dbUser = "root";
$dbPass = "";
$db = "axis_bb10";
$server = "localhost";
// membuat koneksi
$koneksi = mysql_connect($server, $dbUser, $dbPass);
// membuka database
mysql_select_db($db);
// memeriksa koneksi


if(!$koneksi){
echo("Koneksi ke database gagal");
exit;
}




?>
