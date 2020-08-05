<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtplocation = $_POST['edtplocation']; 
$edtptype =     $_POST['edtptype'];
$edtpregistered =    $_POST['edtpregistered'];
$edtpuid =    $_POST['edtpuid'];

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `property_location` = '$edtplocation', `property_type` = '$edtptype', `property_registered` = '$edtpregistered' WHERE id = '$edtpuid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

