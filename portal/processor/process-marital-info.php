<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$status = $_POST['mstatus']; 
$uid =    $_POST['uid'];

//Insert or update the marital status table
mysqli_select_db($conn, $database_conn);
$query = "SELECT uid FROM marital_status WHERE uid = '$uid' "; 
$query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
$totalms = mysqli_num_rows($query_run); 

if ($totalms == TRUE) {
	$update = "UPDATE marital_status SET status = '$status' WHERE uid = '$uid' "; 
	$update_run = mysqli_query($conn, $update) or die(mysqli_error($conn));
	header("Location: ../marital-info.php?a=update");
	//exit();
}else{
	$insert = "INSERT INTO marital_status (uid, status) VALUES ('$uid', '$status')";
	$insert_run = mysqli_query($conn, $insert) or die(mysqli_error($conn));
	header("Location: ../marital-info.php?a=insert");
}

?>

