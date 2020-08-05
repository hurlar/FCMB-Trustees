<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$lcompany = $_POST['lcompany']; 
$lpolicy =     $_POST['lpolicy'];
$lowner =    $_POST['lowner']; 
$lvalue =    $_POST['lvalue'];
$assettype2 =    $_POST['assettype2'];
$lid =    $_POST['luid']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`,`insurance_company`, `insurance_type`,`insurance_owner`,`insurance_facevalue`,`datecreated`) VALUES ('$lid','$assettype2', '$lcompany', '$lpolicy', '$lowner','$lvalue',NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

