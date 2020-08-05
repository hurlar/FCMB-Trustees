<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtpurposeoftrust = $_POST['edtpurposeoftrust'];
$edtnameoftrust = $_POST['edtnameoftrust'];
$edtinitialcontribution = $_POST['edtinitialcontribution'];
$edttrustdeedid = $_POST['edttrustdeedid'];

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../trust-deed.php?a=update';
$url2 = '../trust-deed.php?a=error';
        
$edtpurposeoftrust = trim($edtpurposeoftrust);
$edtnameoftrust = trim($edtnameoftrust);
$edtinitialcontribution = trim($edtinitialcontribution);

$edtpurposeoftrust = stripslashes($edtpurposeoftrust);
$edtnameoftrust = stripslashes($edtnameoftrust);
$edtinitialcontribution = stripslashes($edtinitialcontribution);

$edtpurposeoftrust = mysqli_real_escape_string($conn, $edtpurposeoftrust);
$edtnameoftrust = mysqli_real_escape_string($conn, $edtnameoftrust);
$edtinitialcontribution = mysqli_real_escape_string($conn, $edtinitialcontribution);


mysqli_select_db($conn, $database_conn);
$sql="UPDATE trustdeed_tb SET `purposeoftrust` = '$edtpurposeoftrust', `nameoftrust` = '$edtnameoftrust', `initialcontribution` = '$edtinitialcontribution' WHERE id = '$edttrustdeedid' ";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if($result){
header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

