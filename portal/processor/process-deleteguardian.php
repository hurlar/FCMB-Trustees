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

$url1 = '../add-guardian.php?a=delete';
$url2 = '../add-guardian.php?a=error';

mysqli_select_db($conn, $database_conn);
//$sql2 = "DELETE FROM children_details WHERE id = '$a' "; 
$sql2 = "UPDATE children_details SET `title` = null, `guardianname` = null, `rtionship` = null, `email` = null, `phone` = null, `addr` = null, `city` = null, `state` = null, `stipend` = null WHERE id = '$a' ";
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($query_sql){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

