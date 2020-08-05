<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gtitle = $_POST['ttitle'];
$gname = $_POST['tname'];
$gemail = $_POST['temail'];
$gphoneno = $_POST['tphoneno'];
$grelationship = $_POST['trelationship'];
$gaddr = $_POST['taddr'];
$gcity = $_POST['tcity'];
$gstate = $_POST['tstate'];
$trusteesid = $_POST['tid']; 

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../add-trustees.php?a=update';
$url2 = '../add-trustees.php?a=error';
    
    $search  = array('&', '-', ' ', '.');
    $replace = array('');
    
    if(!ctype_alpha(str_replace($search,$replace,$gname))){
        header("Location: ../add-trustees.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($gphoneno)){
        header("Location: ../add-trustees.php?a=numbersonly");
        exit();
    }else{
        
$gtitle = trim($gtitle);
$gname = trim($gname);
$gemail = trim($gemail);
$gphoneno = trim($gphoneno);
$grelationship = trim($grelationship);
$gaddr = trim($gaddr);
$gcity = trim($gcity);
$gstate = trim($gstate);

$gtitle = stripslashes($gtitle);
$gname = stripslashes($gname);
$gemail = stripslashes($gemail);
$gphoneno = stripslashes($gphoneno);
$grelationship = stripslashes($grelationship);
$gaddr = stripslashes($gaddr);
$gcity = stripslashes($gcity);
$gstate = stripslashes($gstate);

$gtitle = mysqli_real_escape_string($conn, $gtitle);
$gname = mysqli_real_escape_string($conn, $gname);
$gemail = mysqli_real_escape_string($conn, $gemail);
$gphoneno = mysqli_real_escape_string($conn, $gphoneno);
$grelationship = mysqli_real_escape_string($conn, $grelationship);
$gaddr = mysqli_real_escape_string($conn, $gaddr);
$gcity = mysqli_real_escape_string($conn, $gcity);
$gstate = mysqli_real_escape_string($conn, $gstate);


mysqli_select_db($conn, $database_conn);
$sql="UPDATE trustee_tb SET `title` = '$gtitle', `fullname` = '$gname', `rtionship` = '$grelationship', `email` = '$gemail', `phone` = '$gphoneno', `addr` = '$gaddr', `city` = '$gcity', `state` = '$gstate' WHERE id = '$trusteesid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

