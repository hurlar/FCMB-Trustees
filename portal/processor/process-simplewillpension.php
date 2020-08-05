<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$rsano =    $_POST['rsano'];
$pensionadmin =    $_POST['pensionadmin'];
$pensionuid =    $_POST['pensionuid']; 
$assettype =    $_POST['assettype4']; 

$url1 = '../simplewill-beneficiary.php?a=successful';
$url2 = '../simplewill-beneficiary.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO simplewill_assets_tb (`uid`, `asset_type`, `rsa`,`pension_admin`, `datecreated`) VALUES ('$pensionuid', '$assettype', '$rsano', '$pensionadmin', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

