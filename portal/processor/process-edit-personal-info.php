<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$salutation = $_POST['salutation']; 
$fname =     $_POST['fname'];
$mname =    $_POST['mname'];
$lname =    $_POST['lname'];
$dob =    $_POST['dob'];
//$dob =date("Y-m-d", strtotime($dob1)); 
$gender =    $_POST['gender'];
$nationality =    $_POST['nationality'];
$state =    $_POST['state'];
$lga =    $_POST['lga'];
$phoneno =    $_POST['phoneno'];
$aphoneno =    $_POST['altphoneno'];
$msg =    $_POST['message'];
$city =    $_POST['city'];
$rstate =    $_POST['rstate'];
$estatus =    $_POST['estatus'];
$employer =    $_POST['employer'];
$employerphone =    $_POST['employerphone'];
$employeraddr =    $_POST['employeraddr'];
$uid =    $_POST['uid'];

$url1 = '../marital-info.php';
$url2 = '../edit-personal-info.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$fname))){
        header("Location: ../edit-personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$lname))){
        header("Location: ../edit-personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($phoneno)){
        header("Location: ../edit-personal-info.php?a=numbersonly");
        exit();
    }else{

mysqli_select_db($conn, $database_conn);
$sql="UPDATE personal_info SET salutation = '$salutation', fname = '$fname', mname = '$mname', lname = '$lname', dob = '$dob', gender = '$gender', lga = '$lga', nationality = '$nationality', state = '$state', phone = '$phoneno', aphone = '$aphoneno', msg = '$msg', city = '$city', rstate = '$rstate', employment_status = '$estatus',employer = '$employer',employerphone = '$employerphone',employeraddr = '$employeraddr', datecreated = NOW() WHERE uid = '$uid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
$sql2 = "UPDATE users SET fname = '$fname', lname = '$lname', gender = '$gender', phone = '$phoneno' WHERE id = '$uid' ";
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
header("Location: $url1"); 
} else {
header("Location: $url2");
}
}
?>

