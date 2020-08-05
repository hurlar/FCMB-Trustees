<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtnextofkinfullname = $_POST['edtnextofkinfullname']; 
$edtnextofkinaddress =    $_POST['edtnextofkinaddress'];
$edtnextofkinphone =    $_POST['edtnextofkinphone'];
$edtnextofkinemail =    $_POST['edtnextofkinemail'];
$nextofkinid =    $_POST['nextofkinid'];

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$edtnextofkinfullname))){
        header("Location: ../reserve-marital-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($edtnextofkinphone)){
        header("Location: ../reserve-marital-info.php?a=numbersonly");
        exit();
    }else{
        
$edtnextofkinfullname = trim($edtnextofkinfullname);
$edtnextofkinaddress =    trim($edtnextofkinaddress);
$edtnextofkinphone =    trim($edtnextofkinphone);
$edtnextofkinemail =    trim($edtnextofkinemail);

$edtnextofkinfullname = stripslashes($edtnextofkinfullname);
$edtnextofkinaddress =    stripslashes($edtnextofkinaddress);
$edtnextofkinphone =    stripslashes($edtnextofkinphone);
$edtnextofkinemail =    stripslashes($edtnextofkinemail);

$edtnextofkinfullname = mysqli_real_escape_string($conn, $edtnextofkinfullname);
$edtnextofkinaddress =    mysqli_real_escape_string($conn, $edtnextofkinaddress);
$edtnextofkinphone =    mysqli_real_escape_string($conn, $edtnextofkinphone);
$edtnextofkinemail =    mysqli_real_escape_string($conn, $edtnextofkinemail);

$url1 = '../reserve-marital-info.php?a=update';
$url2 = '../reserve-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="UPDATE reserve_nextofkin SET `fullname` = '$edtnextofkinfullname', `address` =  '$edtnextofkinaddress', `telephone` = '$edtnextofkinphone', `email` = '$edtnextofkinemail' WHERE `id` = '$nextofkinid' ";  

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
}
?>

