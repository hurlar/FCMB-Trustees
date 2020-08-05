<?php

session_start();

ob_start();

require_once('../Connections/conn.php');



$fullname = $_POST['fullname'];  

$addr =     $_POST['addr'];

$mailingaddr =     $_POST['mailingaddr'];

$email =    $_POST['email'];

$maidenname =    $_POST['maidenname'];

$phone =    $_POST['phone'];

$aphone =    $_POST['aphone']; 

$maritalstatus =    $_POST['maritalstatus']; 

$gender =    $_POST['gender'];

$dob =    $_POST['dob'];

$state =    $_POST['state'];

$nationality =    $_POST['nationality'];

$spname =    $_POST['spname']; 

$spaddr =    $_POST['spaddr'];

$spphone =    $_POST['spphone'];

$sdob =    $_POST['sdob'];

$empstatus =    $_POST['empstatus'];

$employer =    $_POST['employer'];

$employerphone =    $_POST['employerphone'];

$employeraddr     =    $_POST['employeraddr'];

$idtype =    $_POST['idtype'];

$idnumber =    $_POST['idnumber'];

$issuedate =    $_POST['issuedate'];

$expirydate =    $_POST['expirydate'];

$placeofissue =    $_POST['placeofissue'];

$sfund =    $_POST['sfund']; 

$income =    $_POST['income'];

$purpose =    $_POST['purpose'];

$trustname =    $_POST['trustname']; 

$contribution =    $_POST['contribution']; 

$uid =    $_POST['uid']; 

$url1 = '../education-trust-completed.php?a=successfull';

$url2 = '../education-trust.php?a=error';



mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO education_form (uid, fullname, address, mailingaddr, email, maidenname, phoneno, aphoneno, maritalstatus, gender, dob, state, nationality, lga, spname, spaddr, spphone, sdob, empstatus,employer, employerphone , employeraddr, idtype, idnumber, issuedate, expirydate, placeofissue, sfund, income, purpose, trustname, contribution, datecreated) VALUES ('$uid', '$fullname', '$addr', '$mailingaddr', '$email', '$maidenname', '$phone', '$aphone', '$maritalstatus', '$gender', '$dob', '$state', '$nationality', '$lga', '$spname','$spaddr', '$spphone', '$sdob', '$empstatus', '$employer', '$employerphone', '$employeraddr', '$idtype', '$idnumber', '$issuedate', '$expirydate', '$placeofissue', '$sfund','$income','$purpose','$trustname','$contribution',NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



