<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$btitle = $_POST['btitle']; 
$bfname =     $_POST['bfname'];
$bemail =    $_POST['bemail'];
$bphoneno =    $_POST['bphoneno'];
$brelationship =    $_POST['brelationship'];
$baddr =    $_POST['baddr'];
$bcity =    $_POST['bcity'];
$bstate =    $_POST['bstate'];
$buid =    $_POST['buid'];
$bdob =    $_POST['bdob'];

$_SESSION['btitle'] = $btitle;
$_SESSION['bfname'] =     $bfname;
$_SESSION['bemail'] =    $bemail;
$_SESSION['bphoneno'] =    $bphoneno;
$_SESSION['brelationship'] =    $brelationship;
$_SESSION['baddr'] =    $baddr;
$_SESSION['bcity'] =    $bcity;
$_SESSION['bstate'] =    $bstate;
$_SESSION['buid'] =    $buid;
$_SESSION['bdob'] =    $bdob;

$url1 = '../simplewill-beneficiary.php?a=successful';
$url2 = '../simplewill-beneficiary.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$bfname))){
        header("Location: ../simplewill-beneficiary.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($bphoneno)){
        header("Location: ../simplewill-beneficiary.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO simplewill_beneficiary (`uid`, `title`, `fullname`,`rtionship`,`email`,`phone`,`addr`,`city`,`state`,`datecreated`,`dob`) VALUES ('$buid', '$btitle', '$bfname','$brelationship', '$bemail', '$bphoneno','$baddr', '$bcity', '$bstate', NOW(), '$bdob')";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["btitle"]);
unset($_SESSION["bfname"]);
unset($_SESSION["bemail"]);
unset($_SESSION["bphoneno"]);
unset($_SESSION["brelationship"]);
unset($_SESSION["baddr"]);
unset($_SESSION["bcity"]);
unset($_SESSION["bstate"]);
unset($_SESSION["buid"]);
unset($_SESSION["bdob"]);
header("Location: $url1");
}
}
?>

