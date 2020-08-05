<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$addinfo = $_POST['addinfo'];
$uid = $_POST['uid'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../additional-information.php?a=successful';
$url2 = '../additional-information.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO  addinfo_tb (`uid`, `addinfo`, `datecreated`) VALUES ('$uid','$addinfo', NOW())";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

