<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$requestamount = $_POST['request_amount']; 
$investmentreturns =     $_POST['investment_returns'];
$principal =    $_POST['principal'];
$trustperiod =    $_POST['trustperiod'];
$additionalinvestment =    $_POST['additionalinvestment'];
$returntoBeneficiary =    $_POST['returntoBeneficiary'];
$paymentofInvestmentreturns =    $_POST['paymentofInvestmentreturns'];
$paymentofreturns =    $_POST['paymentofreturns'];
$investmentsavingsid =    $_POST['investmentsavingsid'];

$_SESSION['requestamount'] = $requestamount;
$_SESSION['investmentreturns'] =     $investmentreturns;
$_SESSION['principal'] =    $principal;
$_SESSION['trustperiod'] =    $trustperiod;
$_SESSION['additionalinvestment'] =    $additionalinvestment;
$_SESSION['returntoBeneficiary'] =    $returntoBeneficiary;
$_SESSION['paymentofInvestmentreturns'] =    $paymentofInvestmentreturns;
$_SESSION['paymentofreturns'] =    $paymentofreturns;
$_SESSION['investmentsavingsid'] =    $investmentsavingsid;

$url1 = '../dashboard.php';
$url2 = '../request-savings.php?a=error';

mysqli_select_db($conn, $database_conn);
$selectinvestment = "SELECT `id`,`uid` FROM `investment_request_savings` WHERE `uid` = '$investmentsavingsid' ";
$resultselectinvestment = mysqli_query($conn, $selectinvestment) or die (mysqli_error($conn));
$totalselectinvestment = mysqli_num_rows($resultselectinvestment); 

if($totalselectinvestment == 1){
    $updateinvestment = "UPDATE investment_request_savings SET `investment_sum` = '$requestamount', `investment_returns` = '$investmentreturns', `principal_fund` = '$principal', `investment_period` = '$trustperiod', `additional_investment` = '$additionalinvestment', `pay_both_to_beneficiaries` = '$returntoBeneficiary', `pay_returns_only_to_beneficiaries` = '$paymentofInvestmentreturns', `reinvest_entire_principal` = '$paymentofreturns', `datecreated` = NOW() WHERE `uid` = '$investmentsavingsid' ";
    $resultupdateinvestment = mysqli_query($conn, $updateinvestment) or die (mysqli_error($conn));
    if($resultupdateinvestment == TRUE){
     $updateinvestmentaccesslevel = "UPDATE investment_access_level SET access = '2' WHERE uid = '$investmentsavingsid' "; 
    $resultupdateinvestmentaccesslevel = mysqli_query($conn, $updateinvestmentaccesslevel) or die(mysqli_error($conn));
    header("Location: $url1");
    }else{
        header("Location: $url2");
    }
}else{
    $insertinvestment = "INSERT INTO investment_request_savings (`uid`, `investment_sum`, `investment_returns`,`principal_fund`,`investment_period`,`additional_investment`,`pay_both_to_beneficiaries`,`pay_returns_only_to_beneficiaries`,`reinvest_entire_principal`,`datecreated`) VALUES ('$investmentsavingsid', '$requestamount', '$investmentreturns','$principal', '$trustperiod', '$additionalinvestment','$returntoBeneficiary', '$paymentofInvestmentreturns', '$paymentofreturns', NOW())";
    
    $resultinsertinvestment = mysqli_query($conn, $insertinvestment) or die(mysqli_error($conn));
    
    if($resultinsertinvestment == TRUE){
       $update = "UPDATE investment_access_level SET access = '2' WHERE uid = '$investmentsavingsid' "; 
       $update_run1 = mysqli_query($conn, $update) or die(mysqli_error($conn));
    	header("Location: $url1");
    } else {
        header("Location: $url2"); 
    }
}

?>

