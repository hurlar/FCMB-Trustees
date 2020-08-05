<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editbeneficiarytitle = $_POST['editbeneficiarytitle']; 
$editbeneficiaryname =     $_POST['editbeneficiaryname'];
$editbeneficiarydob =    $_POST['editbeneficiarydob'];
$editbeneficiaryrelationship =    $_POST['editbeneficiaryrelationship'];
$editbeneficiaryid =    $_POST['editbeneficiaryid'];

//echo $btitle.''.$bfname; exit();

$url1 = '../reserve-marital-info.php?a=update';
$url2 = '../reserve-marital-info.php?a=error';


mysqli_select_db($conn, $database_conn);
$sql2 = "UPDATE reserve_beneficiary SET `title` = '$editbeneficiarytitle', `fullname` = '$editbeneficiaryname', rtionship = '$editbeneficiaryrelationship', dob = '$editbeneficiarydob' WHERE `id` = '$editbeneficiaryid' ";  
$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

if($result2){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

