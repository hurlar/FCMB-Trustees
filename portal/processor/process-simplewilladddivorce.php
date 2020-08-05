<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$divorce = $_POST['divorce']; 
$divorceyear =     $_POST['divorceyear'];
$divorcecert =    $_POST['divorcecert'];
$suid =    $_POST['suid'];
$status =    $_POST['status'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../simplewill-marital-info.php?a=successful';
$url2 = '../simplewill-marital-info.php.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT uid FROM marital_status WHERE uid = '$suid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql); 
if ($totalacl == TRUE) {
	$update1 = "UPDATE marital_status SET status = '$status' WHERE uid = '$suid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert1 = "INSERT INTO marital_status (uid, status) VALUES ('$suid', '$status') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
}

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO divorce_tb (`uid`, `divorce`, `divorceyear`,`divorceorder`,`datecreated`) VALUES ('$suid', '$divorce', '$divorceyear', '$divorcecert', NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

