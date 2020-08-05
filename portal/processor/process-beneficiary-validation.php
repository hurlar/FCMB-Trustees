<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$uid = $_POST['uid'];
$propose = $_POST['propose'];

//$url1 = '../my-assets.php?a=successful';
//$url2 = '../assets.php?a=error';
$url1 = '../secondary-beneficiary.php';
$url2 = '../assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT * FROM assets_legacy WHERE uid = '$uid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$rowacl  = mysqli_fetch_assoc($query_sql);
$totalacl  = mysqli_num_rows($query_sql); 
if ($totalacl != NULL) {
	$query1 = "UPDATE assets_legacy SET `legacy` = '$propose' WHERE `uid` = '$uid' ";
	$result1=mysqli_query($conn, $query1) or die(mysqli_error($conn));
	header("Location: $url1");
}else{
	$query = "INSERT INTO assets_legacy (uid, legacy) VALUES ('$uid','$propose')";
	$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	header("Location: $url1");
}

?>