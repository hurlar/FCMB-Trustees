<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$a = $_GET['a'];

$url1 = '../my-assets.php?a=delete';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM assets_tb WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
if($query_sql){
$sql3 = "DELETE FROM overall_asset WHERE propertyid = '$a' "; 
$query_sql3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

