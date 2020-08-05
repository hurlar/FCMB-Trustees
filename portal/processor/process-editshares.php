<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editsharescompany = $_POST['editsharescompany']; 
$editsharesvolume =     $_POST['editsharesvolume'];
$editsharespercentage =    $_POST['editsharespercentage'];
$editsharescscs =    $_POST['editsharescscs'];
$editshareschn =    $_POST['editshareschn'];
$editsharesid =    $_POST['editsharesid']; 

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `shares_company` = '$editsharescompany', `shares_volume` = '$editsharesvolume', `shares_percent` = '$editsharespercentage', `shares_cscs` = '$editsharescscs', `shares_chn` = '$editshareschn' WHERE id = '$editsharesid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

