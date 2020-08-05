<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$uid =    $_POST['uid'];
$willtype = $_POST['willtype'];
$fullname = $_POST['fullname'];  
$addr =     $_POST['addr'];
$email =    $_POST['email'];
$phone =    $_POST['phone'];
$aphone =    $_POST['aphone'];
$gender =    $_POST['gender'];
$dob =    $_POST['dob'];
$state =    $_POST['state'];
$nationality =    $_POST['nationality'];
$lga =    $_POST['lga'];
$maidenname =    $_POST['maidenname'];
$identificationtype =    $_POST['identificationtype'];
$idnumber =    $_POST['idnumber'];
$issuedate =    $_POST['issuedate'];
$expirydate =    $_POST['expirydate'];
$issueplace =    $_POST['issueplace'];
$employmentstatus =    $_POST['employmentstatus'];
$employer =    $_POST['employer'];
$employerphone =    $_POST['employerphone'];
$employeraddr =    $_POST['employeraddr'];
$maritalstatus =    $_POST['maritalstatus']; 
$spousename =    $_POST['spousename']; 
$spouseemail =    $_POST['spouseemail'];
$spousephone =    $_POST['spousephone'];
$spousedob =    $_POST['spousedob'];
$spouseaddr =    $_POST['spouseaddr'];
$spousecity =    $_POST['spousecity'];
$spousestate =    $_POST['spousestate'];
$marriagetype =    $_POST['marriagetype'];
$marriageyear =    $_POST['marriageyear'];
$marriagecert =    $_POST['marriagecert'];
$cityofmarriage =    $_POST['cityofmarriage'];
$countryofmarriage =    $_POST['countryofmarriage'];
$divorce      =    $_POST['divorce'];
$divorceyear =    $_POST['divorceyear'];
$nextofkinfullname =    $_POST['nextofkinfullname'];   
$nextofkintelephone =    $_POST['nextofkintelephone'];   
$nextofkinemail =    $_POST['nextofkinemail'];   
$nextofkinaddress =    $_POST['nextofkinaddress'];  
$requestamount =    $_POST['request_amount'];
$investment_returns =    $_POST['investment_returns'];
$principal =    $_POST['principal'];
$trustperiod =    $_POST['trustperiod'];
$additionalinvestment =    $_POST['additionalinvestment'];
$returntoBeneficiary =    $_POST['returntoBeneficiary']; 
$paymentofInvestmentreturns =    $_POST['paymentofInvestmentreturns']; 
$paymentofreturns =    $_POST['paymentofreturns']; 

$url1 = '../process-completed.php';

$url2 = '../reservetrustform-preview.php?a=error';

mysqli_select_db($conn, $database_conn);
$query_select = "SELECT `id`,`uid` FROM reservetrust_tb WHERE `uid` = '$uid' ";
$result_select = mysqli_query($conn, $query_select) or die (mysqli_error($conn));
$total_select = mysqli_num_rows($result_select);
if($total_select == 1){
    $query_update = "UPDATE reservetrust_tb SET `willtype` = '$willtype',  `fullname` = '$fullname', `address` = '$addr', `email` = '$email', `phoneno` =  '$phone', `aphoneno` =  '$aphone', `gender` = '$gender', `dob` = '$dob', `state` = '$state', `nationality` = '$nationality', `lga` = '$lga', `maidenname` = '$maidenname', `identificationtype` = '$identificationtype', `idnumber` = '$idnumber', `issuedate` = '$issuedate', `expirydate` = '$expirydate', `issueplace` = '$issueplace', `expirydate` = '$expirydate', `issueplace` = '$issueplace', `employmentstatus` = '$employmentstatus', `employer` = '$employer', `employerphone` = '$employerphone', `employeraddr` = '$employeraddr', `maritalstatus` = '$maritalstatus', `spousename` = '$spousename', `spouseemail` = '$spouseemail', `spousephone` = '$spousephone', `spousedob` = '$spousedob', `spouseaddr` = '$spouseaddr', `spousecity` = '$spousecity', `spousestate` = '$spousestate', `marriagetype` = '$marriagetype', `marriageyear` = '$marriageyear', `marriagecert` = '$marriagecert', `cityofmarriage` = '$cityofmarriage', `countryofmarriage` = '$countryofmarriage', `divorce` = '$divorce', `divorceyear` = '$divorceyear', `nextofkinfullname` = '$nextofkinfullname', `nextofkintelephone` = '$nextofkintelephone', `nextofkinemail` = '$nextofkinemail', `nextofkinaddress` = '$nextofkinaddress', `request_amount` = '$requestamount', `investment_returns` = '$investment_returns', `principal` = '$principal', `trustperiod` = '$trustperiod', `additionalinvestment` = '$additionalinvestment', `returntoBeneficiary` = '$returntoBeneficiary', `paymentofInvestmentreturns` = '$paymentofInvestmentreturns', `paymentofreturns` = '$paymentofreturns', `datecreated` = NOW() WHERE `uid` = '$uid'  ";
    $result_update = mysqli_query($conn, $query_update) or die(mysqli_error($conn));

      if($result_update){

      header("Location: $url1"); 

      } else {

      header("Location: $url2");

      }
}else{
    $sql="INSERT INTO reservetrust_tb (uid, willtype, fullname, address, email, phoneno, aphoneno, gender, dob, state, nationality, lga, maidenname, identificationtype, idnumber, issuedate, expirydate, issueplace, employmentstatus, employer, employerphone, employeraddr, maritalstatus, spousename, spouseemail, spousephone, spousedob, spouseaddr, spousecity, spousestate, marriagetype, marriageyear, marriagecert, cityofmarriage, countryofmarriage, divorce, divorceyear, nextofkinfullname, nextofkintelephone, nextofkinemail, nextofkinaddress, request_amount, investment_returns, principal, trustperiod, additionalinvestment, returntoBeneficiary, paymentofInvestmentreturns, paymentofreturns, datecreated) VALUES ('$uid', '$willtype', '$fullname', '$addr', '$email', '$phone', '$aphone', '$gender', '$dob', '$state', '$nationality', '$lga', '$maidenname', '$identificationtype', '$idnumber', '$issuedate', '$expirydate', '$issueplace', '$employmentstatus', '$employer', '$employerphone', '$employeraddr', '$maritalstatus', '$spousename', '$spouseemail', '$spousephone', '$spousedob', '$spouseaddr', '$spousecity', '$spousestate', '$marriagetype', '$marriageyear', '$marriagecert', '$cityofmarriage', '$countryofmarriage', '$divorce', '$divorceyear', '$nextofkinfullname', '$nextofkintelephone', '$nextofkinemail', '$nextofkinaddress', '$requestamount', '$investment_returns', '$principal', '$trustperiod', '$additionalinvestment', '$returntoBeneficiary', '$paymentofInvestmentreturns', '$paymentofreturns', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}
}



?>



