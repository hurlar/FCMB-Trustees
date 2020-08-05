<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$personalchattels =     $_POST['personalchattels'];
$personalchattelsuid =    $_POST['personalchattelsuid']; 
$assettype =    $_POST['assettype6']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `personal_chattels`,`datecreated`) VALUES ('$personalchattelsuid', '$assettype', '$personalchattels', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

