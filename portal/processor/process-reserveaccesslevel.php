<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$mstatus =    $_POST['mstatus'];
$beneficiaries =    $_POST['beneficiaries'];


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
$investmentbeneficiary = "SELECT uid FROM reserve_beneficiary_status WHERE uid = '$uid' "; 
$resultinvestmentbeneficiary = mysqli_query($conn, $investmentbeneficiary) or die(mysqli_error($conn));
$rowinvestmentbeneficiary = mysqli_num_rows($resultinvestmentbeneficiary);  
if ($rowinvestmentbeneficiary == TRUE) {
	$updateinvestmentbeneficiary = "UPDATE reserve_beneficiary_status SET status = '$beneficiaries' WHERE uid = '$uid'"; 
	$resultupdateinvestmentbeneficiary = mysqli_query($conn, $updateinvestmentbeneficiary) or die(mysqli_error($conn));
}else{
	$insertinvestmentbeneficiary = "INSERT INTO reserve_beneficiary_status (uid, status) VALUES ('$uid', '$beneficiaries') ";
	$resultinsertinvestmentbeneficiary = mysqli_query($conn, $insertinvestmentbeneficiary) or die(mysqli_error($conn));
}

mysqli_select_db($conn, $database_conn);
$query_nextofkin = "SELECT  `id`, `uid` FROM reserve_nextofkin WHERE uid = '$uid' "; 
$nextofkin = mysqli_query($conn, $query_nextofkin) or die(mysqli_error($conn));
$totalnextofkin = mysqli_num_rows($nextofkin);
if($totalnextofkin < 1){
    	header("Location:../reserve-marital-info.php?a=nextofkin");
	exit();
}


mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM reserve_access_level WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql); 

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > 1) {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE reserve_access_level SET access = '1' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	//exit();

}else{

	$insert1 = "INSERT INTO reserve_access_level (uid, access) VALUES ('$uid', '1')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}

?>



