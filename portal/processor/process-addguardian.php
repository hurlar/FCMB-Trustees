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
$gstipend = $_POST['gstipend'];
$uid = $_POST['uid'];
$childid = $_POST['childid'];

$_SESSION['gtitle'] = $gtitle;
$_SESSION['gname'] = $gname;
$_SESSION['gemail'] = $gemail;
$_SESSION['gphoneno'] = $gphoneno;
$_SESSION['grelationship'] = $grelationship;
$_SESSION['gaddr'] = $gaddr;
$_SESSION['gcity'] = $gcity;
$_SESSION['gstate'] = $gstate;
$_SESSION['gstipend'] = $gstipend;
$_SESSION['uid'] = $uid;
$_SESSION['childid'] = $childid;

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$gname))){
        header("Location: ../add-guardian.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($gphoneno)){
        header("Location: ../add-guardian.php?a=numbersonly");
        exit();
    }else{
$gtitle = trim($gtitle);
$gname = trim($gname);
$gemail = trim($gemail);
$gphoneno = trim($gphoneno);
$grelationship = trim($grelationship);
$gaddr = trim($gaddr);
$gcity = trim($gcity);
$gstate = trim($gstate);
$gstipend = trim($gstipend);


$gtitle = stripslashes($gtitle);
$gname = stripslashes($gname);
$gemail = stripslashes($gemail);
$gphoneno = stripslashes($gphoneno);
$grelationship = stripslashes($grelationship);
$gaddr = stripslashes($gaddr);
$gcity = stripslashes($gcity);
$gstate = stripslashes($gstate);
$gstipend = stripslashes($gstipend);


$gtitle = mysqli_real_escape_string($conn, $gtitle);
$gname = mysqli_real_escape_string($conn, $gname);
$gemail = mysqli_real_escape_string($conn, $gemail);
$gphoneno = mysqli_real_escape_string($conn, $gphoneno);
$grelationship = mysqli_real_escape_string($conn, $grelationship);
$gaddr = mysqli_real_escape_string($conn, $gaddr);
$gcity = mysqli_real_escape_string($conn, $gcity);
$gstate = mysqli_real_escape_string($conn, $gstate);
$gstipend = mysqli_real_escape_string($conn, $gstipend);


$url1 = '../add-guardian.php?a=successful';
$url2 = '../add-guardian.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql = "UPDATE children_details SET title = '$gtitle', guardianname = '$gname', rtionship = '$grelationship', email = '$gemail' , phone = '$gphoneno', addr = '$gaddr', city = '$gcity', state = '$gstate', stipend = '$gstipend' WHERE id = '$childid' ";  
//$sql="INSERT INTO guardian_tb (`uid`, `childid`, `title`, `fullname`,`rtionship`,`email`,`phone`,`addr`,`city`,`state`,`stipend`,`datecreated`) VALUES ('$uid', '$childid', '$gtitle', '$gname', '$grelationship', '$gemail', '$gphoneno', '$gaddr', '$gcity', '$gstate','$gstipend', NOW())";

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
unset($_SESSION["gstipend"]);
unset($_SESSION["uid"]);
unset($_SESSION["childid"]);
header("Location: $url1");
}
}
?>

