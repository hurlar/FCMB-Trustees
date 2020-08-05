<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gtitle = $_POST['gtitle'];
$gname = $_POST['gname'];
$gemail = $_POST['gemail'];
$gphoneno = $_POST['gphoneno'];
$grelationship = $_POST['grelationship'];
$gaddr = $_POST['gaddr'];
$gcity = $_POST['gcity'];
$gstate = $_POST['gstate'];
$gstipend = $_POST['gstipend'];
$guardianid = $_POST['guardianid']; 

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../add-guardian.php?a=upate';
$url2 = '../add-guardian.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$gname))){
        header("Location: ../add-guardian.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($gphoneno)){
        header("Location: ../add-guardian.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="UPDATE children_details SET `title` = '$gtitle', `guardianname` = '$gname', `rtionship` = '$grelationship', `email` = '$gemail', `phone` = '$gphoneno', `addr` = '$gaddr', `city` = '$gcity', `state` = '$gstate', `stipend` = '$gstipend' WHERE id = '$guardianid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

