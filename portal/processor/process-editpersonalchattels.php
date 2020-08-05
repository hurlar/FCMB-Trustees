<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editpersonalchattels = $_POST['personalchattels']; 
$editpersonalchattelsid =    $_POST['editpersonalchattelsid']; 

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `personal_chattels` = '$editpersonalchattels' WHERE id = '$editpersonalchattelsid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

