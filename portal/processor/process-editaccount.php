<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editbvnnumber = $_POST['editbvnnumber']; 
$editbankname =     $_POST['editbankname'];
$editanctname =    $_POST['editanctname'];
$editactno =    $_POST['editactno'];
$editacttype =    $_POST['editacttype'];
$editaccountid =    $_POST['editaccountid'];

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `bvn` = '$editbvnnumber', `account_name` = '$editanctname', `account_no` = '$editactno', `bankname` = '$editbankname', `accounttype` = '$editacttype' WHERE id = '$editaccountid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

