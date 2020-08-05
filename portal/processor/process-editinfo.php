<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$addinfo = $_POST['addinfo'];
$uid = $_POST['uid'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../additional-information.php?a=update';
$url2 = '../additional-information.php?a=error';

mysqli_select_db($conn, $database_conn);
    $sql="UPDATE addinfo_tb SET addinfo = '$addinfo' WHERE uid = '$uid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

