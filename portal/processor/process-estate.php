<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$asset = $_POST['asset']; 
$beneficiary = $_POST['abeneficiary'];
    $bnf = "";  
    foreach($beneficiary as $bnf1)  
       {  
          $bnf.= $bnf1.",";  
       }
$aoption =    $_POST['aoption']; 
$acomment =    $_POST['acomment'];
$auid =    $_POST['auid'];

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO estate_tb (`uid`, `asset`, `beneficiaries`,`option`,`comment`,`datecreated`) VALUES ('$auid', '$asset', '$bnf', '$aoption', '$acomment', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

