<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$a = mysqli_real_escape_string($conn, $_GET['a']);

$url1 = '../simplewill-beneficiary.php?a=delete';
$url2 = '../simplewill-beneficiary.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM simplewill_financial_guardian WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($query_sql){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

