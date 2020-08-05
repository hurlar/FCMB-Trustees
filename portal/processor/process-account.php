<?php
session_start();
ob_start();
require_once('../Connections/conn.php'); 

$bvnnumber = $_POST['bvnnumber'];
$bankname = $_POST['bankname']; 
$anctame = $_POST['anctname']; 
$actno =     $_POST['actno'];
$acttype =    $_POST['acttype']; 
$assettype3 =    $_POST['assettype3'];
$actuid =    $_POST['actuid'];

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

if(!ctype_digit($bvnnumber)){
        header("Location: ../my-assets.php?a=bvn");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$bankname))){
        header("Location: ../my-assets.php?a=bankname");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$anctame))){
        header("Location: ../my-assets.php?a=actname");
        exit();
    }elseif(!ctype_digit($actno)){
        header("Location: ../my-assets.php?a=actno");
        exit();
    }elseif(strlen($bvnnumber) != 11){
        header("Location: ../my-assets.php?a=bvn");
        exit();
    }elseif(strlen($actno) != 10){
        header("Location: ../my-assets.php?a=actno");
        exit();
        }else{

$url1 = '../my-assets.php?a=successful';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO assets_tb (`uid`, `asset_type`, `bvn`, `account_name`,`account_no`, `bankname`,`accounttype`,`datecreated`) VALUES ('$actuid','$assettype3', '$bvnnumber', '$anctame', '$actno', '$bankname', '$acttype', NOW())";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

