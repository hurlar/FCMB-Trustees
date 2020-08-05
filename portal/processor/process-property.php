<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$plocation = $_POST['plocation']; 
$ptype =     $_POST['ptype'];
$pregistered =    $_POST['pregistered'];
$assettype =    $_POST['assettype'];
$pid =    $_POST['puid']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `property_location`, `property_type`,`property_registered`,`datecreated`) VALUES ('$pid', '$assettype', '$plocation', '$ptype', '$pregistered', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

