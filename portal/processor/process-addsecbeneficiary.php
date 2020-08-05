<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$stitle = $_POST['stitle']; 
$sfname =     $_POST['sfname'];
$semail =    $_POST['semail'];
$sphoneno =    $_POST['sphoneno'];
$saddr =    $_POST['saddr'];
$scity =    $_POST['scity'];
$sstate =    $_POST['sstate'];
$suid =    $_POST['suid'];
$status =    $_POST['status'];
$childid =    $_POST['childid'];

$_SESSION['stitle'] = $stitle; 
$_SESSION['sfname'] = $sfname;
$_SESSION['semail'] = $semail;
$_SESSION['sphoneno'] = $sphoneno;
$_SESSION['saddr'] = $saddr;
$_SESSION['scity'] = $scity;
$_SESSION['sstate'] = $sstate;
$_SESSION['suid'] = $suid;
$_SESSION['status'] = $status;
$_SESSION['childid'] = $childid;


$url1 = '../secondary-beneficiary.php?a=successful';
$url2 = '../secondary-beneficiary.php.php?a=error';
$url3 = '../my-assets.php';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$sfname))){
        header("Location: ../secondary-beneficiary.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($sphoneno)){
        header("Location: ../secondary-beneficiary.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO alt_beneficiary (`uid`, `childid`, `title`, `fullname`, `email`,`phone`,`addr`,`city`,`state`,`status`,`datecreated`) VALUES ('$suid', '$childid','$stitle', '$sfname', '$semail', '$sphoneno', '$saddr', '$scity', '$sstate','$status',NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["stitle"]);
unset($_SESSION["sfname"]);
unset($_SESSION["semail"]);
unset($_SESSION["sphoneno"]);
unset($_SESSION["saddr"]);
unset($_SESSION["scity"]);
unset($_SESSION["sstate"]);
unset($_SESSION["suid"]);
unset($_SESSION["status"]);
unset($_SESSION["childid"]);

header("Location: $url1");
}
}
?>

