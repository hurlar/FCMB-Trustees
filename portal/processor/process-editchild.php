<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$chname = $_POST['chname']; 
$chgender =     $_POST['chgender'];
$chdob =    $_POST['chdob'];
//$chdob = date("Y-m-d", strtotime($chdob1)); 
$childid =    $_POST['childid'];
$uid =    $_POST['uid']; 

$age1 = date('Y', strtotime($chdob)); 
$currentyear = date('Y');
$realage =  $currentyear - $age1; 

$url1 = '../marital-info.php?c=update';
$url2 = '../marital-info.php?c=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');
if(!ctype_alpha(str_replace($search,$replace,$chname))){
        header("Location: ../marital-info.php?c=lettersonly");
        exit();    
}else{
mysqli_select_db($conn, $database_conn);
$sql2 = "UPDATE beneficiary_dump SET `fullname` = '$chname' WHERE `childid` = '$childid' ";  
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

mysqli_select_db($conn, $database_conn);
$sql="UPDATE children_details SET `name` = '$chname', `gender` = '$chgender', `dob` =  '$chdob', `age` = '$realage' WHERE `id` = '$childid' ";  
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

