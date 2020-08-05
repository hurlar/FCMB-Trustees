<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$btitle = $_POST['stitle']; 
$bfname =     $_POST['sfname'];
$bemail =    $_POST['semail'];
$bphoneno =    $_POST['sphoneno'];
$baddr =    $_POST['saddr'];
$bcity =    $_POST['scity'];
$bstate =    $_POST['sstate'];
$sbid =    $_POST['sbid']; 

//echo $btitle.''.$bfname; exit();

$url1 = '../secondary-beneficiary.php?a=update';
$url2 = '../secondary-beneficiary.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$bfname))){
        header("Location: ../secondary-beneficiary.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($bphoneno)){
        header("Location: ../secondary-beneficiary.php?a=numbersonly");
        exit();
    }else{

mysqli_select_db($conn, $database_conn);
$sql2 = "UPDATE alt_beneficiary SET `title` = '$btitle', `fullname` = '$bfname', email = '$bemail', phone = '$bphoneno', addr= '$baddr', city = '$bcity', state = '$bstate' WHERE `id` = '$sbid' ";  
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($result2){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

