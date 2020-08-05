<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gtitle = $_POST['gtitle'];
$gname = $_POST['gname'];
$gemail = $_POST['gemail'];
$gphoneno = $_POST['gphoneno'];
$grelationship = $_POST['grelationship'];
$gaddr = $_POST['gaddr'];
$gcity = $_POST['gcity'];
$gstate = $_POST['gstate'];
$uid = $_POST['uid'];

$_SESSION['gtitle'] = $gtitle;
$_SESSION['gname'] = $gname;
$_SESSION['gemail'] = $gemail;
$_SESSION['gphoneno'] = $gphoneno;
$_SESSION['grelationship'] = $grelationship;
$_SESSION['gaddr'] = $gaddr;
$_SESSION['gcity'] = $gcity;
$_SESSION['gstate'] = $gstate;
$_SESSION['uid'] = $uid;

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../simplewill-beneficiary.php?a=successful';
$url2 = '../simplewill-beneficiary.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');
    if(!ctype_alpha(str_replace($search,$replace,$gname))){
        header("Location: ../simplewill-beneficiary.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($gphoneno)){
        header("Location: ../simplewill-beneficiary.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO simplewill_financial_guardian (`uid`, `title`, `fullname`,`rtionship`,`email`,`phone`,`addr`,`city`,`state`,`datecreated`) VALUES ('$uid','$gtitle', '$gname', '$grelationship', '$gemail', '$gphoneno', '$gaddr', '$gcity', '$gstate', NOW())";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["gtitle"]);
unset($_SESSION["gname"]);
unset($_SESSION["gemail"]);
unset($_SESSION["gphoneno"]);
unset($_SESSION["grelationship"]);
unset($_SESSION["gaddr"]);
unset($_SESSION["gcity"]);
unset($_SESSION["gstate"]);
unset($_SESSION["uid"]);
header("Location: $url1");
}
}
?>

