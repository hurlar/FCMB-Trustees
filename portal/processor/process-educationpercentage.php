<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$educationpercentage = $_POST['educationpercentage']; 
$percentagesharingid = $_POST['percentagesharingid']; 

//$url1 = '../education-beneficiary.php?a=successful';
$url2 = '../education-beneficiary.php?a=error';
$url3 = '../education-beneficiary.php?a=update';

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_digit($educationpercentage)){
        header("Location: ../education-beneficiary.php?a=numbersonly");
        exit();
    }else{
mysqli_select_db($conn, $database_conn);
$query_update = "UPDATE education_beneficiary SET `percentage` = '$educationpercentage' WHERE `id` = '$percentagesharingid' ";
$update = mysqli_query($conn, $query_update) or die(mysqli_error($conn));
if ($update) {
    header("Location: $url3"); 
}else{
header("Location: $url2"); 
}
}
?>

