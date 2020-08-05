<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$btitle = $_POST['btitle']; 
$bfname =     $_POST['bfname'];
$bemail =    $_POST['bemail'];
$bphoneno =    $_POST['bphoneno'];
$brelationship =    $_POST['brelationship'];
$baddr =    $_POST['baddr'];
$bcity =    $_POST['bcity'];
$bstate =    $_POST['bstate'];
$uid =    $_POST['buid'];
$bdob =    $_POST['editdob'];

//echo $btitle.''.$bfname; exit();

$url1 = '../assets.php?a=update';
$url2 = '../assets.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$bfname))){
        header("Location: ../assets.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($bphoneno)){
        header("Location: ../assets.php?a=numbersonly");
        exit();
    }else{

mysqli_select_db($conn, $database_conn);
$sql2 = "UPDATE beneficiary_dump SET `title` = '$btitle', `fullname` = '$bfname', rtionship = '$brelationship', email = '$bemail', phone = '$bphoneno', addr= '$baddr', city = '$bcity', state = '$bstate', dob = '$bdob' WHERE `id` = '$uid' ";  
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

//mysqli_select_db($conn, $database_conn);
//$sql="UPDATE children_details SET `name` = '$chname', `gender` = '$chgender', `dob` =  '$chdob', `age` = '$realage' WHERE `id` = '$childid' ";  
//$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result2){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

