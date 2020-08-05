<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$scompany = $_POST['scompany']; 
$svolume =     $_POST['svolume'];
$spercent =    $_POST['spercent']; 
$cscs =    $_POST['cscs'];
$chn =    $_POST['chn'];
$assettype1 =    $_POST['assettype1'];
$sid =    $_POST['suid']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `shares_company`, `shares_volume`,`shares_percent`,`shares_cscs`,`shares_chn`,`datecreated`) VALUES ('$sid', '$assettype1', '$scompany', '$svolume', '$spercent','$cscs','$chn',NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

