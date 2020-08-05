<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$gtitle = $_POST['ttitle'];
$gname = $_POST['tname'];
$gemail = $_POST['temail'];
$gphoneno = $_POST['tphoneno'];
$grelationship = $_POST['trelationship'];
$gaddr = $_POST['taddr'];
$gcity = $_POST['tcity'];
$gstate = $_POST['tstate'];
$uid = $_POST['tid'];

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

$url1 = '../add-trustees.php?a=successful';
$url2 = '../add-trustees.php?a=error';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');
    if(!ctype_alpha(str_replace($search,$replace,$gname))){
        header("Location: ../add-trustees.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($gphoneno)){
        header("Location: ../add-trustees.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO trustee_tb  (`uid`, `title`, `fullname`,`rtionship`,`email`,`phone`,`addr`,`city`,`state`,`datecreated`) VALUES ('$uid','$gtitle', '$gname', '$grelationship', '$gemail', '$gphoneno', '$gaddr', '$gcity', '$gstate', NOW())";

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

