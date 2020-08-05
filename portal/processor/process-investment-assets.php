<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$investment =     $_POST['investment'];
$investmentaccount = $_POST['investmentaccount']; 
$investmentaccountname =    $_POST['investmentaccountname'];
$investmentunits =    $_POST['investmentunits'];
$investmentfacevalue =    $_POST['investmentfacevalue'];
$investmentuid =    $_POST['investmentuid']; 
$assettype =    $_POST['assettype5']; 

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `investment_type`,`investment_account`,`investment_accountname`,`investment_units`,`investment_facevalue`,`datecreated`) VALUES ('$investmentuid', '$assettype', '$investment', '$investmentaccount', '$investmentaccountname', '$investmentunits', '$investmentfacevalue', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

