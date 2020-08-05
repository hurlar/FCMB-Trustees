<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid']; 

mysqli_select_db($conn, $database_conn);

$ex = "SELECT guardianname FROM children_details WHERE uid = '$uid' AND age < 18 "; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex);

$rowex = mysqli_fetch_assoc($query_ex);

if ($rowex['guardianname'] == NULL) {
    header("Location:../add-guardian.php?a=denied");
    exit();
}


mysqli_select_db($conn, $database_conn);

$sql = "SELECT `uid`,`access` FROM access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalacl = mysqli_num_rows($query_sql); 

$row_access = mysqli_fetch_assoc($query_sql);

if ($row_access['access'] > '1') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE access_level SET access = '1' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	exit();

}else{

	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '1')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}



?>



