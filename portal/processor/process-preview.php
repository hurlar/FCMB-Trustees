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

$employmentstatus =    $_POST['employmentstatus'];

$employer =    $_POST['employer'];

$employerphone =    $_POST['employerphone'];

$employeraddr =    $_POST['employeraddr'];

$maritalstatus =    $_POST['maritalstatus']; 

$spname =    $_POST['spname']; 

$spemail =    $_POST['spemail'];

$spphone =    $_POST['spphone'];

$sdob =    $_POST['sdob'];

$spaddr =    $_POST['spaddr'];

$spcity =    $_POST['spcity'];

$spstate =    $_POST['spstate'];

$marriagetype =    $_POST['marriagetype'];

$marriageyear =    $_POST['marriageyear'];

$marriagecert =    $_POST['marriagecert'];

$spcitym =    $_POST['spcitym'];

$spcountrym =    $_POST['spcountrym'];

$divorce      =    $_POST['divorce'];

$divorceyear =    $_POST['divorceyear'];

$addinfo =    $_POST['addinfo'];

$url1 = '../process-completed.php';

$url2 = '../preview.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO preview_will (uid, willtype, fullname, address, email, phoneno, aphoneno, gender, dob, state, nationality, lga, employmentstatus, employer, employerphone, employeraddr, maritalstatus, spname, spemail, spphone, sdob, spaddr, spcity, spstate, marriagetype, marriageyear, marriagecert, marriagecity, marriagecountry, divorce, divorceyear, addinfo, datecreated) VALUES ('$uid', '$willtype', '$fullname', '$addr', '$email', '$phone', '$aphone', '$gender', '$dob', '$state', '$nationality', '$lga', '$employmentstatus', '$employer', '$employerphone', '$employeraddr', '$maritalstatus', '$spname', '$spemail', '$spphone', '$sdob', '$spaddr', '$spcity', '$spstate', '$marriagetype', '$marriageyear', '$marriagecert', '$spcitym', '$spcountrym', '$divorce', '$divorceyear', '$addinfo', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){
$queryupdate = "UPDATE processflow_tb SET `progress2` = 'Yes' WHERE uid = '$uid' ";
$resultupdate = mysqli_query($conn, $queryupdate) or die(mysqli_error($conn));

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



