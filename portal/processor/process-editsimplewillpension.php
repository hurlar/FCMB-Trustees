<?php
session_start();
ob_start();
require_once('../Connections/conn.php'); 

$edtrsano = $_POST['edtrsano'];
$edtpensionadmin = $_POST['edtpensionadmin']; 
$edtpensionid = $_POST['edtpensionid']; 



$url1 = '../simplewill-beneficiary.php?a=update';
$url2 = '../simplewill-beneficiary.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE simplewill_assets_tb SET `rsa` = '$edtrsano', `pension_admin` = '$edtpensionadmin' WHERE `id` = '$edtpensionid' ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
//}
?>

