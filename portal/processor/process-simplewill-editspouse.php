<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$stitle = $_POST['stitle']; 
$sfname =     $_POST['sfname'];
$semail =    $_POST['semail'];
$sphoneno =    $_POST['sphoneno'];
$saltphoneno =    $_POST['saltphoneno'];
$saddr =    $_POST['saddr'];
$scity =    $_POST['scity'];
$sstate =    $_POST['sstate'];
$suid =    $_POST['suid'];
$stype =    $_POST['stype'];
$syear =    $_POST['syear'];
$scert =    $_POST['scert'];
$sdob =    $_POST['sdob'];
//$dob =date("Y-m-d", strtotime($dob1)); 
$citym =    $_POST['citym'];
$countrym =    $_POST['countrym'];

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$sfname))){
        header("Location: ../simplewill-marital-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($sphoneno)){
        header("Location: ../simplewill-marital-info.php?a=numbersonly");
        exit();
    }else{
        
        $stitle = trim($stitle);
$sfname =     trim($sfname);
$semail =    trim($semail);
$sphoneno =    trim($sphoneno);
$saltphoneno =    trim($saltphoneno);
$saddr =    trim($saddr);
$scity =    trim($scity);
$sstate =    trim($sstate);
$suid =    trim($suid);
$status =    trim($status);
$stype =    trim($stype);
$syear =    trim($syear);
$scert =    trim($scert);
$sdob =    trim($sdob);
$citym =    trim($citym);
$countrym =    trim($countrym);

$stitle = stripslashes($stitle);
$sfname =     stripslashes($sfname);
$semail =    stripslashes($semail);
$sphoneno =    stripslashes($sphoneno);
$saltphoneno =    stripslashes($saltphoneno);
$saddr =    stripslashes($saddr);
$scity =    stripslashes($scity);
$sstate =    stripslashes($sstate);
$suid =    stripslashes($suid);
$status =    stripslashes($status);
$stype =    stripslashes($stype);
$syear =    stripslashes($syear);
$scert =    stripslashes($scert);
$sdob =    stripslashes($sdob);
$citym =    stripslashes($citym);
$countrym =    stripslashes($countrym);

$stitle = mysqli_real_escape_string($conn, $stitle);
$sfname =     mysqli_real_escape_string($conn, $sfname);
$semail =    mysqli_real_escape_string($conn, $semail);
$sphoneno =    mysqli_real_escape_string($conn, $sphoneno);
$saltphoneno =    mysqli_real_escape_string($conn, $saltphoneno);
$saddr =    mysqli_real_escape_string($conn, $saddr);
$scity =    mysqli_real_escape_string($conn, $scity);
$sstate =    mysqli_real_escape_string($conn, $sstate);
$suid =    mysqli_real_escape_string($conn, $suid);
$status =    mysqli_real_escape_string($conn, $status);
$stype =    mysqli_real_escape_string($conn, $stype);
$syear =    mysqli_real_escape_string($conn, $syear);
$scert =    mysqli_real_escape_string($conn, $scert);
$sdob =    mysqli_real_escape_string($conn, $sdob);
$citym =    mysqli_real_escape_string($conn, $citym);
$countrym =    mysqli_real_escape_string($conn, $countrym);

$url1 = '../simplewill-marital-info.php?a=update';
$url2 = '../simplewill-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="UPDATE spouse_tb SET `title` = '$stitle', `fullname` = '$sfname', `email` =  '$semail', `phoneno` = '$sphoneno', `altphoneno` = '$saltphoneno', `addr` = '$saddr', `city` = '$scity', `state` = '$sstate', `marriagetype` = '$stype', `marriageyear` = '$syear', `marriagecert` = '$scert', `dob` = '$sdob', `citym` = '$citym', `countrym` = '$countrym' WHERE `id` = '$suid' ";  

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
}
?>

