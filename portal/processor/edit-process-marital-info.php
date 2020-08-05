<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$status = $_POST['mstatus']; 
$uid =    $_POST['uid'];


//mysqli_select_db($conn, $database_conn);
//$sql = "SELECT uid FROM access_level  WHERE uid = '$uid' "; 
//$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$totalacl = mysqli_num_rows($query_sql); 
//if ($totalacl == TRUE) {
	//$update1 = "UPDATE access_level SET access = '1' WHERE uid = '$uid' "; 
	//$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
//}else{
	//$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '1')";
	//$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
//}


mysqli_select_db($conn, $database_conn);
$query = "SELECT uid FROM marital_status WHERE uid = '$uid' "; 
$query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
$totalms = mysqli_num_rows($query_run); 

if ($totalms == TRUE) {
	$update = "UPDATE marital_status SET status = '$status' WHERE uid = '$uid' "; 
	$update_run = mysqli_query($conn, $update) or die(mysqli_error($conn));
	header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	//$insert = "INSERT INTO marital_status (uid, status) VALUES ('$uid', '$status')";
	//$insert_run = mysqli_query($conn, $insert) or die(mysqli_error($conn));
	header("Location: ../edit-marital-info.php?a=error");
}

?>

