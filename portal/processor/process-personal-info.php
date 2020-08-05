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

$phoneno =    $_POST['phoneno'];

$aphoneno =    $_POST['altphoneno'];

$msg =    $_POST['message'];

$city =    $_POST['city'];

$rstate =    $_POST['rstate'];

$lga =    $_POST['lga'];

$uid =    $_POST['uid']; 

$estatus =    $_POST['estatus'];

$employer =    $_POST['employer'];

$employeraddr =    $_POST['employeraddr'];

$employerphone =    $_POST['employerphone'];

    $search  = array('&', '-', ' ', '.', '+', '()');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$fname))){
        header("Location: ../personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_alpha(str_replace($search,$replace,$lname))){
        header("Location: ../personal-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($phoneno)){
        header("Location: ../personal-info.php?a=numbersonly");
        exit();
    }else{

$fname = trim($fname);

$mname = trim($mname);

$lname = trim($lname);

$phoneno = trim($phoneno);

$aphoneno = trim($aphoneno);

$msg = trim($msg);

$city = trim($city);

$lga =    trim($lga);

$employer =    trim($employer);

$employeraddr =    trim($employeraddr);

$employerphone =    trim($employerphone);



$fname = stripslashes($fname);

$mname = stripslashes($mname);

$lname = stripslashes($lname);

$phoneno = stripslashes($phoneno);

$aphoneno = stripslashes($aphoneno);

$msg = stripslashes($msg);

$city = stripslashes($city);

$lga =    stripslashes($lga);

$employer =    stripslashes($employer);

$employeraddr =    stripslashes($employeraddr);

$employerphone =    stripslashes($employerphone);



$fname = mysqli_real_escape_string($conn, $fname);

$mname = mysqli_real_escape_string($conn, $mname);

$lname = mysqli_real_escape_string($conn, $lname);

$phoneno = mysqli_real_escape_string($conn, $phoneno);

$aphoneno = mysqli_real_escape_string($conn, $aphoneno);

$msg = mysqli_real_escape_string($conn, $msg);

$city = mysqli_real_escape_string($conn, $city);

$lga =    mysqli_real_escape_string($conn, $lga);

$employer =    mysqli_real_escape_string($conn, $employer);

$employeraddr =    mysqli_real_escape_string($conn, $employeraddr);

$employerphone =    mysqli_real_escape_string($conn, $employerphone);

$fname = ucfirst($fname);

$mname = ucfirst($mname);

$lname = ucfirst($lname);

$url1 = '../marital-info.php';

$url2 = '../personal-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql1 = "SELECT `id`,`uid` FROM personal_info WHERE uid = '$uid' ";
$result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
$total = mysqli_fetch_assoc($result1); 
if($total == TRUE){
    $sql3 = "UPDATE personal_info SET salutation = '$salutation', fname = '$fname', mname = '$mname', lname = '$lname', dob = '$dob', gender = '$gender', nationality = '$nationality', state = '$state', phone = '$phoneno', aphone = '$aphoneno', msg = '$msg', city = '$city', rstate = '$rstate', lga = '$lga', employment_status = '$estatus', employer = '$employer', employerphone = '$employerphone', employeraddr = '$employeraddr' WHERE uid = $uid";
         $result_sql3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
        if($result_sql3 == TRUE){
            $sql4 = "UPDATE users SET fname = '$fname', lname = '$lname', phone = '$phoneno', gender = '$gender' WHERE id = '$uid' ";
            $result_sql4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
                header("Location: $url1"); 
    exit();
        }

}else{$sql="INSERT INTO personal_info (salutation, fname, mname, lname, dob, gender, nationality, state, phone,aphone,msg,city,rstate,lga,uid,datecreated,employment_status, employer, employeraddr, employerphone) VALUES ('$salutation', '$fname', '$mname', '$lname', '$dob', '$gender', '$nationality', '$state', '$phoneno', '$aphoneno', '$msg', '$city', '$rstate','$lga', '$uid', NOW(), '$estatus', '$employer', '$employeraddr', '$employerphone') ";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result){
$sql2 = "UPDATE users SET fname = '$fname', lname = '$lname', phone = '$phoneno', gender = '$gender' WHERE id = '$uid' ";
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

header("Location: $url1"); 

} else {

header("Location: $url2");

}

}

}

?>



