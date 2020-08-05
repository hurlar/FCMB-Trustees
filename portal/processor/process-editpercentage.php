<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$percentage = $_POST['percentage']; 
$childid =     $_POST['childid'];

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT percentage FROM beneficiary_dump WHERE id = '$childid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$rowacl  = mysqli_fetch_assoc($query_sql);

$totalacl = mysqli_num_rows($query_sql); 
if ($totalacl == TRUE) {
	$update1 = "UPDATE beneficiary_dump SET percentage = '$percentage' WHERE id = '$childid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	header("Location: ../percentage-sharing.php");
	//exit();
}else{
	$insert1 = "INSERT INTO beneficiary_dump (percentage) VALUES ('$percentage') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	header("Location: ../percentage-sharing.php");
}

?>

