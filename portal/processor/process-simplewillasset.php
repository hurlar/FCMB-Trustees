<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

mysqli_select_db($conn, $database_conn);

$ex = "SELECT uid FROM simplewill_assets_tb WHERE uid = '$uid' AND `asset_type` = 'bankaccount'"; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex); 


mysqli_select_db($conn, $database_conn);

$pension = "SELECT uid FROM simplewill_assets_tb WHERE uid = '$uid' AND `asset_type` = 'pension' "; 

$query_pension = mysqli_query($conn, $pension) or die(mysqli_error($conn));

$totalpension = mysqli_num_rows($query_pension);  

if ($totalex >= '1') {
    header("Location: ../simplewill-percentage-sharing.php");
    exit();
}

if ($totalpension >= '1') {
    header("Location: ../simplewill-percentage-sharing.php");
    exit();
}


$sql = "SELECT uid,access FROM simplewill_access_level WHERE uid = '$uid' "; $query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql); 

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '2') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE simplewill_access_level SET access = '2' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}


?>



