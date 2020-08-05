<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$pid =    $_POST['pid']; 

$query_selectasset = "SELECT `id` FROM simplewill_assets_tb WHERE `uid` = '$uid' ";
$selectasset = mysqli_query($conn, $query_selectasset) or die(mysqli_error($conn));
$totalasset = mysqli_num_rows($selectasset); 

$query_selectoverallasset = "SELECT DISTINCT `propertyid` FROM simplewill_overall_asset WHERE `uid` = '$uid' ";
$selectoverallasset = mysqli_query($conn, $query_selectoverallasset) or die(mysqli_error($conn));
$totaloverallasset = mysqli_num_rows($selectoverallasset); 

if ($totalasset != $totaloverallasset) {
    header("Location: ../simplewill-percentage-sharing.php?a=assetdenied");
}

$sql = "SELECT `uid`,`percentage` FROM simplewill_overall_asset  WHERE uid = '$uid' "; 
$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql);
if ($totalacl > 0) {
    while ($row_sql = mysqli_fetch_assoc($query_sql)) {
            $percentage += $row_sql['percentage']; 
            
        }    
        $totalpercentage = $totalasset * 100;
        if ($totalpercentage != $percentage) {
            header("Location: ../simplewill-percentage-sharing.php?a=assetdenied");
        }else{
            mysqli_select_db($conn, $database_conn);

$sql = "SELECT uid,access FROM simplewill_access_level WHERE uid = '$uid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

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
            //header("Location: ../dashboard.php");
        }
}
?>

