<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$employer = $_POST['employer']; 
$employeraddr =     $_POST['employeraddr'];
$employerphone =    $_POST['employerphone'];
$employerid =    $_POST['employerid'];
$employerstatus =    $_POST['employerstatus'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../personal-info.php?a=successful';
$url2 = '../personal-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT uid FROM employment_tb WHERE uid = '$employerid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql); 
if ($totalacl == TRUE) {
	$update1 = "UPDATE employment_tb SET status = '$employerstatus', employer = '$employer', address = '$employeraddr', phone = '$employerphone'  WHERE uid = '$employerid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	header("Location: ../personal-info.php?a=update");
	exit();
}else{
	$insert1 = "INSERT INTO employment_tb (uid, status, employer, address, phone, datecreated) VALUES ('$employerid', '$employerstatus', '$employer', '$employeraddr', '$employerphone', NOW()) ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	header("Location: ../personal-info.php?a=insert");
}


?>

