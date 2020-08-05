<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

//$ref = $_SERVER['HTTP_REFERER'];

//if($ref !== '../add-executor.php') {
  //die("Sorry !!! Direct access to this page is forbidden");
//}else{
    //echo 'yes'; exit();
//}

$a = mysqli_real_escape_string($conn, $_GET['a']);

$url1 = '../add-trustees.php?a=delete';
$url2 = '../add-trustees.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "DELETE FROM trustee_tb WHERE id = '$a' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($query_sql){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

