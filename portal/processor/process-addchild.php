<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$cfname = $_POST['cfname']; 
$cgender =     $_POST['cgender'];
$cdob =    $_POST['cdob'];
//$cdob = date("Y-m-d", strtotime($cdob1)); 
$cuid =    $_POST['cuid']; 
$cstatus =    $_POST['cstatus'];
$age1 = date('Y', strtotime($cdob));
$currentyear = date('Y');
$realage =  $currentyear - $age1; 

$_SESSION['cfname'] = $cfname; 
$_SESSION['cgender'] = $cgender; 
$_SESSION['cdob'] = $cdob;

    $search  = array('&', '-', ' ', '.');
    $replace = array('');
if(!ctype_alpha(str_replace($search,$replace,$cfname))){
        header("Location: ../marital-info.php?c=lettersonly");
        exit();    
}else{
mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT * FROM children_details WHERE uid = '$cuid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$rowacl  = mysqli_fetch_assoc($query_sql);

$totalacl = mysqli_num_rows($query_sql); 
if ($totalacl == TRUE) {
	$update1 = "UPDATE child_tb SET status = '$cstatus' WHERE uid = '$cuid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert1 = "INSERT INTO child_tb (uid, status) VALUES ('$cuid', '$cstatus') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
}

$url1 = '../marital-info.php?c=successful';
$url2 = '../marital-info.php?c=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO children_details (`uid`, `name`, `gender`,`dob`,`age`) VALUES ('$cuid', '$cfname', '$cgender', '$cdob', '$realage')";
$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
$childid = mysqli_insert_id($conn);

if(!$result){
header("Location: $url2");
} else {
mysqli_select_db($conn, $database_conn);
$insert6 = "INSERT INTO beneficiary_dump (uid,childid, fullname) VALUES ('$cuid', '$childid','$cfname') ";
$insert_run6 = mysqli_query($conn, $insert6) or die(mysqli_error($conn));
unset($_SESSION["cfname"]);
unset($_SESSION["cgender"]);
unset($_SESSION["cdob"]);
header("Location: $url1");
}
}

?>

