<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gname = $_POST['gname'];
$gemail = $_POST['gemail'];
$gphoneno = $_POST['gphoneno'];
$gaddr = $_POST['gaddr'];
$executorid = $_POST['uid']; 

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../add-executor.php?a=update';
$url2 = '../add-executor.php?a=error';
    
   // $search  = array('&', '-', ' ', '.');
    //$replace = array('');
    
    //if(!ctype_alpha(str_replace($search,$replace,$gname))){
      //  header("Location: ../add-executor.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($gphoneno)){
      //  header("Location: ../add-executor.php?a=numbersonly");
    //    exit();
    //}else{
        
$gname = trim($gname);
$gemail = trim($gemail);
$gphoneno = trim($gphoneno);
$gaddr = trim($gaddr);

$gname = stripslashes($gname);
$gemail = stripslashes($gemail);
$gphoneno = stripslashes($gphoneno);
$gaddr = stripslashes($gaddr);

$gname = mysqli_real_escape_string($conn, $gname);
$gemail = mysqli_real_escape_string($conn, $gemail);
$gphoneno = mysqli_real_escape_string($conn, $gphoneno);
$gaddr = mysqli_real_escape_string($conn, $gaddr);


mysqli_select_db($conn, $database_conn);
$sql="UPDATE executor_tb SET `fullname` = '$gname', `email` = '$gemail', `phone` = '$gphoneno', `addr` = '$gaddr' WHERE id = '$executorid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
//}
?>

