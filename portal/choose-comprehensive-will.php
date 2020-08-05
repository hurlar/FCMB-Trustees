<?php
session_start();
ob_start();
require_once('Connections/conn.php'); 
include ('session.php');

$willtype = 'Comprehensive Will';
$amount = ' ';
//echo $userid = $_POST['userid'];  exit();


mysqli_select_db($conn, $database_conn);

$sql = "SELECT * FROM willtype WHERE uid = '$userid' "; 

$query_sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$totalacl = mysqli_num_rows($query_sql); 

if ($totalacl == TRUE) {

    $update1 = "UPDATE `willtype` SET `name` = '$willtype',`amount` = '$amount' WHERE `uid` = '$userid' "; 

    $update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));

    header("Location: dashboard.php");

    exit();

}else{

    $insert1 = "INSERT INTO willtype (uid, name, amount) VALUES ('$userid', '$willtype', '$amount')";

    $insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));

    header("Location: dashboard.php");

}

?>

