<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$children = $_SESSION['children'];
$mstatus = $_SESSION['mstatus'];
$mid = $_SESSION['mid']; 

//update or insert the value of marital status
mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT uid FROM marital_status WHERE uid = '$mid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql);  
if ($totalacl == TRUE) {
	$update1 = "UPDATE marital_status SET status = '$mstatus' WHERE uid = '$mid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert1 = "INSERT INTO marital_status (uid, status) VALUES ('$mid', '$mstatus') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
}

//update or insert the value of child,if the user has a child
mysqli_select_db($conn, $database_conn);
$sql3 = "SELECT uid FROM child_tb WHERE uid = '$mid' "; 
$query_sql3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
$totalacl3 = mysqli_num_rows($query_sql3); 
if ($totalacl3 == TRUE) {
	$update3 = "UPDATE child_tb SET status = '$children' WHERE uid = '$mid'"; 
	$update_run3 = mysqli_query($conn, $update3) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert3 = "INSERT INTO child_tb (uid, status) VALUES ('$mid', '$children') ";
	$insert_run3 = mysqli_query($conn, $insert3) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php");
	//header("Location: ../dashboard.php?a=update");
}

//get the age of the child
mysqli_select_db($conn, $database_conn);
$sql4 = "SELECT `dob` FROM children_details WHERE uid = '$mid' "; 
$query_sql4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
$totalacl4 = mysqli_fetch_assoc($query_sql4); 
$age2 = $totalacl4['dob'];
$age1 = date('Y', strtotime($age2));
$currentyear = date('Y');
$age =  $currentyear - $age1;
if ($age < 18) {
	header("Location: ../add-guardian.php");
	exit();
}else{
$sql6 = "SELECT uid, access FROM access_level  WHERE uid = '$mid' "; 

$query_sql6 = mysqli_query($conn, $sql6) or die(mysqli_error($conn));

$totalacl6 = mysqli_num_rows($query_sql6); 

$row_access = mysqli_fetch_assoc($query_sql6);

if ($row_access['access'] > '1') {
	header("Location:../dashboard.php");
	exit();
}


if ($totalacl6 == TRUE) {

	$update6 = "UPDATE access_level SET access = '1' WHERE uid = '$mid' "; 

	$update_run6 = mysqli_query($conn, $update6) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	exit();

}else{

	$insert6 = "INSERT INTO access_level (uid, access) VALUES ('$mid', '1')";

	$insert_run6 = mysqli_query($conn, $insert6) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}
}


