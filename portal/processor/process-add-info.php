<?php

session_start();

ob_start();

require_once('../Connections/conn.php');



//$bvn = $_POST['bvn']; 

$uid =    $_POST['uid'];





mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid FROM access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalacl = mysqli_num_rows($query_sql); 

if ($totalacl == TRUE) {

	$update1 = "UPDATE access_level SET access = '6' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../will-trust.php");

	exit();

}else{

	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '6')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../will-trust.php");

}



?>



