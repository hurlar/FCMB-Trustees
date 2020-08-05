<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$identificationtype = $_POST['identificationtype']; 
$idnumber =     $_POST['idnumber'];
$issuedate =    $_POST['issuedate'];
$expirydate =    $_POST['expirydate'];
$placeofissue =    $_POST['placeofissue'];
$iuid =    $_POST['iuid'];

$_SESSION['identificationtype'] = $identificationtype;
$_SESSION['idnumber'] =     $idnumber;
$_SESSION['issuedate'] =    $issuedate;
$_SESSION['expirydate'] =    $expirydate;
$_SESSION['placeofissue'] =    $placeofissue;

    //$search  = array('&', '-', ' ', '.');
    //$replace = array('');

    //if(!ctype_alpha(str_replace($search,$replace,$sfname))){
       // header("Location: ../marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($sphoneno)){
        //header("Location: ../marital-info.php?a=numbersonly");
        //exit();
    //}else{

$identificationtype = trim($identificationtype);
$idnumber =     trim($idnumber);
$issuedate =    trim($issuedate);
$expirydate =    trim($expirydate);
$placeofissue =    trim($placeofissue);

$identificationtype = stripslashes($identificationtype);
$idnumber =     stripslashes($idnumber);
$issuedate =    stripslashes($issuedate);
$expirydate =    stripslashes($expirydate);
$placeofissue =    stripslashes($placeofissue);

$identificationtype = mysqli_real_escape_string($conn, $identificationtype);
$idnumber =     mysqli_real_escape_string($conn, $idnumber);
$issuedate =    mysqli_real_escape_string($conn, $issuedate);
$expirydate =    mysqli_real_escape_string($conn, $expirydate);
$placeofissue =    mysqli_real_escape_string($conn, $placeofissue);

$url1 = '../simplewill-marital-info.php?a=successful';
$url2 = '../simplewill-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO identification_tb (`uid`, `type`, `idnumber`,`issuedate`,`expirydate`,`issueplace`) VALUES ('$iuid', '$identificationtype', '$idnumber', '$issuedate', '$expirydate', '$placeofissue')";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
unset($_SESSION["identificationtype"]);
unset($_SESSION["idnumber"]);
unset($_SESSION["issuedate"]);
unset($_SESSION["expirydate"]);
unset($_SESSION["placeofissue"]);

header("Location: $url1");
}
//}
?>

