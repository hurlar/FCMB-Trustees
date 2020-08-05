<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$beneficiarytitle = $_POST['beneficiarytitle']; 
$beneficiaryname =     $_POST['beneficiaryname'];
$beneficiarydob =    $_POST['beneficiarydob'];
$beneficiaryrelationship =    $_POST['beneficiaryrelationship'];
$beneficiarystatus =    $_POST['beneficiarystatus'];
$beneficiaryid =    $_POST['beneficiaryid'];

$_SESSION['beneficiarytitle'] = $beneficiarytitle;
$_SESSION['beneficiaryname'] =     $beneficiaryname;
$_SESSION['beneficiarydob'] =    $beneficiarydob;
$_SESSION['beneficiaryrelationship'] =    $beneficiaryrelationship;
$_SESSION['beneficiaryid'] =    $beneficiaryid;

$url1 = '../investment-marital-info.php?a=successful';
$url2 = '../investment-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO investment_beneficiary (`uid`, `title`, `fullname`,`rtionship`,`dob`,`datecreated`) VALUES ('$beneficiaryid', '$beneficiarytitle', '$beneficiaryname','$beneficiaryrelationship', '$beneficiarydob', NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
    
    unset($_SESSION["beneficiarytitle"]);
    unset($_SESSION["beneficiaryname"]);
    unset($_SESSION["beneficiarydob"]);
    unset($_SESSION["beneficiaryrelationship"]);
    unset($_SESSION["beneficiaryid"]);
    
    mysqli_select_db($conn, $database_conn);
    $sqlbeneficiarystatus = "SELECT * FROM investment_beneficiary_status WHERE `uid` = '$beneficiaryid' ";
    $beneficiaryresult = mysqli_query($conn, $sqlbeneficiarystatus) or die(mysqli_error($conn));
    $totalbeneficiary = mysqli_num_rows($beneficiaryresult);
    
    if($totalbeneficiary == 1){
       $updatebeneficiarystatus = "UPDATE investment_beneficiary_status SET `status` = '$beneficiarystatus' WHERE `uid` = '$beneficiaryid' ";
    $updatebeneficiaryresult = mysqli_query($conn, $updatebeneficiarystatus) or die(mysqli_error($conn));
    header("Location: $url1");
    }else{
    $insertbeneficiarystatus = "INSERT INTO investment_beneficiary_status (`uid`, `status`) VALUES ('$beneficiaryid', '$beneficiarystatus') ";
    $insertbeneficiaryresult = mysqli_query($conn, $insertbeneficiarystatus) or die(mysqli_error($conn));
    header("Location: $url1");
    }

}
?>

