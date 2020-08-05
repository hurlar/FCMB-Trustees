<?php
session_start();
ob_start();
require_once('../Connections/conn.php');
$a = $_GET['a'];

$url1 = '../education-beneficiary.php';
$url2 = '../education-beneficiary.php';

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM education_beneficiary WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($query_sql){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

