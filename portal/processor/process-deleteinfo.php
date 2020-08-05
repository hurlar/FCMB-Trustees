<?php
session_start();
ob_start();
require_once('../Connections/conn.php');
$a = $_GET['a'];
//$addinfo = $_POST['addinfo'];
//$uid = $_POST['uid'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../additional-information.php';
$url2 = '../additional-information.php';

mysqli_select_db($conn, $database_conn);
    $sql="DELETE FROM addinfo_tb WHERE uid = '$a' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

