<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$percentage = $_POST['percentage']; 
$propertyid = $_POST['propertyid']; 
$propertytype = $_POST['propertytype']; 
$uid = $_POST['uid']; 
$beneficiaryid = $_POST['beneficiaryid']; 

$url1 = '../percentage-sharing.php?a=successful';
$url2 = '../percentage-sharing.php?a=error';
$url3 = '../percentage-sharing.php?a=updated';

mysqli_select_db($conn, $database_conn);
$query_select = "SELECT * FROM overall_asset WHERE uid = '$uid' AND beneficiaryid = '$beneficiaryid' AND propertyid = '$propertyid' ";
$select = mysqli_query($conn, $query_select) or die(mysqli_error($conn));
$totalselect = mysqli_num_rows($select);
if ($totalselect > 0) {
    $query_update = "UPDATE overall_asset SET percentage = '$percentage', property_type = '$propertytype' WHERE uid = '$uid' AND beneficiaryid = '$beneficiaryid' AND propertyid = '$propertyid'";
    $update = mysqli_query($conn, $query_update) or die(mysqli_error($conn));
    header("Location: $url3"); 
}else{
$sql="INSERT INTO overall_asset (`uid`, `beneficiaryid`, `propertyid`,`property_type`,`percentage`,`datecreated`) VALUES ('$uid', '$beneficiaryid', '$propertyid', '$propertytype', '$percentage', NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
header("Location: $url1"); 
}

?>

