<?php
session_start();
ob_start();
require_once('../Connections/conn.php');
$a = $_GET['a'];

$url1 = '../marital-info.php';
$url2 = '../marital-info.php';

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM children_details WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($query_sql){
mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM beneficiary_dump WHERE childid = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

