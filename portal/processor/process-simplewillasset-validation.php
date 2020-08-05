<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

mysqli_select_db($conn, $database_conn);

$ex = "SELECT uid FROM simplewill_assets_tb WHERE uid = '$uid' AND `asset_type` = 'bankaccount'"; 

$query_ex = mysqli_query($conn, $ex) or die(mysqli_error($conn));

$totalex = mysqli_num_rows($query_ex); 

if ($totalex < '1') {
    header("Location:../simplewill-beneficiary.php?a=asset-denied"); 
    exit();
}

mysqli_select_db($conn, $database_conn);

$pension = "SELECT uid FROM simplewill_assets_tb WHERE uid = '$uid' AND `asset_type` = 'pension' "; 

$query_pension = mysqli_query($conn, $pension) or die(mysqli_error($conn));

$totalpension = mysqli_num_rows($query_pension); 

if ($totalpension < '1') {
    header("Location:../simplewill-beneficiary.php?a=pension-denied"); 
    exit();
}

mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid FROM simplewill_beneficiary  WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalbeneficiary = mysqli_num_rows($query_sql); 

if ($totalbeneficiary < '1') {
	header("Location:../simplewill-beneficiary.php?a=beneficiary-denied");
	exit();
}else{
    header("Location: ../simplewill-percentage-sharing.php");
}

?>



