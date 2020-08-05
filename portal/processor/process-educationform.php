<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

$willtype =    $_POST['willtype'];

$uid =    $_POST['uid'];

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

$earning =    $_POST['earning'];   

$otherspecify =    $_POST['otherspecify'];   

$annualincome =    $_POST['annualincome'];   

$purposeoftrust =    $_POST['purposeoftrust'];  

$nameoftrust =    $_POST['nameoftrust'];

$initialcontribution =    $_POST['initialcontribution']; 

$url1 = '../educationtrustform-preview.php?a=successful';

$url2 = '../educationtrustform-preview.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO education_tb (uid, willtype, fullname, address, email, phoneno, aphoneno, gender, dob, state, nationality, lga, maidenname, identificationtype, idnumber, issuedate, expirydate, issueplace, employmentstatus, employer, employerphone, employeraddr, maritalstatus, spousename, spouseemail, spousephone, spousedob, spouseaddr, spousecity, spousestate, marriagetype, marriageyear, marriagecert, cityofmarriage, countryofmarriage, divorce, divorceyear, earning, otherspecify, annualincome, purposeoftrust, nameoftrust, initialcontribution, datecreated) VALUES ('$uid', '$willtype', '$fullname', '$addr', '$email', '$phone', '$aphone', '$gender', '$dob', '$state', '$nationality', '$lga', '$maidenname', '$identificationtype', '$idnumber', '$issuedate', '$expirydate', '$issueplace', '$employmentstatus', '$employer', '$employerphone', '$employeraddr', '$maritalstatus', '$spousename', '$spouseemail', '$spousephone', '$spousedob', '$spouseaddr', '$spousecity', '$spousestate', '$marriagetype', '$marriageyear', '$marriagecert', '$cityofmarriage', '$countryofmarriage', '$divorce', '$divorceyear', '$earning', '$otherspecify', '$annualincome', '$purposeoftrust', '$nameoftrust', '$initialcontribution', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



