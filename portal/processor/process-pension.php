<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$pensionname =     $_POST['pensionname'];
$pensionowner = $_POST['pensionowner']; 
$pension =    $_POST['pension'];
$rsano =    $_POST['rsano'];
$pensionadmin =    $_POST['pensionadmin'];
$pensionuid =    $_POST['pensionuid']; 
$assettype =    $_POST['assettype4']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `pension_name`,`pension_owner`,`pension_plan`,`rsano`,`pension_admin`,`datecreated`) VALUES ('$pensionuid', '$assettype', '$pensionname', '$pensionowner', '$pension', '$rsano', '$pensionadmin', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

