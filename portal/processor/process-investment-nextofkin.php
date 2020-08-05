<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$nextofkinfullname = $_POST['nextofkinfullname']; 
$nextofkinaddress =    $_POST['nextofkinaddress'];
$nextofkinphone =    $_POST['nextofkinphone'];
$nextofkinemail =    $_POST['nextofkinemail'];
$cuid =    $_POST['cuid'];

$_SESSION['nextofkinfullname'] = $nextofkinfullname;
$_SESSION['nextofkinaddress'] =    $nextofkinaddress;
$_SESSION['nextofkinphone'] =    $nextofkinphone;
$_SESSION['nextofkinemail'] =    $nextofkinemail;
$_SESSION['cuid'] =    $cuid;

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$nextofkinfullname))){
        header("Location: ../investment-marital-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($nextofkinphone)){
        header("Location: ../investment-marital-info.php?a=numbersonly");
        exit();
    }else{

$nextofkinfullname = trim($nextofkinfullname);
$nextofkinaddress =    trim($nextofkinaddress);
$nextofkinphone =    trim($nextofkinphone);
$nextofkinemail =    trim($nextofkinemail);

$nextofkinfullname = stripslashes($nextofkinfullname);
$nextofkinaddress =    stripslashes($nextofkinaddress);
$nextofkinphone =    stripslashes($nextofkinphone);
$nextofkinemail =    stripslashes($nextofkinemail);

$nextofkinfullname = mysqli_real_escape_string($conn, $nextofkinfullname);
$nextofkinaddress =    mysqli_real_escape_string($conn, $nextofkinaddress);
$nextofkinphone =    mysqli_real_escape_string($conn, $nextofkinphone);
$nextofkinemail =    mysqli_real_escape_string($conn, $nextofkinemail);

$url1 = '../investment-marital-info.php?a=successful';
$url2 = '../investment-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO investment_nextofkin (`uid`, `fullname`, `address`,        `telephone`, `email`, `dateposted`) VALUES ('$cuid', '$nextofkinfullname', '$nextofkinaddress', '$nextofkinphone', '$nextofkinemail', NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["nextofkinfullname"]);
unset($_SESSION["nextofkinaddress"]);
unset($_SESSION["nextofkinphone"]);
unset($_SESSION["nextofkinemail"]);

header("Location: $url1");
}
}
?>

