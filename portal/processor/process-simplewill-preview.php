<?php

session_start();

ob_start();

require_once('../Connections/conn.php');

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

$nextofkinfullname =    $_POST['nextofkinfullname'];   

$nextofkintelephone =    $_POST['nextofkintelephone'];   

$nextofkinemail =    $_POST['nextofkinemail'];   

$nextofkinaddress =    $_POST['nextofkinaddress'];  

$nameofcompany =    $_POST['nameofcompany'];

$humanresourcescontacttelephone =    $_POST['humanresourcescontacttelephone']; 

$humanresourcescontactemailaddress =    $_POST['humanresourcescontactemailaddress'];

$url1 = '../simplewill-payment.php';

$url2 = '../simplewill-preview.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO simplewill_tb (uid, fullname, address, email, phoneno, aphoneno, gender, dob, state, nationality, lga, maidenname, identificationtype, idnumber, issuedate, expirydate, issueplace, employmentstatus, employer, employerphone, employeraddr, maritalstatus, spousename, spouseemail, spousephone, spousedob, spouseaddr, spousecity, spousestate, marriagetype, marriageyear, marriagecert, cityofmarriage, countryofmarriage, divorce, divorceyear, nextofkinfullname, nextofkintelephone, nextofkinemail, nextofkinaddress, nameofcompany, humanresourcescontacttelephone, humanresourcescontactemailaddress, datecreated) VALUES ('$uid', '$fullname', '$addr', '$email', '$phone', '$aphone', '$gender', '$dob', '$state', '$nationality', '$lga', '$maidenname', '$identificationtype', '$idnumber', '$issuedate', '$expirydate', '$issueplace', '$employmentstatus', '$employer', '$employerphone', '$employeraddr', '$maritalstatus', '$spousename', '$spouseemail', '$spousephone', '$spousedob', '$spouseaddr', '$spousecity', '$spousestate', '$marriagetype', '$marriageyear', '$marriagecert', '$cityofmarriage', '$countryofmarriage', '$divorce', '$divorceyear', '$nextofkinfullname', '$nextofkintelephone', '$nextofkinemail', '$nextofkinaddress', '$nameofcompany', '$humanresourcescontacttelephone', '$humanresourcescontactemailaddress', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



