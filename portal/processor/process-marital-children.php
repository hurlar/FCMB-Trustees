<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$mid = $_POST['mid'];
$children = $_POST['children'];
$mstatus = $_POST['mstatus'];
//echo $mid.' '.$children.' '.$mstatus;
$_SESSION['children'] = $children;
$_SESSION['mstatus'] = $mstatus;
$_SESSION['mid'] = $mid;

if ($children == 'Yes') {
	header("Location:process-children-age.php"); //get children details and check for the ages 
	exit();
}


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

$sql4 = "SELECT uid, access FROM access_level  WHERE uid = '$mid' "; 

$query_sql4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));

$totalacl4 = mysqli_num_rows($query_sql4); 

$row_access = mysqli_fetch_assoc($query_sql4);

if ($row_access['access'] > '1') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl4 == TRUE) {

	$update4 = "UPDATE access_level SET access = '1' WHERE uid = '$mid' "; 

	$update_run4 = mysqli_query($conn, $update4) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	exit();

}else{

	$insert4 = "INSERT INTO access_level (uid, access) VALUES ('$mid', '1')";

	$insert_run4 = mysqli_query($conn, $insert4) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}


?>

