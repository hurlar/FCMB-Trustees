<?php
session_start();
ob_start();
require_once('../Connections/conn.php'); 

$edtbvnnumber = $_POST['edtbvnnumber'];
$edtbankname = $_POST['edtbankname']; 
$edtanctname = $_POST['edtanctname']; 
$edtactno =     $_POST['edtactno'];
$edtacttype =    $_POST['edtacttype']; 
$edtbankdetailsid =    $_POST['edtbankdetailsid'];

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

if(!ctype_digit($edtbvnnumber)){
        header("Location: ../simplewill-beneficiary.php?a=bvnnumber");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$edtbankname))){
        header("Location: ../simplewill-beneficiary.php?a=bankname");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$edtanctname))){
        header("Location: ../simplewill-beneficiary.php?a=actname");
        exit();
    }elseif(!ctype_digit($edtactno)){
        header("Location: ../simplewill-beneficiary.php?a=actno");
        exit();
    }elseif(strlen($edtbvnnumber) != 11){
        header("Location: ../simplewill-beneficiary.php?a=bvn");
        exit();
    }elseif(strlen($edtactno) != 10){
        header("Location: ../simplewill-beneficiary.php?a=actno");
        exit();
        }else{

$url1 = '../simplewill-beneficiary.php?a=successful';
$url2 = '../simplewill-beneficiary.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE simplewill_assets_tb SET `bvn` = '$edtbvnnumber', `account_name` = '$edtanctname', `account_no` = '$edtactno' , `bankname` = '$edtbankname',`accounttype` = '$edtacttype' WHERE `id` = '$edtbankdetailsid' ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

