<?php

session_start();

ob_start();

require_once('../Connections/conn.php');



$fullname = $_POST['fname'];  

$gender = $_POST['gender']; 

$ms = $_POST['ms']; 

$dob = $_POST['dob']; 

$addr =     $_POST['addr'];

$email =    $_POST['email'];

$phone =    $_POST['phone'];

$state =    $_POST['state'];

$lga =    $_POST['lga'];

$nation =    $_POST['nation'];

$nok =    $_POST['nok'];

$nokaddr =    $_POST['nokaddr'];

$spname =    $_POST['spname']; 

$spaddr =    $_POST['spaddr'];

$spphone =    $_POST['spphone'];

$sdob =    $_POST['sdob'];

$idtype =    $_POST['idtype'];

$issuedate =    $_POST['issuedate'];

$expirydate =    $_POST['expirydate'];

$uid =    $_POST['uid'];

$url1 = '../reserve-trust-completed.php?a=successfull';

$url2 = '../reserve-trust.php.php?a=error';



mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO reserve_form (uid, fullname, gender, maritalstatus, dob, address, email, phoneno, state, lga, nationality, kin, kinaddr, spname, spaddr, spphone,sdob, idtype, dateissued, expirydate, datecreated) VALUES ('$uid', '$fullname', '$gender', '$ms', '$dob', '$addr', '$email', '$phone', '$state', '$lga', '$nation', '$nok', '$nokaddr','$spname', '$spaddr', '$spphone', '$sdob', '$idtype', '$issuedate', '$expirydate', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



