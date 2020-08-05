<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gname = $_POST['tname'];
$gemail = $_POST['temail'];
$gphoneno = $_POST['tphoneno'];
$gaddr = $_POST['taddr'];
$trusteesid = $_POST['tid']; 

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../add-trustees.php?a=update';
$url2 = '../add-trustees.php?a=error';
    
    //$search  = array('&', '-', ' ', '.');
    //$replace = array('');
    
    //if(!ctype_alpha(str_replace($search,$replace,$gname))){
        //header("Location: ../add-trustees.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($gphoneno)){
        //header("Location: ../add-trustees.php?a=numbersonly");
        //exit();
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
$sql="UPDATE trustee_tb SET `fullname` = '$gname', `email` = '$gemail', `phone` = '$gphoneno', `addr` = '$gaddr' WHERE id = '$trusteesid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
//}
?>

