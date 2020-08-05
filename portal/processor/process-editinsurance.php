<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$editinsurancecompany = $_POST['editinsurancecompany']; 
$editinsurancetype =     $_POST['editinsurancetype'];
$editinsurancename =    $_POST['editinsurancename'];
$editinsurancevalue =    $_POST['editinsurancevalue'];
$editinsuranceid =    $_POST['editinsuranceid'];

$url1 = '../my-assets.php?a=update';
$url2 = '../my-assets.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="UPDATE assets_tb SET `insurance_company` = '$editinsurancecompany', `insurance_type` = '$editinsurancetype', `insurance_owner` = '$editinsurancename', `insurance_facevalue` = '$editinsurancevalue' WHERE id = '$editinsuranceid' ";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($result == TRUE){

header("Location: $url1"); 
} else {
header("Location: $url2");
}
?>

