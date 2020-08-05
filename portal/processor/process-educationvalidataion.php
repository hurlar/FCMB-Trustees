<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$uid =    $_POST['uid'];

$query_selectasset = "SELECT `id`, `uid` FROM education_beneficiary WHERE `uid` = '$uid' ";
$selectasset = mysqli_query($conn, $query_selectasset) or die(mysqli_error($conn));
$totalasset = mysqli_num_rows($selectasset); 

if ($totalasset < '1') {
    header("Location: ../education-beneficiary.php?a=beneficiary-denied");
}

$sql = "SELECT `uid`,`percentage` FROM education_beneficiary  WHERE uid = '$uid' "; 
$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql);
if ($totalacl > 0) {
    while ($row_sql = mysqli_fetch_assoc($query_sql)) {
            $percentage += $row_sql['percentage']; 
            
        }    
        $totalpercentage = 100;
        if ($percentage != $totalpercentage) {
            header("Location: ../education-beneficiary.php?a=percentage-denied");
            exit();
        }

}

mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM education_access_level WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$row_access = mysqli_fetch_assoc($query_sql); 

$totalacl = mysqli_num_rows($query_sql); 

if ($row_access['access'] > '2') {
	header("Location:../dashboard.php");
	exit();
}

if ($totalacl == TRUE) {

	$update1 = "UPDATE education_access_level SET access = '2' WHERE uid = '$uid' "; 

	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

	//exit();

}else{

	$insert1 = "INSERT INTO education_access_level (uid, access) VALUES ('$uid', '2')";

	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

	header("Location: ../dashboard.php");

}
?>

