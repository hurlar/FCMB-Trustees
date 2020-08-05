<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$earningtype = $_POST['earningtype']; 
$note =     $_POST['others_note'];
$annualincome =    $_POST['annualincome'];
$sourceoffundid =    $_POST['sourceoffundid'];

   // $search  = array('&', '-', ' ', '.');
    //$replace = array('');

    //if(!ctype_alpha(str_replace($search,$replace,$nextofkinfullname))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_alpha(str_replace($search,$replace,$nextofkinmothername))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($nextofkinphone)){
      //  header("Location: ../simplewill-marital-info.php?a=numbersonly");
        //exit();
    //}else{

$earningtype = trim($earningtype);
$note =     trim($note);
$annualincome =    trim($annualincome);

$earningtype = stripslashes($earningtype);
$note =     stripslashes($note);
$annualincome =    stripslashes($annualincome);

$earningtype = mysqli_real_escape_string($conn, $earningtype);
$note =     mysqli_real_escape_string($conn, $note);
$annualincome =    mysqli_real_escape_string($conn, $annualincome);

$url1 = '../education-marital-info.php?a=successful';
$url2 = '../education-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);
$sql="INSERT INTO sourceoffund (`uid`, `earning_type`, `note`, `annual_income`) VALUES ('$sourceoffundid', '$earningtype', '$note', '$annualincome' )";

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
//}
?>

