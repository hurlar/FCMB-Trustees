<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$uid = $_POST['uid'];

$url1 = '../my-assets.php';
$url2 = '../secondary-beneficiary.php?a=denied';

//gets the total count from the beneficiary dump table for that user
mysqli_select_db($conn, $database_conn);
$querytotalbeneficiary = "SELECT `id`, `uid` FROM beneficiary_dump WHERE `uid` = '$uid' ";
$beneficiary = mysqli_query($conn, $querytotalbeneficiary) or die(mysqli_error($conn));
$totalbeneficiary = mysqli_num_rows($beneficiary);

//gets the total count from the alt. beneficiary table for that user
$queryaltbeneficiary = "SELECT `id`, `uid` FROM alt_beneficiary WHERE `uid` = '$uid' ";
$altbeneficiary = mysqli_query($conn, $queryaltbeneficiary) or die(mysqli_error($conn));
$totalaltbeneficiary = mysqli_num_rows($altbeneficiary);

if($totalbeneficiary != $totalaltbeneficiary){
    header("Location: $url2"); 
} else {
    header("Location: $url1");
}

?>