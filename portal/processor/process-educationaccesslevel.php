<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$mstatus =    $_POST['mstatus'];

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT uid FROM marital_status WHERE uid = '$uid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql);  
if ($totalacl == TRUE) {
	$update1 = "UPDATE marital_status SET status = '$mstatus' WHERE uid = '$uid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert1 = "INSERT INTO marital_status (uid, status) VALUES ('$uid', '$mstatus') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
}


mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM education_access_level WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql); 

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '1') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE education_access_level SET access = '1' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	//exit();

}else{

	$insert1 = "INSERT INTO education_access_level (uid, access) VALUES ('$uid', '1')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}

?>



