<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editinvestmenttype = $_POST['editinvestmenttype']; 
$editinvestmentaccount =     $_POST['editinvestmentaccount'];
$editinvestmentaccountname =    $_POST['editinvestmentaccountname'];
$editinvestmentunits =    $_POST['editinvestmentunits'];
$editinvestmentfacevalue =    $_POST['editinvestmentfacevalue'];
$editinvestmentid =    $_POST['editinvestmentid'];

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `investment_type` = '$editinvestmenttype', `investment_account` = '$editinvestmentaccount', `investment_accountname` = '$editinvestmentaccountname', `investment_units` = '$editinvestmentunits', `investment_facevalue` = '$editinvestmentfacevalue' WHERE id = '$editinvestmentid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

