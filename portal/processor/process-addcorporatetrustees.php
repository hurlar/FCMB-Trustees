<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$ctitle = $_POST['ctitle'];
$cname = $_POST['cname'];
$cemail = $_POST['cemail'];
$cphoneno = $_POST['cphoneno'];
$caddr = $_POST['caddr'];
$uid = $_POST['uid'];

$_SESSION['cname'] = $cname;
$_SESSION['cemail'] = $cemail;
$_SESSION['cphoneno'] = $cphoneno;
$_SESSION['caddr'] = $caddr;
$_SESSION['uid'] = $uid;

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../add-trustees.php?a=successful';
$url2 = '../add-trustees.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');
    if(!ctype_digit($cphoneno)){
        header("Location: ../add-trustees.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO  trustee_tb (`uid`, `title`, `fullname`,`email`,`phone`,`addr`,`datecreated`) VALUES ('$uid', '$ctitle', '$cname','$cemail', '$cphoneno', '$caddr', NOW())";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["cname"]);
unset($_SESSION["cemail"]);
unset($_SESSION["cphoneno"]);
unset($_SESSION["caddr"]);
unset($_SESSION["uid"]);
header("Location: $url1");
}
}
?>

