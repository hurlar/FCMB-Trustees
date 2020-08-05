<?php
session_start();
ob_start();
require_once('../Connections/conn.php');

$edtidentificationtype = $_POST['edtidentificationtype']; 
$edtidnumber =     $_POST['edtidnumber'];
$edtissuedate =    $_POST['edtissuedate'];
$edtexpirydate =    $_POST['edtexpirydate'];
$edtplaceofissue =    $_POST['edtplaceofissue'];
$edtidentificationid =    $_POST['edtidentificationid'];

   // $search  = array('&', '-', ' ', '.');
    //$replace = array('');

    //if(!ctype_alpha(str_replace($search,$replace,$edtnextofkinfullname))){
      //  header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_alpha(str_replace($search,$replace,$edtnextofkinmaidenname//))){
        //header("Location: ../simplewill-marital-info.php?a=lettersonly");
        //exit();
    //}elseif(!ctype_digit($edtnextofkinphone)){
      //  header("Location: ../simplewill-marital-info.php?a=numbersonly");
        //exit();
    //}else{
        
$edtidentificationtype = trim($edtidentificationtype);
$edtidnumber =     trim($edtidnumber);
$edtissuedate =    trim($edtissuedate);
$edtexpirydate =    trim($edtexpirydate);
$edtplaceofissue =    trim($edtplaceofissue);

$edtidentificationtype = stripslashes($edtidentificationtype);
$edtidnumber =     stripslashes($edtidnumber);
$edtissuedate =    stripslashes($edtissuedate);
$edtexpirydate =    stripslashes($edtexpirydate);
$edtplaceofissue =    stripslashes($edtplaceofissue);

$edtidentificationtype = mysqli_real_escape_string($conn, $edtidentificationtype);
$edtidnumber =     mysqli_real_escape_string($conn, $edtidnumber);
$edtissuedate =    mysqli_real_escape_string($conn, $edtissuedate);
$edtexpirydate =    mysqli_real_escape_string($conn, $edtexpirydate);
$edtplaceofissue =    mysqli_real_escape_string($conn, $edtplaceofissue);

$url1 = '../simplewill-marital-info.php?a=update';
$url2 = '../simplewill-marital-info.php?a=error';

mysqli_select_db($conn, $database_conn);

$sql="UPDATE identification_tb SET `type` = '$edtidentificationtype', `idnumber` = '$edtidnumber', `issuedate` =  '$edtissuedate', `expirydate` = '$edtexpirydate', `issueplace` = '$edtplaceofissue' WHERE `id` = '$edtidentificationid' ";  

$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
//$lastid = mysql_insert_id();

if(!$result){
header("Location: $url2"); 
} else {
header("Location: $url1");
}
//}
?>

