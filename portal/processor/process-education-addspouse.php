<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$stitle = $_POST['stitle']; 
$sfname =     $_POST['sfname'];
$semail =    $_POST['semail'];
$sphoneno =    $_POST['sphoneno'];
$saltphoneno =    $_POST['saltphoneno'];
$saddr =    $_POST['saddr'];
$scity =    $_POST['scity'];
$sstate =    $_POST['sstate'];
$suid =    $_POST['suid'];
$status =    $_POST['status'];
$stype =    $_POST['stype'];
$syear =    $_POST['syear'];
$scert =    $_POST['scert'];
$sdob =    $_POST['sdob'];
$citym =    $_POST['citym'];
$countrym =    $_POST['countrym'];

$_SESSION['stitle'] = $stitle;
$_SESSION['sfname'] =     $sfname;
$_SESSION['semail'] =    $semail;
$_SESSION['sphoneno'] =    $sphoneno;
$_SESSION['saltphoneno'] =    $saltphoneno;
$_SESSION['saddr'] =    $saddr;
$_SESSION['scity'] =    $scity;
$_SESSION['sstate'] =    $sstate;
$_SESSION['suid'] =    $suid;
$_SESSION['status'] =    $status;
$_SESSION['stype'] =    $stype;
$_SESSION['syear'] =    $syear;
$_SESSION['scert'] =    $scert;
$_SESSION['sdob'] =    $sdob;
$_SESSION['citym'] =    $citym;
$_SESSION['countrym'] =    $countrym;

    $search  = array('&', '-', ' ', '.');
    $replace = array('');

    if(!ctype_alpha(str_replace($search,$replace,$sfname))){
        header("Location: ../education-marital-info.php?a=lettersonly");
        exit();
    }elseif(!ctype_digit($sphoneno)){
        header("Location: ../education-marital-info.php?a=numbersonly");
        exit();
    }else{

$stitle = trim($stitle);
$sfname =     trim($sfname);
$semail =    trim($semail);
$sphoneno =    trim($sphoneno);
$saltphoneno =    trim($saltphoneno);
$saddr =    trim($saddr);
$scity =    trim($scity);
$sstate =    trim($sstate);
$suid =    trim($suid);
$status =    trim($status);
$stype =    trim($stype);
$syear =    trim($syear);
$scert =    trim($scert);
$sdob =    trim($sdob);
$citym =    trim($citym);
$countrym =    trim($countrym);

$stitle = stripslashes($stitle);
$sfname =     stripslashes($sfname);
$semail =    stripslashes($semail);
$sphoneno =    stripslashes($sphoneno);
$saltphoneno =    stripslashes($saltphoneno);
$saddr =    stripslashes($saddr);
$scity =    stripslashes($scity);
$sstate =    stripslashes($sstate);
$suid =    stripslashes($suid);
$status =    stripslashes($status);
$stype =    stripslashes($stype);
$syear =    stripslashes($syear);
$scert =    stripslashes($scert);
$sdob =    stripslashes($sdob);
$citym =    stripslashes($citym);
$countrym =    stripslashes($countrym);

$stitle = mysqli_real_escape_string($conn, $stitle);
$sfname =     mysqli_real_escape_string($conn, $sfname);
$semail =    mysqli_real_escape_string($conn, $semail);
$sphoneno =    mysqli_real_escape_string($conn, $sphoneno);
$saltphoneno =    mysqli_real_escape_string($conn, $saltphoneno);
$saddr =    mysqli_real_escape_string($conn, $saddr);
$scity =    mysqli_real_escape_string($conn, $scity);
$sstate =    mysqli_real_escape_string($conn, $sstate);
$suid =    mysqli_real_escape_string($conn, $suid);
$status =    mysqli_real_escape_string($conn, $status);
$stype =    mysqli_real_escape_string($conn, $stype);
$syear =    mysqli_real_escape_string($conn, $syear);
$scert =    mysqli_real_escape_string($conn, $scert);
$sdob =    mysqli_real_escape_string($conn, $sdob);
$citym =    mysqli_real_escape_string($conn, $citym);
$countrym =    mysqli_real_escape_string($conn, $countrym);

//echo $uid.' '.$workorderid;
//exit();

$url1 = '../education-marital-info.php?a=successful';
$url2 = '../education-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql2 = "SELECT uid FROM marital_status WHERE uid = '$suid' "; 
$query_sql = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$totalacl = mysqli_num_rows($query_sql); 
if ($totalacl == TRUE) {
	$update1 = "UPDATE marital_status SET status = '$status' WHERE uid = '$suid'"; 
	$update_run1 = mysqli_query($conn, $update1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=update");
	//exit();
}else{
	$insert1 = "INSERT INTO marital_status (uid, status) VALUES ('$suid', '$status') ";
	$insert_run1 = mysqli_query($conn, $insert1) or die(mysqli_error($conn));
	//header("Location: ../dashboard.php?a=insert");
}

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO spouse_tb (`uid`, `title`, `fullname`,`email`,`phoneno`,`altphoneno`,`addr`,`city`,`state`,`marriagetype`,`marriageyear`,`marriagecert`,`dob`,`citym`,`countrym`,`datecreated`) VALUES ('$suid', '$stitle', '$sfname', '$semail', '$sphoneno', '$saltphoneno', '$saddr', '$scity', '$sstate','$stype','$syear','$scert','$sdob','$citym','$countrym', NOW())";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["stitle"]);
unset($_SESSION["sfname"]);
unset($_SESSION["semail"]);
unset($_SESSION["sphoneno"]);
unset($_SESSION["saltphoneno"]);
unset($_SESSION["saddr"]);
unset($_SESSION["scity"]);
unset($_SESSION["sstate"]);
unset($_SESSION["suid"]);
unset($_SESSION["status"]);
unset($_SESSION["stype"]);
unset($_SESSION["syear"]);
unset($_SESSION["scert"]);
unset($_SESSION["sdob"]);
unset($_SESSION["citym"]);
unset($_SESSION["countrym"]);
header("Location: $url1");
}
}
?>

