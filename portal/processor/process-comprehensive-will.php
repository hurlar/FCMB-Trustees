<?php

session_start();

ob_start();

require_once('../Connections/conn.php');



$fullname = $_POST['fullname'];  

$addr =     $_POST['addr'];

$email =    $_POST['email'];

$phone =    $_POST['phone'];

$aphone =    $_POST['aphone'];

$employer =    $_POST['employer'];

$gender =    $_POST['gender'];

$dob =    $_POST['dob'];

$state =    $_POST['state'];

$nationality =    $_POST['nationality'];

//$lga =    $_POST['lga'];

//$city =    $_POST['city'];

//$rstate =    $_POST['rstate'];

$lga =    $_POST['lga'];

$spname =    $_POST['spname']; 

$spaddr =    $_POST['spaddr'];

$spphone =    $_POST['spphone'];

$sdob =    $_POST['sdob'];

$marriagetype =    $_POST['marriagetype'];

$marriageyear =    $_POST['marriageyear'];

$marriagecert =    $_POST['marriagecert'];

$divorce      =    $_POST['divorce'];

$divorceyear =    $_POST['divorceyear'];

$rsano =    $_POST['rsano'];

$pensionadmin =    $_POST['pensionadmin'];

$spinstruct =    $_POST['spinstruct'];

$addinfo =    $_POST['addinfo'];

$uid =    $_POST['uid'];

$url1 = '../comprehensive-will-completed.php?a=successfull';

$url2 = '../comprehensive-will.php?a=error';



mysqli_select_db($conn, $database_conn);

$sql="INSERT INTO comprehensive_will (uid, fullname, address, email, phoneno, aphoneno, employer, gender, dob, state, nationality, lga, spname, spaddr, spphone, sdob,marriagetype, marriageyear, marriagecert, divorce, divorceyear, rsano, pensionadmin, spinstruct, addinfo, datecreated) VALUES ('$uid', '$fullname', '$addr', '$email', '$phone', '$aphone', '$employer', '$gender', '$dob', '$state', '$nationality', '$lga', '$spname','$spaddr', '$spphone', '$sdob', '$marriagetype', '$marriageyear', '$marriagecert', '$divorce', '$divorceyear', '$rsano', '$pensionadmin', '$spinstruct', '$addinfo', NOW()) ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){

header("Location: $url1"); 

} else {

header("Location: $url2");

}

?>



