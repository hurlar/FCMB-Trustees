<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editpensionname = $_POST['editpensionname']; 
$editpensionowner =     $_POST['editpensionowner'];
$editrsano =    $_POST['editrsano'];
$editpensionadmin =    $_POST['editpensionadmin'];
$editpensionid =    $_POST['editpensionid'];

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `pension_name` = '$editpensionname', `pension_owner` = '$editpensionowner', `rsano` = '$editrsano', `pension_admin` = '$editpensionadmin' WHERE id = '$editpensionid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

