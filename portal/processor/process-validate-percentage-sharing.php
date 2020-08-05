<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$pid =    $_POST['pid']; 

$query_selectasset = "SELECT `id`,`asset_type` FROM assets_tb WHERE `uid` = '$uid' AND `asset_type` != 'Personal Chattels'  ";
$selectasset = mysqli_query($conn, $query_selectasset) or die(mysqli_error($conn));
$totalasset = mysqli_num_rows($selectasset); 

$query_selectoverallasset = "SELECT DISTINCT `propertyid` FROM overall_asset WHERE `uid` = '$uid' ";
$selectoverallasset = mysqli_query($conn, $query_selectoverallasset) or die(mysqli_error($conn));
$totaloverallasset = mysqli_num_rows($selectoverallasset); 

if ($totalasset != $totaloverallasset) {
    header("Location: ../percentage-sharing.php?a=assetdenied");
}

$sql = "SELECT `uid`,`percentage` FROM overall_asset  WHERE uid = '$uid' "; 
$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql);
if ($totalacl > 0) {
    while ($row_sql = mysqli_fetch_assoc($query_sql)) {
            $percentage += $row_sql['percentage']; 
            
        }    
        $totalpercentage = $totalasset * 100;
        if ($totalpercentage != $percentage) {
            header("Location: ../percentage-sharing.php?a=assetdenied");
            exit();
        }else{
            //header("Location: ../dashboard.php");
            mysqli_select_db($conn, $database_conn);

            $sqlaccess = "SELECT `uid`,`access` FROM access_level  WHERE `uid` = '$uid' "; 
            
            $query_sqlaccess = mysqli_query($conn, $sqlaccess) or die(mysqli_error($conn));
            
            $row_access = mysqli_fetch_assoc($query_sqlaccess); 
            
            $totalaccess = mysqli_num_rows($query_sqlaccess); 
            
            if ($row_access['access'] > '2') {
            	header("Location:../dashboard.php");
            	exit();
            }
            
            if ($totalaccess == TRUE) {
            
            	$update1 = "UPDATE access_level SET access = '2' WHERE uid = '$uid' "; 
            
            	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
            
            	header("Location: ../dashboard.php");
            
            	//exit();
            
            }else{
            
            	$insert1 = "INSERT INTO access_level (uid, access) VALUES ('$uid', '2')";
            
            	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
            
            	header("Location: ../dashboard.php");
            
            }
        }
}

?>

