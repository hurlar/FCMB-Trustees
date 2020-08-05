<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

mysqli_select_db($conn, $database_conn);

$guardian = "SELECT uid FROM simplewill_guardian WHERE uid = '$uid' "; 

$query_guardian = mysqli_query($conn, $guardian) or die(mysqli_error($conn));

$totalguardian = mysqli_num_rows($query_guardian);

if ($totalguardian < '1') {
    header("Location:../simplewill-add-witness.php?a=guardiandenied");
    exit();
}

$financialguardian = "SELECT uid FROM simplewill_financial_guardian WHERE uid = '$uid' "; 

$query_financialguardian = mysqli_query($conn, $financialguardian) or die(mysqli_error($conn));

$totalfinancialguardian = mysqli_num_rows($query_financialguardian);

if ($totalfinancialguardian < '1') {
    header("Location:../simplewill-add-witness.php?a=financialguardiandenied");
    exit();
}

$ex = "SELECT uid FROM simplewill_witness_tb WHERE uid = '$uid' "; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex);

if ($totalex < '2') {
    header("Location:../simplewill-add-witness.php?a=denied");
    exit();
}


mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM simplewill_access_level  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql);

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '3') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE simplewill_access_level SET access = '3' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	//exit();

}

?>



