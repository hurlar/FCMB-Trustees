<?php
session_start();
ob_start();
require_once('../Connections/conn.php');
$a = $_GET['a'];

$url1 = '../reserve-marital-info.php';
$url2 = '../reserve-marital-info.php';

mysqli_select_db($conn, $database_conn);
$query = "SELECT `id`,`uid` FROM spouse_tb WHERE id = '$a' "; 
$query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($query_run);
$totalspouse = mysqli_num_rows($query_run);
$uid = $row['uid'];

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM spouse_tb WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($totalspouse < '1'){
$deletemaritalstatus = "DELETE FROM marital_status WHERE uid = '$uid' "; 
$query_deletemaritalstatus = mysqli_query($conn, $deletemaritalstatus) or die(mysqli_error($conn));
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

